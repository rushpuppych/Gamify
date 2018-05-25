
var UiHelper = function() {
  var $this = this;
  var _private = {};

  // Local Vars
  this.options = {

  }

  // constructor
  this.init = function() {
  };

  this.uuid = function() {
      function s4() {
        return Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);
      }
      return s4() + s4() + '-' + s4() + '-' + s4() + '-' + s4() + '-' + s4() + s4() + s4();
  };

  this.showModal = function(strTitle, strContentHtml, objButtons, fncOnLoad) {
    // Draw modal if not already exist
    var strUuid = $this.uuid();
    if($('#show_generic_modal_' + strUuid).length == 0) {
      var strHtml = '';
      strHtml += '<div id="show_generic_modal_' + strUuid + '" class="modal fade">';
      strHtml += '  <div class="modal-dialog" role="document">';
      strHtml += '    <div class="modal-content">';
      strHtml += '      <div class="modal-header">';
      strHtml += '        <h5 class="modal-title"></h5>';
      strHtml += '        <button type="button" class="close" data-dismiss="modal" aria-label="Close">';
      strHtml += '          <span aria-hidden="true">&times;</span>';
      strHtml += '        </button>';
      strHtml += '      </div>';
      strHtml += '      <div class="modal-body">';
      strHtml += '      </div>';
      strHtml += '      <div class="modal-footer">';
      strHtml += '        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>';
      strHtml += '      </div>';
      strHtml += '    </div>';
      strHtml += '  </div>';
      strHtml += '</div>';
      $('body').append(strHtml);
    }

    // Config Modal content
    $('#show_generic_modal_' + strUuid).on('show.bs.modal', function (event) {
      var elModal = $(this)
      elModal.find('h5.modal-title').html(strTitle);
      elModal.find('div.modal-body').html(strContentHtml);
      elModal.find('div.modal-footer').html('');

      // Render Button
      for(var numIndex in objButtons) {
        // Calback Function
        var strFunction = 'data-dismiss="modal"';
        var strEventUuid = $this.uuid();
        if(typeof(objButtons[numIndex]['callback']) != 'undefined') {
          strFunction = 'id="show_generic_modal_event_' + strEventUuid + '"';
        }

        // Default Color
        var strColor = 'primary';
        if(typeof(objButtons[numIndex]['color']) != 'undefined') {
          strColor = objButtons[numIndex]['color'];
        }

        // Optional Data
        var strData = '';
        if(typeof(objButtons[numIndex]['data']) != 'undefined') {
          strData = objButtons[numIndex]['data'];
        }

        // Render Button
        strHtml = '<button type="button" ' + strFunction + ' data-data="' + strData + '" class="btn btn-' + strColor + '">' + objButtons[numIndex]['text'] + '</button>';
        elModal.find('div.modal-footer').append(strHtml);

        if(typeof(objButtons[numIndex]['callback']) != 'undefined') {
          $('#show_generic_modal_event_' + strEventUuid).on('click', objButtons[numIndex]['callback']);
        }
      }

      // Call Onload Callback
      if(typeof(fncOnLoad) == 'function') {
        fncOnLoad(elModal);
      }
    });

    // Open Modal
    $('#show_generic_modal_' + strUuid).modal();
  };

  // Constructor Call
  $this.init();
};
