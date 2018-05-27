
<?php
include_once('includes/security.php');
include_once('../lib/global.php');

// Logic for AddButton
$boolShowAddButton = false;
if(getConfig('game')['create_quests'] == 'all') {
  $boolShowAddButton = true;
}
if(is_array(getConfig('game')['create_quests'])) {
  if(in_array($_SESSION['user']['id'], getConfig('game')['create_quests'])) {
    $boolShowAddButton = true;
  }
}
?>

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
  <link href="vendor/summernote-0.8.9-dist/summernote-bs4.css" rel="stylesheet">
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
      <?php $strNav = 'quests'; include_once('includes/navigation.php');?>
    </div>
  </nav>

  <div class="container" style="margin-bottom: 100px;">
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="display-4"><i class="fa fa-chess-rook"></i> Quests</h1>
          <p class="lead">Solve Quests to gain experience and level up your character.</p>
        </div>
      </div>
    </div>
    <div class="row" style="margin-bottom: 20px;">
      <div class="col-sm-12">
        <div class="card" id="quest_add_card">
          <div class="card-body">
            <?php if($boolShowAddButton) { ?>
            <button id="quest_create_button" class="btn btn-primary float-right">Create Quest</button>
            <?php } ?>
            <div class="float-right" style="width: 200px; margin-right: 10px;">
              <input id="scann_code_input" type="file" style="cursor: pointer; width: 200px; height: 39px; position: absolute; opacity: 0;">
              <button id="quest_scan_button" class="btn btn-success btn-block">Scan Quest Code</button>
            <div>
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom: 50px;">
      <div class="col-sm-12">

        <!-- Quest Pool -->
        <div class="card" id="quest_list_card">
          <div class="card-block">
            <table class="table table-hover">
              <thead class="thead-inverse">
                <tr>
                  <th>Running Quests</th>
                  <th width="100px">Exp.</th>
                  <th width="100px">Piority</th>
                  <th width="180px">Timer</th>
                  <th width="105px"></th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>

      </div>
    </div>
  </div>

  <?php include_once('includes/footer.php');?>
  <script src="vendor/jquery-3.3.1/jquery-3.3.1.min.js"></script>
  <script src="vendor/popper.js/popper.min.js"></script>
  <script src="vendor/bootstrap-4.0.0-dist/js/bootstrap.min.js"></script>
  <script src="vendor/summernote-0.8.9-dist/summernote-bs4.js"></script>
  <script src="vendor/qrcode/qrcode.min.js"></script>
  <?php include_once('includes/javascript.php');?>
  <script src="assets/javascript/quests.js"></script>
</body>
</html>
