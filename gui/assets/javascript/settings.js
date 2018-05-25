
var Controller = function() {
  var $this = this;
  var _private = {};
  var _ajax = new AjaxHelper();
  var _ui = new UiHelper();

  // Helper System Variables
  this.options = {
    customize: {
      body: [],
      face: [],
      hair: [],
    },
    character: {
      body_key: '1',
      face_key: '1',
      hair_key: '1',
      animation: 'walk_down'
    }
  }

  // constructor
  this.init = function() {
    $this.eventManager();
    $this.initCharacter();

    // Block Main Navigation when character is not created (firstlogin)
    if($.isEmptyObject(getSession().user.character)) {
      $this.firstLoginBlock();
    }
  };

  this.eventManager = function() {
    // Customize Character
    $('#character_last_body').on('click', function() {$this.getLastImage('body');});
    $('#character_next_body').on('click', function() {$this.getNextImage('body');});
    $('#character_last_face').on('click', function() {$this.getLastImage('face');});
    $('#character_next_face').on('click', function() {$this.getNextImage('face');});
    $('#character_last_hair').on('click', function() {$this.getLastImage('hair');});
    $('#character_next_hair').on('click', function() {$this.getNextImage('hair');});
    $('#character_turn_left').on('click', function() {$this.changeDirection('left');});
    $('#character_turn_right').on('click', function() {$this.changeDirection('right');});

    // Save Buttons
    $('body').on('click', '#character_button', function(e){$this.saveCharacter(e);});
    $('body').on('click', '#password_button', function(e){$this.changePassword(e);});
    $('body').on('click', '#delete_button', function(e){$this.deleteCharacter(e);});
  };

  this.firstLoginBlock = function() {
    $('li.nav-item').hide();
    $('#warning-firstlogin').show();
  };

  this.initCharacter = function() {
    // Load Character informations from Session
    if(!$.isEmptyObject(getSession().user.character)) {
      $this.options.character = getSession().user.character;
      $this.options.character.animation = 'walk_down';
      $('#character_name').val($this.options.character.name);
    }

    // Load Character Resources
    _ajax.sendPost('character_get_resources', {}, function(objResponse) {
      $this.options.customize = objResponse.resources;

      // Load Character Image
      $this.loadCharacter();
    });
  };

  this.loadCharacter = function() {
    // Load Character from Server
    _ajax.sendPostFromCard($('#card_character'), 'character_get_image', $this.options.character, function(objResponse) {
      if(objResponse.status) {
        $('#character_image').attr('src', 'data:image/gif;base64,' + objResponse.image_base64);
      }
    });
  };

  this.getNextImage = function(strBodyPart) {
    var strBodyKey = $this.options.character[strBodyPart + '_key'];
    var numArrSize = $this.options.customize[strBodyPart].length - 1;
    var numArrIndex = $this.options.customize[strBodyPart].indexOf(strBodyKey);

    var numNewIndex = numArrIndex + 1;
    if(numNewIndex > numArrSize) {
      numNewIndex = 0;
    }

    $this.options.character[strBodyPart + '_key'] = $this.options.customize[strBodyPart][numNewIndex];
    $this.loadCharacter();
  };

  this.getLastImage = function(strBodyPart) {
    var strBodyKey = $this.options.character[strBodyPart + '_key'];
    var numArrSize = $this.options.customize[strBodyPart].length - 1;
    var numArrIndex = $this.options.customize[strBodyPart].indexOf(strBodyKey);

    var numNewIndex = numArrIndex - 1;
    if(numNewIndex < 0) {
      numNewIndex = numArrSize;
    }

    $this.options.character[strBodyPart + '_key'] = $this.options.customize[strBodyPart][numNewIndex];
    $this.loadCharacter();
  };

  this.changeDirection = function(strDirection) {
    if($this.options.character.animation == 'walk_down') {
      if(strDirection == 'right'){$this.options.character.animation = 'walk_right';}
      if(strDirection == 'left'){$this.options.character.animation = 'walk_left';}

    } else if($this.options.character.animation == 'walk_left') {
      if(strDirection == 'right'){$this.options.character.animation = 'walk_down';}
      if(strDirection == 'left'){$this.options.character.animation = 'walk_up';}

    } else if($this.options.character.animation == 'walk_up') {
      if(strDirection == 'right'){$this.options.character.animation = 'walk_left';}
      if(strDirection == 'left'){$this.options.character.animation = 'walk_right';}

    } else if($this.options.character.animation == 'walk_right') {
      if(strDirection == 'right'){$this.options.character.animation = 'walk_up';}
      if(strDirection == 'left'){$this.options.character.animation = 'walk_down';}
    }

    $this.loadCharacter();
  }

  this.saveCharacter = function() {
    var objCharacter = {
      name: $('#character_name').val(),
      body_key: $this.options.character.body_key,
      face_key: $this.options.character.face_key,
      hair_key: $this.options.character.hair_key
    };

    _ajax.sendPostFromCard($('#character_card'), 'character_save_data', objCharacter, function(objResponse) {
      $('.form-group').find('small').html('');
      if(!objResponse.status) {
        $('#' + objResponse.field + '_help').html(objResponse.message);
      } else {
        $('li.nav-item').show();
        $('#warning-firstlogin').hide();
      }
    });
  };

  this.changePassword = function() {
    var objPassword = {
      old_password: $('#password_old').val(),
      new_password: $('#password_new').val(),
      renew_password: $('#password_renew').val()
    };

    _ajax.sendPostFromCard($('#password_cars'), 'account_change_password', objPassword, function(objResponse) {
      $('.form-group').find('small').html('');
      if(!objResponse.status) {
        $('#' + objResponse.field + '_help').html(objResponse.message);
      } else {
        _ui.showModal('Password Change', 'Password has been changed.', [{text: 'Close'}]);
        $('#password_card').find('input').val('');
      }
    });
  };

  this.deleteCharacter = function() {
    var objPassword = {
      delete_password: $('#delete_password').val()
    };

    _ajax.sendPostFromCard($('#delete_card'), 'account_delete_account', objPassword, function(objResponse) {
      $('.form-group').find('small').html('');
      if(!objResponse.status) {
        $('#' + objResponse.field + '_help').html(objResponse.message);
      } else {
        _ui.showModal('Delete Account', 'Your Account is now deleted.', [{text: 'Close'}]);
        setTimeout(function(){window.location.href = "login.php";}, 2000);
      }
    });
  };

  // Constructor Call
  $this.init();
};
var controller = new Controller();
