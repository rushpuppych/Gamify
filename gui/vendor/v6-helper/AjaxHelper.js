
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
        console.log(strData);
        if(typeof(fncCallback) == 'function') {
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

  this.fileUploadHandler = function(elFileInput, fncCallback, arrFileTypes) {
    // call this function on onChange of the input for direkt upload
    var elFileInput = $(elFileInput)[0];
    var objFile = elFileInput.files[0];

    // Prevent no File
    if(typeof(objFile) == 'undefined') {
      return;
    }

    // Check for File Extendsion
    var boolIsValide = false;
    if(typeof(arrFileTypes) != 'undefined') {
      for(var numTypeIndex in arrFileTypes) {
        if (objFile.type.match(arrFileTypes[numTypeIndex])) {
          boolIsValide = true;
        }
      }
    } else {
      boolIsValide = true;
    }

    // Load File and trigger Callback
    if(boolIsValide) {
      var objFileReader = new FileReader();
      objFileReader.onload = function(event) {
        var strTextData = event.target.result;
        var strRemove = "data:image/png;base64,";
        var strBase64Data = strTextData.substring(strRemove.length);

        // Call Callback
        if(typeof(fncCallback) == 'function') {
          fncCallback({ data: strBase64Data, name: objFile.name, size: objFile.size});
          return;
        }
      };
      objFileReader.readAsDataURL(objFile);
    }
  };

  _private.hideCard = function(elCard) {
    var strHiddenLayer = '<span class="loader_overlay" style="width: 100%; height: 100%; position:absolute; top: 0px; left: 0px; background-color: rgba(255,255,255,0.7); z-index: 9999;">';
    strHiddenLayer+= '<img src="assets/images/ui/ajax-loader.gif" style="position: absolute; left: 50%; top: 50%; margin-left: -33px; margin-top: -33px;">';
    strHiddenLayer += '</span>';
    elCard.append(strHiddenLayer);
  };

  _private.showCard= function(elCard) {
    elCard.find('span.loader_overlay').remove();
  };

  // Constructor Call
  $this.init();
};
