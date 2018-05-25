
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
  };

  this.eventManager = function() {
    $('body').on('click', '#login_button', function(e){$this.login(e);});
    $('body').on('click', '#login_reset', function(e){$this.forgot(e);});
    $('body').on('click', '#signup_button', function(e){$this.signup(e);});
  };

  this.login = function(e) {
    // Build Credentials Object
    var objCredentials = {
      'email': $('#login_email').val(),
      'password': $('#login_password').val()
    };

    // Send Ajax Request
    _ajax.sendPostFromCard($('#login_card'), 'login_account_login', objCredentials, function(objResponse) {
      $('.form-group').find('small').html('');
      if(!objResponse.status) {
        $('#' + objResponse.field + '_help').html(objResponse.message);
      } else {
        if(objResponse.firstlogin) {
          window.location.href = "settings.php";
          return;
        } else {
          window.location.href = "quests.php";
          return;
        }
      }
    });
  };

  this.signup = function(e) {
    // Build New Account Object
    var objNewAccount = {
      'email': $('#signup_email').val(),
      'password': $('#signup_password').val(),
      'repassword': $('#signup_repassword').val(),
      'fraction': $('.carousel-item.active').data('fraction')
    };

    // Send Ajax Request
    _ajax.sendPostFromCard($('#signup_card'), 'login_account_signup', objNewAccount, function(objResponse) {
      $('.form-group').find('small').html('');
      if(!objResponse.status) {
        $('#' + objResponse.field + '_help').html(objResponse.message);
      } else {
        _ui.showModal('Welcome', 'Your Account has been created. Please Login.', [{text: 'Close'}]);
        $('#signup_card').find('input').val('');
      }
    });
  };

  this.forgot = function(e) {
    e.preventDefault();
    $(':focus').blur();

    // Build Modal Content HTML
    var strHtml = 'To recive your recovery key enter your email.';
    strHtml += '<form>';
    strHtml += '  <div class="form-group">';
    strHtml += '    <label for="reset_email">Email address</label>';
    strHtml += '    <input type="email" class="form-control" id="reset_email" aria-describedby="emailHelp" placeholder="Enter email">';
    strHtml += '    <small id="reset_email_help" class="form-text text-danger"></small>';
    strHtml += '  </div>';
    strHtml += '</form>';

    // Modal Callack
    var fncCallback = function(e) {
      // Send Activation Mail
      var objReset = {
          'email': $(e.target).closest('.modal').find('#reset_email').val()
      };

      // Send Recovery Key via Email
      _ajax.sendPostFromCard($(e.target).closest('.modal-content'), 'login_reset_account', objReset, function(objResponse) {
        $('.form-group').find('small').html('');
        if(!objResponse.status) {
          $('#' + objResponse.field + '_help').html(objResponse.message);
        } else {
          $(e.target).closest('.modal').modal('hide');
          _ui.showModal('Forgot Password', 'Password recovery key has been send to your email account.', [{text: 'Close'}]);
        }
      });
    };

    // Show Modal
    _ui.showModal('Forgot Password', strHtml, [{text: 'Send Reset Email', callback: fncCallback, color: 'success'}, {text: 'Close'}]);
  };

  // Constructor Call
  $this.init();
};
var controller = new Controller();
