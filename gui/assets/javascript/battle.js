
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

    // Load Add Battle Map
    $this.getBattle();
  };

  this.eventManager = function() {

  };

  this.addCharacter = function(numPlayerId, strPlayerName, strAnimation, numTileX, numTileY) {
    var numMapWidth = '1216';
    var numMapHeight = '1088';
    var numCharWidth = '64';
    var numCharHeight = '86';
    var numMapTileX = 19;
    var numMaptileY = 17;
    var numBoxWidth = 100 / numMapWidth * numCharWidth;
    var numBoxHeight = 100 / numMapHeight * numCharHeight;
    var numFactorHeight = -0.6;

    // Generate
    var strUuid = _ui.uuid();
    var strHtml = '';
    strHtml += '<span data-player=' + numPlayerId + '  data-toggle="tooltip" data-placement="top" title="' + strPlayerName + '" class="player player_' + strUuid + '" style="position: absolute;">';
    strHtml += '   <img src="../api/character_get_base64_image.php?player_id=' + numPlayerId + '&animation=' + strAnimation + '" style="width: 100%;">';
    strHtml += '</span>';

    $('#battle_map').append(strHtml);

    // Positioning
    $('span.player_' + strUuid + '').css('width', numBoxWidth + '%');
    $('span.player_' + strUuid + '').css('height', numBoxHeight + '%');
    $('span.player_' + strUuid + '').css('margin-top', '-' + numBoxHeight / 2 + '%');
    $('span.player_' + strUuid + '').css('top', (numTileX * numBoxWidth) - (numTileX * numFactorHeight) + '%');
    $('span.player_' + strUuid + '').css('left', numTileY * numBoxWidth + '%');
  };

  this.getBattle = function() {
    // Send Ajax Request
    _ajax.sendPostFromCard($('#battle_map'), 'battle_get_day_plan', {}, function(objResponse) {
      if(objResponse.status) {
        if(objResponse.is_battle == 1) {
          for(numPlayer in objResponse['battle']) {
            var objPlayer = objResponse['battle'][numPlayer];
            var objPosition = $this.getPosition(objPlayer, objPlayer.position);
            var strAnimation = objPosition.dir;
            if(objPlayer.is_killed == 1) {
              strAnimation = 7;
            }
            $this.addCharacter(objPlayer.id, objPlayer.name, strAnimation, objPosition.x, objPosition.y)
          }
        } else {
          $('#battle_map').find('img').addClass('grayscale_img');
          $('#battle_map').append('<img style="position: absolute; top:15%; width: 100%; padding: 20%;" src="assets/images/ui/no_battle.png">');
        }
      }
    });
  };

  this.getPosition = function(objPlayer, numPosition) {
    var arrPosition = [];
    if(objPlayer.round == 0) {
      arrPosition[0] = {x: 1, y: 1, dir: 'walk_right'};
      arrPosition[1] = {x: 3, y: 1, dir: 'walk_right'};
      arrPosition[2] = {x: 5, y: 1, dir: 'walk_right'};
      arrPosition[3] = {x: 7, y: 1, dir: 'walk_right'};
      arrPosition[4] = {x: 9, y: 1, dir: 'walk_right'};
      arrPosition[5] = {x: 11, y: 1, dir: 'walk_right'};
      arrPosition[6] = {x: 13, y: 1, dir: 'walk_right'};
      arrPosition[7] = {x: 15, y: 1, dir: 'walk_right'};
      arrPosition[8] = {x: 1, y: 17, dir: 'walk_left'};
      arrPosition[9] = {x: 3, y: 17, dir: 'walk_left'};
      arrPosition[10] = {x: 5, y: 17, dir: 'walk_left'};
      arrPosition[11] = {x: 7, y: 17, dir: 'walk_left'};
      arrPosition[12] = {x: 9, y: 17, dir: 'walk_left'};
      arrPosition[13] = {x: 11, y: 17, dir: 'walk_left'};
      arrPosition[14] = {x: 13, y: 17, dir: 'walk_left'};
      arrPosition[15] = {x: 15, y: 17, dir: 'walk_left'};
    }

    if(objPlayer.round == 1) {
      arrPosition[0] = {x: 1, y: 2, dir: 'walk_right'};
      arrPosition[1] = {x: 3, y: 2, dir: 'walk_right'};
      arrPosition[2] = {x: 5, y: 2, dir: 'walk_right'};
      arrPosition[3] = {x: 7, y: 2, dir: 'walk_right'};
      arrPosition[4] = {x: 9, y: 2, dir: 'walk_right'};
      arrPosition[5] = {x: 11, y: 2, dir: 'walk_right'};
      arrPosition[6] = {x: 13, y: 2, dir: 'walk_right'};
      arrPosition[7] = {x: 15, y: 2, dir: 'walk_right'};
      arrPosition[8] = {x: 1, y: 16, dir: 'walk_left'};
      arrPosition[9] = {x: 3, y: 16, dir: 'walk_left'};
      arrPosition[10] = {x: 5, y: 16, dir: 'walk_left'};
      arrPosition[11] = {x: 7, y: 16, dir: 'walk_left'};
      arrPosition[12] = {x: 9, y: 16, dir: 'walk_left'};
      arrPosition[13] = {x: 11, y: 16, dir: 'walk_left'};
      arrPosition[14] = {x: 13, y: 16, dir: 'walk_left'};
      arrPosition[15] = {x: 15, y: 16, dir: 'walk_left'};
    }

    if(objPlayer.round == 2) {
      arrPosition[0] = {x: 1, y: 3, dir: 'walk_down'};
      arrPosition[1] = {x: 3, y: 3, dir: 'walk_up'};
      arrPosition[2] = {x: 5, y: 3, dir: 'walk_down'};
      arrPosition[3] = {x: 7, y: 3, dir: 'walk_up'};
      arrPosition[4] = {x: 9, y: 3, dir: 'walk_down'};
      arrPosition[5] = {x: 11, y: 3, dir: 'walk_up'};
      arrPosition[6] = {x: 13, y: 3, dir: 'walk_down'};
      arrPosition[7] = {x: 15, y: 3, dir: 'walk_up'};
      arrPosition[8] = {x: 1, y: 15, dir: 'walk_down'};
      arrPosition[9] = {x: 3, y: 15, dir: 'walk_up'};
      arrPosition[10] = {x: 5, y: 15, dir: 'walk_down'};
      arrPosition[11] = {x: 7, y: 15, dir: 'walk_up'};
      arrPosition[12] = {x: 9, y: 15, dir: 'walk_down'};
      arrPosition[13] = {x: 11, y: 15, dir: 'walk_up'};
      arrPosition[14] = {x: 13, y: 15, dir: 'walk_down'};
      arrPosition[15] = {x: 15, y: 15, dir: 'walk_up'};
    }

    if(objPlayer.round == 3) {
      arrPosition[0] = {x: 2, y: 3, dir: 'walk_right'};
      arrPosition[1] = {x: 2, y: 3, dir: 'walk_right'};
      arrPosition[2] = {x: 6, y: 3, dir: 'walk_right'};
      arrPosition[3] = {x: 6, y: 3, dir: 'walk_right'};
      arrPosition[4] = {x: 10, y: 3, dir: 'walk_right'};
      arrPosition[5] = {x: 10, y: 3, dir: 'walk_right'};
      arrPosition[6] = {x: 14, y: 3, dir: 'walk_right'};
      arrPosition[7] = {x: 14, y: 3, dir: 'walk_right'};
      arrPosition[8] = {x: 2, y: 15, dir: 'walk_left'};
      arrPosition[9] = {x: 2, y: 15, dir: 'walk_left'};
      arrPosition[10] = {x: 6, y: 15, dir: 'walk_left'};
      arrPosition[11] = {x: 6, y: 15, dir: 'walk_left'};
      arrPosition[12] = {x: 10, y: 15, dir: 'walk_left'};
      arrPosition[13] = {x: 10, y: 15, dir: 'walk_left'};
      arrPosition[14] = {x: 14, y: 15, dir: 'walk_left'};
      arrPosition[15] = {x: 14, y: 15, dir: 'walk_left'};
    }

    if(objPlayer.round == 4) {
      arrPosition[0] = {x: 2, y: 4, dir: 'walk_right'};
      arrPosition[1] = {x: 2, y: 4, dir: 'walk_right'};
      arrPosition[2] = {x: 6, y: 4, dir: 'walk_right'};
      arrPosition[3] = {x: 6, y: 4, dir: 'walk_right'};
      arrPosition[4] = {x: 10, y: 4, dir: 'walk_right'};
      arrPosition[5] = {x: 10, y: 4, dir: 'walk_right'};
      arrPosition[6] = {x: 14, y: 4, dir: 'walk_right'};
      arrPosition[7] = {x: 14, y: 4, dir: 'walk_right'};
      arrPosition[8] = {x: 2, y: 14, dir: 'walk_left'};
      arrPosition[9] = {x: 2, y: 14, dir: 'walk_left'};
      arrPosition[10] = {x: 6, y: 14, dir: 'walk_left'};
      arrPosition[11] = {x: 6, y: 14, dir: 'walk_left'};
      arrPosition[12] = {x: 10, y: 14, dir: 'walk_left'};
      arrPosition[13] = {x: 10, y: 14, dir: 'walk_left'};
      arrPosition[14] = {x: 14, y: 14, dir: 'walk_left'};
      arrPosition[15] = {x: 14, y: 14, dir: 'walk_left'};
    }

    if(objPlayer.round == 5) {
      arrPosition[0] = {x: 2, y: 5, dir: 'walk_down'};
      arrPosition[1] = {x: 2, y: 5, dir: 'walk_down'};
      arrPosition[2] = {x: 6, y: 5, dir: 'walk_up'};
      arrPosition[3] = {x: 6, y: 5, dir: 'walk_up'};
      arrPosition[4] = {x: 10, y: 5, dir: 'walk_down'};
      arrPosition[5] = {x: 10, y: 5, dir: 'walk_down'};
      arrPosition[6] = {x: 14, y: 5, dir: 'walk_up'};
      arrPosition[7] = {x: 14, y: 5, dir: 'walk_up'};
      arrPosition[8] = {x: 2, y: 13, dir: 'walk_down'};
      arrPosition[9] = {x: 2, y: 13, dir: 'walk_down'};
      arrPosition[10] = {x: 6, y: 13, dir: 'walk_up'};
      arrPosition[11] = {x: 6, y: 13, dir: 'walk_up'};
      arrPosition[12] = {x: 10, y: 13, dir: 'walk_down'};
      arrPosition[13] = {x: 10, y: 13, dir: 'walk_down'};
      arrPosition[14] = {x: 14, y: 13, dir: 'walk_up'};
      arrPosition[15] = {x: 14, y: 13, dir: 'walk_up'};
    }

    if(objPlayer.round == 6) {
      arrPosition[0] = {x: 3, y: 5, dir: 'walk_down'};
      arrPosition[1] = {x: 3, y: 5, dir: 'walk_down'};
      arrPosition[2] = {x: 5, y: 5, dir: 'walk_up'};
      arrPosition[3] = {x: 5, y: 5, dir: 'walk_up'};
      arrPosition[4] = {x: 11, y: 5, dir: 'walk_down'};
      arrPosition[5] = {x: 11, y: 5, dir: 'walk_down'};
      arrPosition[6] = {x: 13, y: 5, dir: 'walk_up'};
      arrPosition[7] = {x: 13, y: 5, dir: 'walk_up'};
      arrPosition[8] = {x: 3, y: 13, dir: 'walk_down'};
      arrPosition[9] = {x: 3, y: 13, dir: 'walk_down'};
      arrPosition[10] = {x: 5, y: 13, dir: 'walk_up'};
      arrPosition[11] = {x: 5, y: 13, dir: 'walk_up'};
      arrPosition[12] = {x: 11, y: 13, dir: 'walk_down'};
      arrPosition[13] = {x: 11, y: 13, dir: 'walk_down'};
      arrPosition[14] = {x: 13, y: 13, dir: 'walk_up'};
      arrPosition[15] = {x: 13, y: 13, dir: 'walk_up'};
    }

    if(objPlayer.round == 7) {
      arrPosition[0] = {x: 4, y: 5, dir: 'walk_right'};
      arrPosition[1] = {x: 4, y: 5, dir: 'walk_right'};
      arrPosition[2] = {x: 4, y: 5, dir: 'walk_right'};
      arrPosition[3] = {x: 4, y: 5, dir: 'walk_right'};
      arrPosition[4] = {x: 12, y: 5, dir: 'walk_right'};
      arrPosition[5] = {x: 12, y: 5, dir: 'walk_right'};
      arrPosition[6] = {x: 12, y: 5, dir: 'walk_right'};
      arrPosition[7] = {x: 12, y: 5, dir: 'walk_right'};
      arrPosition[8] = {x: 4, y: 13, dir: 'walk_left'};
      arrPosition[9] = {x: 4, y: 13, dir: 'walk_left'};
      arrPosition[10] = {x: 4, y: 13, dir: 'walk_left'};
      arrPosition[11] = {x: 4, y: 13, dir: 'walk_left'};
      arrPosition[12] = {x: 12, y: 13, dir: 'walk_left'};
      arrPosition[13] = {x: 12, y: 13, dir: 'walk_left'};
      arrPosition[14] = {x: 12, y: 13, dir: 'walk_left'};
      arrPosition[15] = {x: 12, y: 13, dir: 'walk_left'};
    }

    if(objPlayer.round == 8) {
      arrPosition[0] = {x: 4, y: 6, dir: 'walk_right'};
      arrPosition[1] = {x: 4, y: 6, dir: 'walk_right'};
      arrPosition[2] = {x: 4, y: 6, dir: 'walk_right'};
      arrPosition[3] = {x: 4, y: 6, dir: 'walk_right'};
      arrPosition[4] = {x: 12, y: 6, dir: 'walk_right'};
      arrPosition[5] = {x: 12, y: 6, dir: 'walk_right'};
      arrPosition[6] = {x: 12, y: 6, dir: 'walk_right'};
      arrPosition[7] = {x: 12, y: 6, dir: 'walk_right'};
      arrPosition[8] = {x: 4, y: 12, dir: 'walk_left'};
      arrPosition[9] = {x: 4, y: 12, dir: 'walk_left'};
      arrPosition[10] = {x: 4, y: 12, dir: 'walk_left'};
      arrPosition[11] = {x: 4, y: 12, dir: 'walk_left'};
      arrPosition[12] = {x: 12, y: 12, dir: 'walk_left'};
      arrPosition[13] = {x: 12, y: 12, dir: 'walk_left'};
      arrPosition[14] = {x: 12, y: 12, dir: 'walk_left'};
      arrPosition[15] = {x: 12, y: 12, dir: 'walk_left'};
    }

    if(objPlayer.round == 9) {
      arrPosition[0] = {x: 4, y: 7, dir: 'walk_down'};
      arrPosition[1] = {x: 4, y: 7, dir: 'walk_down'};
      arrPosition[2] = {x: 4, y: 7, dir: 'walk_down'};
      arrPosition[3] = {x: 4, y: 7, dir: 'walk_down'};
      arrPosition[4] = {x: 12, y: 7, dir: 'walk_up'};
      arrPosition[5] = {x: 12, y: 7, dir: 'walk_up'};
      arrPosition[6] = {x: 12, y: 7, dir: 'walk_up'};
      arrPosition[7] = {x: 12, y: 7, dir: 'walk_up'};
      arrPosition[8] = {x: 4, y: 11, dir: 'walk_down'};
      arrPosition[9] = {x: 4, y: 11, dir: 'walk_down'};
      arrPosition[10] = {x: 4, y: 11, dir: 'walk_down'};
      arrPosition[11] = {x: 4, y: 11, dir: 'walk_down'};
      arrPosition[12] = {x: 12, y: 11, dir: 'walk_up'};
      arrPosition[13] = {x: 12, y: 11, dir: 'walk_up'};
      arrPosition[14] = {x: 12, y: 11, dir: 'walk_up'};
      arrPosition[15] = {x: 12, y: 11, dir: 'walk_up'};
    }

    if(objPlayer.round == 10) {
      arrPosition[0] = {x: 5, y: 7, dir: 'walk_down'};
      arrPosition[1] = {x: 5, y: 7, dir: 'walk_down'};
      arrPosition[2] = {x: 5, y: 7, dir: 'walk_down'};
      arrPosition[3] = {x: 5, y: 7, dir: 'walk_down'};
      arrPosition[4] = {x: 12, y: 7, dir: 'walk_up'};
      arrPosition[5] = {x: 12, y: 7, dir: 'walk_up'};
      arrPosition[6] = {x: 12, y: 7, dir: 'walk_up'};
      arrPosition[7] = {x: 12, y: 7, dir: 'walk_up'};
      arrPosition[8] = {x: 5, y: 11, dir: 'walk_down'};
      arrPosition[9] = {x: 5, y: 11, dir: 'walk_down'};
      arrPosition[10] = {x: 5, y: 11, dir: 'walk_down'};
      arrPosition[11] = {x: 5, y: 11, dir: 'walk_down'};
      arrPosition[12] = {x: 12, y: 11, dir: 'walk_up'};
      arrPosition[13] = {x: 12, y: 11, dir: 'walk_up'};
      arrPosition[14] = {x: 12, y: 11, dir: 'walk_up'};
      arrPosition[15] = {x: 12, y: 11, dir: 'walk_up'};
    }

    if(objPlayer.round == 11) {
      arrPosition[0] = {x: 6, y: 7, dir: 'walk_down'};
      arrPosition[1] = {x: 6, y: 7, dir: 'walk_down'};
      arrPosition[2] = {x: 6, y: 7, dir: 'walk_down'};
      arrPosition[3] = {x: 6, y: 7, dir: 'walk_down'};
      arrPosition[4] = {x: 11, y: 7, dir: 'walk_up'};
      arrPosition[5] = {x: 11, y: 7, dir: 'walk_up'};
      arrPosition[6] = {x: 11, y: 7, dir: 'walk_up'};
      arrPosition[7] = {x: 11, y: 7, dir: 'walk_up'};
      arrPosition[8] = {x: 6, y: 11, dir: 'walk_down'};
      arrPosition[9] = {x: 6, y: 11, dir: 'walk_down'};
      arrPosition[10] = {x: 6, y: 11, dir: 'walk_down'};
      arrPosition[11] = {x: 6, y: 11, dir: 'walk_down'};
      arrPosition[12] = {x: 11, y: 11, dir: 'walk_up'};
      arrPosition[13] = {x: 11, y: 11, dir: 'walk_up'};
      arrPosition[14] = {x: 11, y: 11, dir: 'walk_up'};
      arrPosition[15] = {x: 11, y: 11, dir: 'walk_up'};
    }

    if(objPlayer.round == 12) {
      arrPosition[0] = {x: 7, y: 7, dir: 'walk_down'};
      arrPosition[1] = {x: 7, y: 7, dir: 'walk_down'};
      arrPosition[2] = {x: 7, y: 7, dir: 'walk_down'};
      arrPosition[3] = {x: 7, y: 7, dir: 'walk_down'};
      arrPosition[4] = {x: 11, y: 7, dir: 'walk_up'};
      arrPosition[5] = {x: 11, y: 7, dir: 'walk_up'};
      arrPosition[6] = {x: 11, y: 7, dir: 'walk_up'};
      arrPosition[7] = {x: 11, y: 7, dir: 'walk_up'};
      arrPosition[8] = {x: 7, y: 11, dir: 'walk_down'};
      arrPosition[9] = {x: 7, y: 11, dir: 'walk_down'};
      arrPosition[10] = {x: 7, y: 11, dir: 'walk_down'};
      arrPosition[11] = {x: 7, y: 11, dir: 'walk_down'};
      arrPosition[12] = {x: 11, y: 11, dir: 'walk_up'};
      arrPosition[13] = {x: 11, y: 11, dir: 'walk_up'};
      arrPosition[14] = {x: 11, y: 11, dir: 'walk_up'};
      arrPosition[15] = {x: 11, y: 11, dir: 'walk_up'};
    }

    if(objPlayer.round == 13) {
      arrPosition[0] = {x: 8, y: 7, dir: 'walk_down'};
      arrPosition[1] = {x: 8, y: 7, dir: 'walk_down'};
      arrPosition[2] = {x: 8, y: 7, dir: 'walk_down'};
      arrPosition[3] = {x: 8, y: 7, dir: 'walk_down'};
      arrPosition[4] = {x: 10, y: 7, dir: 'walk_up'};
      arrPosition[5] = {x: 10, y: 7, dir: 'walk_up'};
      arrPosition[6] = {x: 10, y: 7, dir: 'walk_up'};
      arrPosition[7] = {x: 10, y: 7, dir: 'walk_up'};
      arrPosition[8] = {x: 8, y: 11, dir: 'walk_down'};
      arrPosition[9] = {x: 8, y: 11, dir: 'walk_down'};
      arrPosition[10] = {x: 8, y: 11, dir: 'walk_down'};
      arrPosition[11] = {x: 8, y: 11, dir: 'walk_down'};
      arrPosition[12] = {x: 10, y: 11, dir: 'walk_up'};
      arrPosition[13] = {x: 10, y: 11, dir: 'walk_up'};
      arrPosition[14] = {x: 10, y: 11, dir: 'walk_up'};
      arrPosition[15] = {x: 10, y: 11, dir: 'walk_up'};
    }

    if(objPlayer.round == 14) {
      arrPosition[0] = {x: 9, y: 7, dir: 'walk_right'};
      arrPosition[1] = {x: 9, y: 7, dir: 'walk_right'};
      arrPosition[2] = {x: 9, y: 7, dir: 'walk_right'};
      arrPosition[3] = {x: 9, y: 7, dir: 'walk_right'};
      arrPosition[4] = {x: 9, y: 7, dir: 'walk_right'};
      arrPosition[5] = {x: 9, y: 7, dir: 'walk_right'};
      arrPosition[6] = {x: 9, y: 7, dir: 'walk_right'};
      arrPosition[7] = {x: 9, y: 7, dir: 'walk_right'};
      arrPosition[8] = {x: 9, y: 11, dir: 'walk_left'};
      arrPosition[9] = {x: 9, y: 11, dir: 'walk_left'};
      arrPosition[10] = {x: 9, y: 11, dir: 'walk_left'};
      arrPosition[11] = {x: 9, y: 11, dir: 'walk_left'};
      arrPosition[12] = {x: 9, y: 11, dir: 'walk_left'};
      arrPosition[13] = {x: 9, y: 11, dir: 'walk_left'};
      arrPosition[14] = {x: 9, y: 11, dir: 'walk_left'};
      arrPosition[15] = {x: 9, y: 11, dir: 'walk_left'};
    }

    if(objPlayer.round == 15) {
      arrPosition[0] = {x: 9, y: 8, dir: 'walk_right'};
      arrPosition[1] = {x: 9, y: 8, dir: 'walk_right'};
      arrPosition[2] = {x: 9, y: 8, dir: 'walk_right'};
      arrPosition[3] = {x: 9, y: 8, dir: 'walk_right'};
      arrPosition[4] = {x: 9, y: 8, dir: 'walk_right'};
      arrPosition[5] = {x: 9, y: 8, dir: 'walk_right'};
      arrPosition[6] = {x: 9, y: 8, dir: 'walk_right'};
      arrPosition[7] = {x: 9, y: 8, dir: 'walk_right'};
      arrPosition[8] = {x: 9, y: 10, dir: 'walk_left'};
      arrPosition[9] = {x: 9, y: 10, dir: 'walk_left'};
      arrPosition[10] = {x: 9, y: 10, dir: 'walk_left'};
      arrPosition[11] = {x: 9, y: 10, dir: 'walk_left'};
      arrPosition[12] = {x: 9, y: 10, dir: 'walk_left'};
      arrPosition[13] = {x: 9, y: 10, dir: 'walk_left'};
      arrPosition[14] = {x: 9, y: 10, dir: 'walk_left'};
      arrPosition[15] = {x: 9, y: 10, dir: 'walk_left'};
    }

    if(objPlayer.round == 16) {
      arrPosition[0] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[1] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[2] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[3] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[4] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[5] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[6] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[7] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[8] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[9] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[10] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[11] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[12] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[13] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[14] = {x: 9, y: 9, dir: 'walk_up'};
      arrPosition[15] = {x: 9, y: 9, dir: 'walk_up'};
    }

    if(objPlayer.round == 17) {
      arrPosition[0] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[1] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[2] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[3] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[4] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[5] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[6] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[7] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[8] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[9] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[10] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[11] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[12] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[13] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[14] = {x: 8, y: 9, dir: 'walk_up'};
      arrPosition[15] = {x: 8, y: 9, dir: 'walk_up'};
    }

    if(objPlayer.round == 18) {
      arrPosition[0] = {x: 7, y: 9, dir: '7'};
      arrPosition[1] = {x: 7, y: 9, dir: '7'};
      arrPosition[2] = {x: 7, y: 9, dir: '7'};
      arrPosition[3] = {x: 7, y: 9, dir: '7'};
      arrPosition[4] = {x: 7, y: 9, dir: '7'};
      arrPosition[5] = {x: 7, y: 9, dir: '7'};
      arrPosition[6] = {x: 7, y: 9, dir: '7'};
      arrPosition[7] = {x: 7, y: 9, dir: '7'};
      arrPosition[8] = {x: 7, y: 9, dir: '7'};
      arrPosition[9] = {x: 7, y: 9, dir: '7'};
      arrPosition[10] = {x: 7, y: 9, dir: '7'};
      arrPosition[11] = {x: 7, y: 9, dir: '7'};
      arrPosition[12] = {x: 7, y: 9, dir: '7'};
      arrPosition[13] = {x: 7, y: 9, dir: '7'};
      arrPosition[14] = {x: 7, y: 9, dir: '7'};
      arrPosition[15] = {x: 7, y: 9, dir: '7'};
    }

    return arrPosition[numPosition];
  };

  // Constructor Call
  $this.init();
};
var controller = new Controller();
