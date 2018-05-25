
var Controller = function() {
  var $this = this;
  var _private = {};
  var _ajax = new AjaxHelper();
  var _ui = new UiHelper();

  // Helper System Variables
  this.options = {
    ranking_counts: ['5', '10', '25', '50', '250', '500', '1000', '2500', '5000', '10000'],
    ranking_colors: ['white', 'gray', 'violet', 'purple', 'blue', 'green', 'turquoise', 'brown', 'orange', 'red'],
    ranking_names: ['Novice', 'Beginner', 'Advanced', 'Warrior', 'General', 'Warlord', 'King', 'Hero', 'Legend', 'Grandmaster']
  }

  // constructor
  this.init = function() {
    $this.eventManager();
    $this.loadAchivements();
  };

  this.eventManager = function() {

  };

  this.loadAchivements = function() {
    _ajax.sendPostFromCard($('#achivements'), 'achievements_load_player_data', {}, function(objResponse) {
      if(objResponse.status) {
        // Battle

        $this.createAchivement('{name} of the Champoins.', 'For winning {count} finals.', objResponse.achievment_data.champion);
        $this.createAchivement('{name} of the Battle.', 'For winning {count} Semifinals.', objResponse.achievment_data.semifinals);
        $this.createAchivement('{name} of War.', 'For winning {count} Quaterfinals.', objResponse.achievment_data.semifinals);

        // Looting
        $this.createAchivement('{name} in Epic Looting.', 'For looting {count} Epic items.', objResponse.achievment_data.epic_item);
        $this.createAchivement('{name} in Legendary Looting.', 'For looting {count} Legendary items.', objResponse.achievment_data.legendary_item);
        $this.createAchivement('{name} in Divine Looting.', 'For looting {count} Divine items.', objResponse.achievment_data.divine_item);

        // Others
        $this.createAchivement('{name} in Wisdom.', 'For gaining {count} levels.', objResponse.achievment_data.level);
        $this.createAchivement('{name} of Questing.', 'For accomplishing {count} quests.', objResponse.achievment_data.finished_quests);
      }
    });
  };

  this.createAchivement = function(strTitle, strText, numCount) {
    // Create Rank from Count
    var numRank = '-';
    for(var numRankCount in $this.options.ranking_counts) {
      if(numCount >= parseInt($this.options.ranking_counts[numRankCount])) {
        if(numRank == '-') {
          numRank = 0;
        } else {
          numRank++;
        }
      }
    }

    // No Medal
    var strSetTitle = strTitle.replace('{name}', 'Nothing');
    var strSetText = 'You do not deserve this medal';
    var strSetColor = 'none';

    // Replace PlaceHolders
    if(numRank != '-') {
      strSetTitle = strTitle.replace('{name}', $this.options.ranking_names[numRank]);
      strSetText = strText.replace('{count}', $this.options.ranking_counts[numRank]);
      strSetColor = $this.options.ranking_colors[numRank];
    }

    // Create Template
    strHtml = '';
    strHtml += '<div class="col-md-4" style="margin-bottom: 20px;">';
    strHtml += '  <div class="card" style="font-size: 14px;">';
    strHtml += '    <div class="card-body" style="min-height: 175px;">';
    strHtml += '      <div class="row">';
    strHtml += '        <div class="col-3" style="text-align: center;">';
    strHtml += '          <div style="text-transform: uppercase; background-color: gray; color: white; width: 100%; font-size: 12px;"><b>' + strSetColor + '</b></div>';
    strHtml += '          <img src="assets/images/badges/' + strSetColor + '.png" style="width: 100%;">';
    strHtml += '        </div>';
    strHtml += '        <div class="col-9">';
    strHtml += '          <b>' + strSetTitle + '</b><br>';
    strHtml += '          ' + strSetText + '<br>';
    strHtml +=            _private.createMedals(numRank);
    strHtml += '        </div>';
    strHtml += '      </div>';
    strHtml += '    </div>';
    strHtml += '  </div>';
    strHtml += '</div>';

    // Add Achivement
    $('#achivements').append(strHtml);
  };

  /**
  * Create Medal Icons
  */
  _private.createMedals = function(numRank) {
    var strHtml = '';
    var strColor = 'none';
    for(numCount = 0; numCount < $this.options.ranking_counts.length; numCount++) {
      if(numCount <= numRank && numRank != '-') {
        strColor = $this.options.ranking_colors[numCount];
        strHtml += '<img src="assets/images/badges/' + strColor + '.png" class="pull-left"style="width: 8%; margin-top: 5px; margin-right: 2%">';
      } else {
        strHtml += '<img src="assets/images/badges/none.png" class="pull-left"style="width: 8%; margin-top: 5px;  margin-right: 2%">';
      }
    }
    return strHtml;
  };

  // Constructor Call
  $this.init();
};
var controller = new Controller();
