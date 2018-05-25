
<?php include_once('includes/security.php'); ?>
<html lang="en">
<head>
  <meta charset="utf-8">

  <title>Gamify</title>
  <meta name="description" content="The HTML5 Herald">
  <meta name="author" content="SitePoint">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="vendor/bootstrap-4.0.0-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="vendor/fontawesome-5.0.8/css/fontawesome-all.min.css">
  <link rel="stylesheet" href="vendor/tooltipster/dist/css/tooltipster.main.min.css">

  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body class="rpg_body">
  <nav class="navbar navbar-expand-lg bg-dark navbar-dark" style="margin-bottom:20px;">
    <a class="navbar-brand" href="#" style="font-size: 30px;"><i class="fa fa-gamepad"></i> Gamify</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <?php $strNav = 'character'; include_once('includes/navigation.php');?>
    </div>
  </nav>

  <div class="container" style="margin-bottom: 100px;">
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="display-4"><i class="fa fa-street-view"></i> Character</h1>
          <p class="lead">This is your Character. You can overlook your stats and equip items to improve them.</p>
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom: 50px;">
      <div class="col-md-6" style="margin-bottom: 10px;">
        <div class="card" id="player_card">
          <div class="card-body">
            <h4 id="player_name"></h4>
            <p>Level <span id="level_actual"></span> - (<span id="level_exp"></span> / <span id="level_next_exp"></span>)</p>
            <div id="level_progress"></div>
            <div class="progress">
              <div class="progress-bar" id="level_progressbar_min" role="progressbar" style="width:0%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
              <span id="level_progressbar_max" style="margin-left: 10px; margin-top: -1px;"></span>
            </div>
            <br>
            <img id="player_image" alt="character" class="mx-auto d-block" src="">
          </div>
        </div>
        <br>
        <div class="card" id="equipded_card">
          <div class="card-body">
          </div>
        </div>
        <br>
        <div class="card">
          <div class="card-block">
            <table class="table">
              <tr style="height: 57px;">
                <th style="width: 40%;">Health</th>
                <td style="width: 20%;"><span id="stats_player_health"></span></td>
                <td style="width: 20%;"><i style="color: #00ff00">+<span id="stats_item_health">0</span></player></i></td>
                <td style="width: 20%;"><i style="font-weight: bold;">= <span id="stats_item_health_total">0</span></player></i></td>
              </tr>
              <tr style="height: 57px;">
                <th style="width: 40%;">Attack</th>
                <td style="width: 20%;"><span id="stats_player_attack"></span></td>
                <td style="width: 20%;"><i style="color: #00ff00">+<span id="stats_item_attack">0</span></i></td>
                <td style="width: 20%;"><i style="font-weight: bold;">= <span id="stats_item_attack_total">0</span></player></i></td>
              </tr>
              <tr style="height: 57px;">
                <th style="width: 40%;">Defence</th>
                <td style="width: 20%;"><span id="stats_player_defence"></span></td>
                <td style="width: 20%;"><i style="color: #00ff00">+<span id="stats_item_defence">0</span></i></td>
                <td style="width: 20%;"><i style="font-weight: bold;">= <span id="stats_item_defence_total">0</span></player></i></td>
              </tr>
              <tr style="height: 57px;">
                <th style="width: 40%;">Agility</th>
                <td style="width: 20%;"><span id="stats_player_agility"></span></td>
                <td style="width: 20%;"><i style="color: #00ff00">+<span id="stats_item_agility">0</span></i></td>
                <td style="width: 20%;"><i style="font-weight: bold;">= <span id="stats_item_agility_total">0</span></player></i></td>
              </tr>
              <tr style="height: 50px;">
                <th style="width: 40%;">Luck</th>
                <td style="width: 20%;"><span id="stats_player_luck"></span></td>
                <td style="width: 20%;"><i style="color: #00ff00">+<span id="stats_item_luck">0</span></i></td>
                <td style="width: 20%;"><i style="font-weight: bold;">= <span id="stats_item_luck_total">0</span></player></i></td>
              </tr>
            </table>
          </div>
        </div>
      </div>

      <div class="col-md-6" style="margin-bottom: 10px;">
        <ul class="nav nav-tabs" id="inventarTabs" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" href="#weapon_card" id="weapon_tab" data-toggle="tab">
              <img src="assets/images/ui/weapon_icon.gif">
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#shield_card" id="shield_tab" data-toggle="tab">
              <img src="assets/images/ui/shield_icon.gif">
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#armor_card" id="armor_tab" data-toggle="tab">
              <img src="assets/images/ui/armor_icon.gif">
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#helmet_card" id="helmet_tab" data-toggle="tab">
              <img src="assets/images/ui/helmet_icon.gif">
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="#special_card" id="special_tab" data-toggle="tab">
              <img src="assets/images/ui/special_icon.gif">
            </a>
          </li>
        </ul>
        <div class="card" style="border-top: 0px; border-top-left-radius: 0px;">
          <div class="card-body" style="height: 689px; overflow: auto;">
            <div class="row">
              <div class="tab-content" id="inventarTabsContent">
                <div class="tab-pane fade show active" id="weapon_card" role="tabpanel" aria-labelledby="weapon_tab"></div>
                <div class="tab-pane fade" id="shield_card" role="tabpanel" aria-labelledby="shield_tab"></div>
                <div class="tab-pane fade" id="armor_card" role="tabpanel" aria-labelledby="armor_tab"></div>
                <div class="tab-pane fade" id="helmet_card" role="tabpanel" aria-labelledby="helmet_tab"></div>
                <div class="tab-pane fade" id="special_card" role="tabpanel" aria-labelledby="special_tab"></div>

                <!--
                <span class="item-container"><img src="assets/images/ui/weapon_icon.gif" class="rounded"></span>
                <span class="item-container item-active"><img src="assets/images/ui/weapon_icon.gif" class="rounded"></span>
                <span class="item-container"><img src="assets/images/ui/weapon_icon.gif" class="rounded"></span>
                -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include_once('includes/footer.php');?>
  <script src="vendor/jquery-3.3.1/jquery-3.3.1.min.js"></script>
  <script src="vendor/popper.js/popper.min.js"></script>
  <script src="vendor/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
  <?php include_once('includes/javascript.php');?>
  <script src="assets/javascript/character.js"></script>
</body>
</html>
