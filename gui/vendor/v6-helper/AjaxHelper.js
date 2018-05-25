
var AjaxHelper = function() {
  var $this = this;
  var _private = {};

  // Local Vars
  this.options = {
  }

  // constructor
  this.init = function() {
  };

  this.sendPost = function(strUrl, objData, fncCallback) {
    $.ajax({
      type: "POST",
      url: '../api/' + strUrl + '.php',
      data: objData,
      success: function(strData) {
        if(typeof(fncCallback) == 'function') {
          console.log(strData);
          fncCallback(jQuery.parseJSON(strData));
        }
      }
    });
  };

  this.sendPostFromCard = function(elCard, strUrl, objData, fncCallback) {
    $(':focus').blur();
    _private.hideCard(elCard);
    $this.sendPost(strUrl, objData, function(objData) {
      _private.showCard(elCard);
      if(typeof(fncCallback) == 'function') {
        fncCallback(objData);
      }
    });
  }

  _private.hideCard = function(elCard) {
    var strHiddenLayer = '<span class="loader_overlay" style="width: 100%; height: 100%; position:absolute; top: 0px; left: 0px; background-color: rgba(255,255,255,0.7); z-index: 9999;">';
    strHiddenLayer+= '<img src="assets/images/ui/ajax-loader.gif" style="position: absolute; left: 50%; top: 50%; margin-left: -33px; margin-top: -33px;">';
    strHiddenLayer += '</span>';
    elCard.append(strHiddenLayer);
  }

  _private.showCard= function(elCard) {
    elCard.find('span.loader_overlay').remove();
  }

  // Constructor Call
  $this.init();
};
