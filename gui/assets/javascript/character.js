
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

    // Enable ToolTips
    $(function() {$('[data-toggle="tooltip"]').tooltip({trigger: "hover"});});

    // Load Items
    $this.loadAllItems();
  };

  this.eventManager = function() {
    $('body').on('dblclick', 'div.item-container', function(e) {$this.equipItem(e);});
  };

  this.loadCharacter = function() {
    // Send Ajax Request
    _ajax.sendPostFromCard($('#player_card'), 'character_get_info', {}, function(objResponse) {
      if(objResponse.status) {
        // Send Player Name
        $('#player_name').html(objResponse.player.name);
        $('#player_image').attr('src', 'data:image/gif;base64, ' + objResponse.image_base64);

        // Send Level Informations
        $('#level_actual').html(objResponse.level_system.level);
        $('#level_exp').html(objResponse.level_system.exp);
        $('#level_next_exp').html(objResponse.level_system.next_level_exp);

        var numProgress = objResponse.level_system.next_level_progress;
        $('#level_progressbar_min').css('width', numProgress + '%');
        if(numProgress < 50) {
          $('#level_progressbar_min').html('');
          $('#level_progressbar_max').html(numProgress + '%');
          $('#level_progressbar_max').show();
        } else {
          $('#level_progressbar_min').html(numProgress + '%');
          $('#level_progressbar_max').html('');
          $('#level_progressbar_max').hide();
        }

        // Send Stats Information
        $('#stats_player_health').html(objResponse.stats.health);
        $('#stats_player_attack').html(objResponse.stats.attack);
        $('#stats_player_defence').html(objResponse.stats.defence);
        $('#stats_player_agility').html(objResponse.stats.agility);
        $('#stats_player_luck').html(objResponse.stats.luck);
      }
    });
  };

  this.loadAllItems = function() {
    $this.loadCharacter();

    $('#stats_item_health').html(0);
    $('#stats_item_attack').html(0);
    $('#stats_item_defence').html(0);
    $('#stats_item_agility').html(0);
    $('#stats_item_luck').html(0);

    $this.loadItems($('#weapon_card'), 'weapon');
    $this.loadItems($('#shield_card'), 'shield');
    $this.loadItems($('#armor_card'), 'armor');
    $this.loadItems($('#helmet_card'), 'helmet');
    $this.loadItems($('#special_card'), 'special');

    // Load ToolTip for all Items
    setTimeout(function(){
      $('div.tooltip').hide();
      $('[data-toggle="tooltip"]').tooltip({trigger: "hover"});
    }, 500);
  };

  this.loadItems = function(elCard, strType) {
    // Send Ajax Request
    _ajax.sendPostFromCard(elCard, 'item_load_equipment', {type: strType}, function(objResponse) {
      if(objResponse.status) {
        // Clear Container
        elCard.html('');
        $('#equipded_card card-body').html();

        // Render Items
        for(var numIndex in objResponse.items) {
          // Get Item
          var objItem = objResponse.items[numIndex];

          // Render ToolTip
          var strToolTip = "<div class='item-tooltip item-bg-rarity-" + objItem.rarity + "'>";
          strToolTip += "   <b class='item-color-rarity-" + objItem.rarity + "'>" + objItem.name + "</b>";
          strToolTip += "   <div class='item-color-rarity-" + objItem.rarity + "' style='font-size: 12px; border-top:1px solid; padding: 5px; margin-top: 5px;'>" + $this.getRarityText(objItem.rarity) + "</div>";
          strToolTip += "   <table class='tool-tip-table item-color-rarity-" + objItem.rarity + "'>";
          strToolTip += '      <tr><th>Health<th><td>' + objItem.fix_health + '</td> <td>' + objItem.factor_health + '%</td></tr>';
          strToolTip += '      <tr><th>Attack<th><td>' + objItem.fix_attack + '</td> <td>' + objItem.factor_attack + '%</td></tr>';
          strToolTip += '      <tr><th>Defence<th><td>' + objItem.fix_defence + '</td> <td>' + objItem.factor_defence + '%</td></tr>';
          strToolTip += '      <tr><th>Agility<th><td>' + objItem.fix_agility + '</td> <td>' + objItem.factor_agility + '%</td></tr>';
          strToolTip += '      <tr><th>Luck<th><td>' + objItem.fix_luck + '</td> <td>' + objItem.factor_luck + '%</td></tr>';
          strToolTip += '   </table>';
          strToolTip += '</div>';

          // Render Item
          var strHtml = '<div class="item-container float-left item-rarity-' + objItem.rarity + '" data-equiped="' + objItem.is_equiped + '" data-id="' + objItem.id + '" data-type="' + objItem.type + '" style="margin-bottom: 10px;" data-html="true" data-toggle="tooltip" data-placement="top" title="' + strToolTip + '">';
          strHtml += '   <img class="roundet" src="../api/item_get_base64_image.php?img_key=' + objItem.image_key + '&type=' + objItem.type + '">';
          strHtml += '</div>';

          // Add to Container
          if(objItem.is_equiped == 1) {
            $this.calcBonus('health', objItem);
            $this.calcBonus('attack', objItem);
            $this.calcBonus('defence', objItem);
            $this.calcBonus('agility', objItem);
            $this.calcBonus('luck', objItem);
            $('#equipded_card .card-body').append(strHtml);
          } else {
            elCard.append(strHtml);
          }
        }
      }
    });
  };

  this.calcBonus = function(strKey, objItem) {
    var numValue = parseInt($('#stats_item_' + strKey).html());
    var numPlayerValue = parseInt($('#stats_player_' + strKey).html());
    var numFixValue = parseInt(objItem['fix_' + strKey]);
    var numPercentValue = parseInt(objItem['factor_' + strKey]);
    var numCalcFixValue = numValue + numFixValue;
    var numCalcPercentValue = (numPlayerValue + numCalcFixValue) / 100 * numPercentValue;
    $('#stats_item_' + strKey).html(Math.round(numCalcFixValue + numCalcPercentValue));
    $('#stats_item_' + strKey + '_total').html(Math.round(numCalcFixValue + numCalcPercentValue + parseInt($('#stats_player_' + strKey).html())));
  };

  this.equipItem = function(e) {
    // Get Item Data
    objData = {
      item_id: $(e.currentTarget).data('id'),
      type: $(e.currentTarget).data('type'),
      is_equiped: $(e.currentTarget).data('equiped')
    };

    // Send Ajax Request
    _ajax.sendPostFromCard($('#equipded_card'), 'item_equip', objData, function(objResponse) {
      if(objResponse.status) {
        $('#equipded_card .card-body').html('');
        $this.loadAllItems();
      }
    });
  };

  this.getRarityText = function(numRarity) {
    var arrRarity = {
      0: 'POOR',
      1: 'COMMON',
      2: 'UNCOMMON',
      3: 'EPIC',
      4: 'LEGENDARY',
      5: 'SUPREME'
    };
    return arrRarity[numRarity];
  }

  // Constructor Call
  $this.init();
};
var controller = new Controller();
