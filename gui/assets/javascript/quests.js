
var Controller = function() {
  var $this = this;
  var _private = {};
  var _ajax = new AjaxHelper();
  var _ui = new UiHelper();

  // Helper System Variables
  this.options = {

  }

  // constructor
  this.init = function() {
    $this.eventManager();
    $this.loadQuests();
  };

  this.eventManager = function() {
    $('body').on('click', '#quest_create_button', function(e){$this.showAddQuestModal(e);});
    $('body').on('click', '#quest_scan_button', function(e){$this.questScan(e);});
    $('body').on('click', '.quest_record', function(e){$this.showQuestDetail(e);});
  };

  this.loadQuests = function() {
    // Send Ajax Request
    _ajax.sendPostFromCard($('#quest_list_card'), 'quest_load_player_quests', {}, function(objResponse) {
      if(objResponse.status) {
        $('#quest_list_card').find('tbody').html('');
        for(var numIndex in objResponse.quest_data) {
          var objQuest = objResponse.quest_data[numIndex];

          // Build HTML Record
          var strHtml = '';
          strHtml += '<tr class="quest_record" data-finish="' + objQuest.is_finish + '" data-title="' + objQuest.title + '" data-description="' + escape(objQuest.description) + '" data-quest-code="' + objQuest.quest_code + '" data-quest-id="' + objQuest.id + '" style="cursor: pointer;">';
          strHtml += '  <td>' + objQuest.title + '</td>';
          strHtml += '  <td>' + objQuest.experience + '</td>';
          strHtml += '  <td>' + objQuest.priority + '</td>';
          strHtml += '  <td>' + objQuest.timer + '</td>';
          strHtml += '  <td>';
          if(objQuest.is_finish == 0) {
            strHtml += 'OPEN';
          } else {
            if(objQuest.is_canceled == 1) {
              strHtml += '<span class="text-danger">CANCELED</span>';
            } else {
              strHtml += '<span class="text-success">SUCCESS</span>';
            }
          }
          strHtml += '  </td>';
          strHtml += '</tr>';
          $('#quest_list_card').find('tbody').append(strHtml);
        }
      }
    });
  };

  this.questScan = function() {
    alert('SCANNED');
  };

  this.showAddQuestModal = function() {
    var strHtmlModal = $this.getAddQuestModalHtml();
    _ui.showModal('Add Quest', strHtmlModal, [{text: 'Add Quest', callback: $this.addQuest}, {text: 'Close'}], function(elModal) {
      elModal.find('.wysiwyg').summernote();
    });
  };

  this.addQuest = function(e) {
    // Get Quest Data
    var objQuest = {
      title: $('#quest_title').val(),
      time_days: $('#quest_day').val(),
      time_hours: $('#quest_hour').val(),
      time_minutes: $('#quest_minute').val(),
      priority: $('#quest_priority').val(),
      description: $(e.target).closest('.modal').find('.wysiwyg').val()
    }

    // Send Ajax Request
    _ajax.sendPostFromCard($('#quest_add_card'), 'quest_add_new', objQuest, function(objResponse) {
      $('.form-group').find('small').html('');
      if(!objResponse.status) {
        $('#' + objResponse.field + '_help').html(objResponse.message);
      } else {
          $('#qrcode').remove();
          _ui.showModal('Add Quest', 'New Quest has been created.<hr><center><b>Quest Code</b><br><span id="qrcode"></span></center>', [{text: 'Close'}], function(elModal) {
            // Create Quest Code
            new QRCode($('#qrcode')[0], {
              text: objResponse.quest_code,
              width: 128,
              height: 128,
              colorDark : "#000000",
              colorLight : "#ffffff",
              correctLevel : QRCode.CorrectLevel.H
            });
          });

          $this.loadQuests();
          $(e.target).closest('.modal').modal('hide');
      }
    });
  };

  this.showQuestDetail = function(e) {
    var strId = $(e.target).closest('tr').data('quest-id');
    var strFinish = $(e.target).closest('tr').data('finish');
    var strTitle = $(e.target).closest('tr').data('title');
    var strDescription = unescape($(e.target).closest('tr').data('description')) + '<hr><center><b>Quest Code</b><br><span id="qrcode"></span></center>';
    var strQuestcode = $(e.target).closest('tr').data('quest-code');

    // Generate Buttons
    var objButtons = [{text: 'Close'}];
    if(strFinish != 1) {
      objButtons = [
                {text: 'Accomplish', color: 'success', data: strId, callback: $this.accomplishQuest},
                {text: 'Cancel', color: 'danger', data: strId, callback: $this.cancelQuest},
                {text: 'Delegate', color: 'secondary', data: strId, callback: $this.delegateQuest},
                {text: 'Close'}
              ];
    }

    $('#qrcode').remove();
    _ui.showModal(strTitle, strDescription, objButtons, function(elModal) {
      // Create Quest Code
      new QRCode($('#qrcode')[0], {
        text: strQuestcode,
        width: 128,
        height: 128,
        colorDark : "#000000",
        colorLight : "#ffffff",
        correctLevel : QRCode.CorrectLevel.H
      });
    });
  };

  this.cancelQuest = function(e) {
    // Get Accomplish Quest Data
    var objData = {
      quest_id: $(e.target).data('data')
    }

    // Send Ajax Request
    _ajax.sendPostFromCard($('#quest_list_card'), 'quest_cancel', objData, function(objResponse) {
      if(!objResponse.status) {
        // Show Error message
        _ui.showModal('Error', objResponse.msg, [{text: 'Close'}]);
      } else {
        // Show accomplishement
        _ui.showModal('Quest Canceled', 'Quest is canceled.', [{text: 'Close'}]);
        $this.loadQuests();
        $(e.target).closest('.modal').modal('hide');
      }
    });
  };

  this.accomplishQuest = function(e) {
    // Get Accomplish Quest Data
    var objData = {
      quest_id: $(e.target).data('data')
    }

    // Send Ajax Request
    _ajax.sendPostFromCard($('#quest_list_card'), 'quest_accomplish', objData, function(objResponse) {
      if(!objResponse.status) {
        // Show Error message
        _ui.showModal('Error', objResponse.msg, [{text: 'Close'}]);
      } else {
        // Show accomplishement
        var strAccomplishHtml = $this.getAccomplishHtml(objResponse.items, objResponse.experience, objResponse.level_up);
        _ui.showModal('Quest Accomplished', strAccomplishHtml, [{text: 'Close'}]);
        $this.loadQuests();
        $(e.target).closest('.modal').modal('hide');
      }
    });
  };

  this.delegateQuest = function(e) {
    // Get Accomplish Quest Data
    var objData = {
      quest_id: $(e.target).data('data')
    }
    $(e.target).closest('.modal').modal('hide');

    // Send Ajax Request
    _ajax.sendPost('quest_delegate_players', {}, function(objResponse) {
      if(!objResponse.status) {
        // Show Error message
        _ui.showModal('Error', objResponse.msg, [{text: 'Close'}]);
      } else {

        // Build Callback Function
        var fncCallback = function(e) {
          // Get Delegate Quest Data
          var objDelegate = {
            quest_id: objData.quest_id,
            to_player: $(e.target).closest('.modal').find('select').val()
          };
          $(e.target).closest('.modal').modal('hide');

          // Send Delegate Request
          _ajax.sendPost('quest_delegate', objDelegate, function(objResponse) {
            if(!objResponse.status) {
              // Show Error message
              _ui.showModal('Error', objResponse.msg, [{text: 'Close'}]);
            } else {
              _ui.showModal('quest Delegate', 'Your Quest is now delegated.', [{text: 'Close'}]);
              $this.loadQuests();
            }
          });
        };

        // Show Delegate window
        var strHtml = $this.getDelegateHtml(objResponse.fractions);
        _ui.showModal('Delegate Quest', strHtml, [{text: 'Delegate', color: 'success', callback: fncCallback},{text: 'Close'}]);
      }
    });
  };

  this.getAddQuestModalHtml = function() {
    // Remove Existing Fields
    $('#quest_title').remove();
    $('#quest_day').remove();
    $('#quest_hour').remove();
    $('#quest_minute').remove();
    $('#quest_priority').remove();
    $('.wysiwyg').remove();

    // Create New HTML Content
    var strHtml = '';
    strHtml += '<form>';
    strHtml += '  <div class="form-group">';
    strHtml += '    <label for="quest_title">Quest Title</label>';
    strHtml += '    <input type="text" class="form-control" id="quest_title" aria-describedby="title_help" placeholder="Enter Quest Title">';
    strHtml += '    <small id="quest_title_help" class="form-text text-danger"></small>';
    strHtml += '  </div>';
    strHtml += '  <div class="form-group">';
    strHtml += '    <label for="title">Priority</label>';
    strHtml += '    <select id="quest_priority" class="form-control">';
    strHtml += '      <option value="0" selected>Low</option><option value="1">Medium</option><option value="2">High</option><option value="3">Superior</option>';
    strHtml += '    </select>';
    strHtml += '    <small id="title_help" class="form-text text-danger"></small>';
    strHtml += '  </div>';
    strHtml += '  <div class="form-group">';
    strHtml += '    <label for="exampleInputEmail1">Timer</label>';
    strHtml += '    <table width="100%">';
    strHtml += '      <tr>';
    strHtml += '        <td>';
    strHtml += '          <select id="quest_day" class="form-control">';
    strHtml += '            <option value="0" selected>0 Day</option><option value="1">1 Day</option><option value="2">2 Days</option><option value="3">3 Days</option><option value="4">4 Days</option><option value="5">5 Days</option><option value="6">6 Days</option><option value="7">7 Days</option>';
    strHtml += '          </select>';
    strHtml += '        </td>';
    strHtml += '        <td>';
    strHtml += '          <select id="quest_hour" class="form-control">';
    strHtml += '            <option value="0" selected>0 Hour</option><option value="1">1 Hour</option><option value="2">2 Hours</option><option value="3">3 Hours</option><option value="4">4 Hours</option><option value="5">5 Hours</option><option value="6">6 Hours</option><option value="7">7 Hours</option><option value="8">8 Hours</option><option value="9">9 Hours</option>';
    strHtml += '            <option value="10">10 Hours</option><option value="11">11 Hours</option><option value="12">12 Hours</option><option value="13">13 Hours</option><option value="14">14 Hours</option><option value="15">15 Hours</option><option value="16">16 Hours</option><option value="17">17 Hours</option><option value="18">18 Hours</option><option value="19">19 Hours</option>';
    strHtml += '            <option value="20">20 Hours</option><option value="21">21 Hours</option><option value="22">22 Hours</option><option value="23">23 Hours</option>';
    strHtml += '          </select>';
    strHtml += '        </td>';
    strHtml += '        <td>';
    strHtml += '          <select id="quest_minute" class="form-control">';
    strHtml += '            <option value="0" selected>0 Minute</option><option value="1">1 Minute</option><option value="5">5 Minutes</option><option value="10">10 Minutes</option><option value="15">15 Minutes</option><option value="20">20 Minutes</option><option value="25">25 Minutes</option><option value="30">30 Minutes</option>';
    strHtml += '            <option value="35">35 Minutes</option><option value="40">40 Minutes</option><option value="45">45 Minutes</option><option value="50">50 Minutes</option><option value="55">55 Minutes</option>';
    strHtml += '          </select>';
    strHtml += '        </td>';
    strHtml += '      </tr>';
    strHtml += '    </table>';
    strHtml += '  </div>';
    strHtml += '  <div class="form-group">';
    strHtml += '    <label for="quest_title">Description</label>';
    strHtml += '    <textarea id="quest_description" class="wysiwyg" name="editordata"></textarea>';
    strHtml += '    <small id="quest_description_help" class="form-text text-danger"></small>';
    strHtml += '  </div>';
    strHtml += '</form>';
    return strHtml;
  };

  this.getDelegateHtml = function(objFractions) {
    var strHtml = '';
    strHtml += '<form>';
    strHtml += '   <div class="form-group">';
    strHtml += '      <label for="exampleInputEmail1">Delegate Quest to Player:</label>';
    strHtml += '      <select class="form-control">';
    for(var numFractionIndex in objFractions) {
      for(var numPlayerIndex in objFractions[numFractionIndex]) {
        var objPlayer = objFractions[numFractionIndex][numPlayerIndex];
        if(numPlayerIndex == 0) {
          strHtml += '  <optgroup label="' + objPlayer.fraction + '">';
        }
        strHtml += '    <option value="' + objPlayer.id + '">' + objPlayer.name + '</option>';
      }
      strHtml += '      </optgroup>';
    }
    strHtml += '      </select>';
    strHtml += '   </div>';
    strHtml += '</form>';

    return strHtml;
  };

  this.getAccomplishHtml = function(objItems, numExperience, objLevelUp) {
    // [{"name":"Der Arkanium Blocker des ultimativen Erzengels","type":"shield","image_key":"","rarity":5,"stats":{"health":0,"attack":0,"defence":114,"agility":0,"speed":0},"stats_factor":{"health":5,"attack":9,"defence":10,"agility":6}}]
    var strUudi = _ui.uuid();

    // Indicators
    var strHtml = '';
    strHtml += '<div id="carousel-' + strUudi + '" class="carousel slide" data-ride="carousel" data-interval="false" style="min-height: 350px;">';
    strHtml += '  <ol class="carousel-indicators" style="padding: 5px; background-color: #555555; border-radius: 10px;">';
    strHtml += '     <li data-target="#carousel-' + strUudi + '" data-slide-to="0" class="active"></li>';
    for(var numIndex in objItems) {
      strHtml += '   <li data-target="#carousel-' + strUudi + '" data-slide-to="' + (numIndex + 1) + '"></li>';
    }
    strHtml += '  </ol>';

    // Experience & Level UP
    strHtml += '  <div class="carousel-inner">';
    strHtml += '     <div class="carousel-item active">';
    strHtml += '        <center><span style="font-size: 16px; font-weight: bold">Reward</span></center><br>';
    strHtml += '        <center><span style="margin-top: 30px; font-size: 46px; color: #FFD700;">+' + numExperience + ' EXP</span></center>';
    if(objLevelUp.old == objLevelUp.new) {
      strHtml += '      <center><img src="assets/images/ui/treasure.png"></center>';
    } else {
      strHtml += '      <center><img src="assets/images/ui/levelup.png"></center>';
    }
    strHtml += '     </div>';

    // Content
    for(var numIndex in objItems) {
      var objItem = objItems[numIndex];
      var objRarity = $this.getRarityData(objItem.rarity);
      strHtml += '<div class="carousel-item">';
      strHtml += '   <center><span style="font-size: 16px; font-weight: bold; color: ' + objRarity.color + '">' + objItem.name + '</span><br>' + objRarity.text + '</center><br>';
      strHtml += '   <center><span style="margin-top: 30px; font-size: 46px; color: #FFD700;">';
      strHtml += '      <img style="width: 64px; height: 64px;" src="../api/item_get_base64_image.php?img_key=' + objItem.image_key + '&type=' + objItem.type + '">';
      strHtml += '   </span></center>';
      strHtml += '   <div style="margin-left: 30%; margin-top: 20px; width: 40%; padding: 10px; border: 1px solid #dddddd; border-radius: 10px;">';
      strHtml += '      <table style="width:100%;">';
      strHtml += '         <tr><th style="width: 40%;">Health</th> <td style="width: 30%; text-align: right;">' + objItem.stats.health + '</td> <td style="width: 30%; text-align: right;">' + objItem.stats_factor.health + '%</td></tr>';
      strHtml += '         <tr><th style="width: 40%;">Attack</th> <td style="width: 30%; text-align: right;">' + objItem.stats.attack + '</td> <td style="width: 30%; text-align: right;">' + objItem.stats_factor.attack + '%</td></tr>';
      strHtml += '         <tr><th style="width: 40%;">Defence</th> <td style="width: 30%; text-align: right;">' + objItem.stats.defence + '</td> <td style="width: 30%; text-align: right;">' + objItem.stats_factor.defence + '%</td></tr>';
      strHtml += '         <tr><th style="width: 40%;">Agility</th> <td style="width: 30%; text-align: right;">' + objItem.stats.agility + '</td> <td style="width: 30%; text-align: right;">' + objItem.stats_factor.agility + '%</td></tr>';
      strHtml += '      </table>';
      strHtml += '   </div>';
      strHtml += '</div>';
    }

    // Footer
    strHtml += '  </div>';
    strHtml += '  <a class="carousel-control-prev" href="#carousel-' + strUudi + '" role="button" data-slide="prev">';
    strHtml += '    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: #555555; border: 10px solid #555555; padding: 10px; border-radius: 30px;"></span>';
    strHtml += '    <span class="sr-only">Previous</span>';
    strHtml += '  </a>';
    strHtml += '  <a class="carousel-control-next" href="#carousel-' + strUudi + '" role="button" data-slide="next">';
    strHtml += '    <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: #555555; border: 10px solid #555555; padding: 10px; border-radius: 30px;"></span>';
    strHtml += '    <span class="sr-only">Next</span>';
    strHtml += '  </a>';
    strHtml += '</div>';

    return strHtml;
  };

  this.getRarityData = function(numRarity) {
    switch (numRarity) {
      case 0:
        return {color: 'rgba(200,200,200,1)', text: 'Poor'}
        break;
      case 1:
        return {color: 'rgba(200,200,200,1)', text: 'Common'}
        break;
      case 2:
        return {color: 'rgba(0,255,0,1)', text: 'Uncommon'}
        break;
      case 3:
        return {color: 'rgba(190,0,160,1)', text: 'Epic'}
        break;
      case 4:
        return {color: 'rgba(200,100,0,1)', text: 'Legendary'}
        break;
      case 5:
        return {color: 'rgba(199,199,0,1)', text: 'Supreme'}
        break;
    }
  }

  // Constructor Call
  $this.init();
};
var controller = new Controller();
