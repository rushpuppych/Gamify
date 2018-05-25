
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
    $this.loadScoreBoard();
    $this.eventManager();
  };

  this.eventManager = function() {

  };

  this.loadScoreBoard = function() {
    _ajax.sendPostFromCard($('body'), 'scoreboard_load_data', {}, function(objResponse) {
      if(objResponse.status) {
        if(objResponse.experience_ranking.length > 0) {
          $('#experience_ranking').html(_private.generateScoreBoard(objResponse.experience_ranking));
        }
        if(objResponse.battle_ranking.length > 0) {
          $('#battle_ranking').html(_private.generateScoreBoard(objResponse.battle_ranking));
        }
        if(objResponse.weapon_ranking.length > 0) {
          $('#weapon_ranking').html(_private.generateScoreBoard(objResponse.weapon_ranking));
        }
        if(objResponse.armor_ranking.length > 0) {
          $('#armor_ranking').html(_private.generateScoreBoard(objResponse.armor_ranking));
        }
        if(objResponse.shield_ranking.length > 0) {
          $('#shield_ranking').html(_private.generateScoreBoard(objResponse.shield_ranking));
        }
        if(objResponse.special_ranking.length > 0) {
          $('#special_ranking').html(_private.generateScoreBoard(objResponse.special_ranking));
        }
      }
    });
  };

  _private.generateScoreBoard = function(objData) {
    // Create ScoreBoard HTML Header
    var strHtml = '';
    strHtml += '<table class="table table-bordered" style="font-size: 12px;">';
    strHtml += '   <tbody>';

    // Loop over Data
    for(var numRank in objData) {
      var objElement = objData[numRank];

      // Create HTML Item Data
      var strItemData = '';
      if(typeof(objElement['item_info']) != 'undefined') {
        strItemData += '<br>';
        strItemData += '<br><b>Rarity:</b> ' + objElement.item_info.rarity;
        strItemData += '<br><b>Power:</b> ' + objElement.value;
        objElement.value = '<img src="../api/item_get_base64_image.php?img_key=' + objElement.item_info.imagekey + '&type=' + objElement.item_info.type + '" data-toggle="tooltip" data-placement="top" title="' + objElement.item_info.name + '" style="width: 100%;">';
      }

      // Create HTML Record
      strHtml += '<tr>';
      strHtml += '   <th width="10%">' + (parseInt(numRank) + 1) + '</th>';
      strHtml += '   <th width="22%"><img src="../api/character_get_base64_image.php?player_id=' + objElement.player.player_id + '&animation=walk_down" style="width: 100%;"></th>';
      strHtml += '   <td width="46%"><b>' + objElement.player.name + '</b><br><b>Level:</b> ' + objElement.player.level + '<br><b>Fraction:</b> ' + objElement.player.fraction + strItemData + '</td>';
      strHtml += '   <td width="22%" style="text-align: right;">' + objElement.value + '</td>';
      strHtml += '</tr>';
    }

    // Create ScoreBoard HTML Footer
    strHtml += '   </tbody>';
    strHtml += '</table>';

    // Return HTML ScoreBoard
    return strHtml;
  }

  // Constructor Call
  $this.init();
};
var controller = new Controller();
