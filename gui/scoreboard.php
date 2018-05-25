
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
      <?php $strNav = 'scoreboard'; include_once('includes/navigation.php');?>
    </div>
  </nav>

  <div class="container" style="margin-bottom: 100px;">
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="display-4"><i class="fa fa-trophy"></i> Scoreboard</h1>
          <p class="lead">This is the Storeboard Section. Here You can compare your character with the others.</p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6" style="margin-bottom: 20px;">
        <div class="card">
          <div class="card-body">
            <h4>Experience Ranking</h4>
            <div id="experience_ranking" style="max-height: 465px; min-height: 465px; overflow: auto;">
              <center>No Entrys</center>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6" style="margin-bottom: 20px;">
        <div class="card">
          <div class="card-body">
            <h4>Battle Ranking</h4>
            <div id="battle_ranking" style="max-height: 465px; min-height: 465px; overflow: auto;">
              <center>No Entrys</center>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6" style="margin-bottom: 20px;">
        <div class="card">
          <div class="card-body">
            <h4>Top 10 Weapons</h4>
            <div id="weapon_ranking" style="max-height: 465px; min-height: 465px; overflow: auto;">
              <center>No Entrys</center>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6" style="margin-bottom: 20px;">
        <div class="card">
          <div class="card-body">
            <h4>Top 10 Armors</h4>
            <div id="armor_ranking" style="max-height: 465px; min-height: 465px; overflow: auto;">
              <center>No Entrys</center>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6" style="margin-bottom: 20px;">
        <div class="card">
          <div class="card-body">
            <h4>Top 10 Shieldings</h4>
            <div id="shield_ranking" style="max-height: 465px; min-height: 465px; overflow: auto;">
              <center>No Entrys</center>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-6" style="margin-bottom: 20px;">
        <div class="card">
          <div class="card-body">
            <h4>Top 10 Specials</h4>
            <div id="special_ranking" style="max-height: 465px; min-height: 465px; overflow: auto;">
              <center>No Entrys</center>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!--
    <div class="row">
      <div class="col-md-6" style="margin-bottom: 20px;">
        <div class="card">
          <div class="card-body">
            <h4>Top 10 Achievements</h4>
            TODO
          </div>
        </div>
      </div>
      <div class="col-md-6" style="margin-bottom: 20px;">
        <div class="card">
          <div class="card-body">
            <h4>Top 10 Finished Quests</h4>
            TODO
          </div>
        </div>
      </div>
    </div>
    -->
  </div>

  <?php include_once('includes/footer.php');?>
  <script src="vendor/jquery-3.3.1/jquery-3.3.1.min.js"></script>
  <script src="vendor/popper.js/popper.min.js"></script>
  <script src="vendor/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
  <?php include_once('includes/javascript.php');?>
  <script src="assets/javascript/scoreboard.js"></script>
</body>
</html>
