
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
      <?php $strNav = 'settings'; include_once('includes/navigation.php');?>
    </div>
  </nav>

  <div class="container" style="margin-bottom: 100px;">
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="display-4"><i class="fa fa-cogs"></i> Settings</h1>
          <p class="lead">Here you can administrate your account.</p>
        </div>
      </div>
    </div>

    <div class="row" id="warning-firstlogin" style="display: none;">
      <div class="col-md-12">
        <div class="alert alert-warning" role="alert">
          <b>WARNING:</b> Please customize and save your character.
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom: 20px;">
      <div class="col-md-6">
        <div class="card" id="character_card">
          <div class="card-body">
            <h5>Customize Character</h5>
            <form>
              <div class="form-group">
                <label for="character_name">Character Name</label>
                <input type="text" class="form-control" id="character_name" aria-describedby="emailHelp" placeholder="Enter Character Name">
                <small id="character_name_help" class="form-text text-danger"></small>
              </div>
            </form>
            <label for="titel">Character Look</label>
            <table style="width:100%; margin-bottom: 0px;">
              <tr>
                <td style="width:50%; border: 1px dashed #999999; text-align: center;">
                  <img id="character_image" src="">
                </td>
                <td style="width:50%;">
                  <div class="btn-group float-right" role="group" aria-label="Basic example" style="margin-bottom: 10px;">
                    <button id="character_last_body" type="button" class="btn btn-secondary"><i class="fa fa-chevron-circle-left"></i></button>
                    <button type="button" class="btn btn-dark" style="width: 130px;">Body</button>
                    <button id="character_next_body" type="button" class="btn btn-secondary"><i class="fa fa-chevron-circle-right"></i></button>
                  </div>
                  <div class="btn-group float-right" role="group" aria-label="Basic example" style="margin-bottom: 10px;">
                    <button id="character_last_face" type="button" class="btn btn-secondary"><i class="fa fa-chevron-circle-left"></i></button>
                    <button type="button" class="btn btn-dark" style="width: 130px;">Face</button>
                    <button id="character_next_face" type="button" class="btn btn-secondary"><i class="fa fa-chevron-circle-right"></i></button>
                  </div>
                  <div class="btn-group float-right" role="group" aria-label="Basic example">
                    <button id="character_last_hair" type="button" class="btn btn-secondary"><i class="fa fa-chevron-circle-left"></i></button>
                    <button type="button" class="btn btn-dark" style="width: 130px;">Hair</button>
                    <button id="character_next_hair" type="button" class="btn btn-secondary"><i class="fa fa-chevron-circle-right"></i></button>
                  </div>
                </td>
              </tr>
              <tr>
                <td>
                  <div class="btn-group" role="group" aria-label="Basic example" style="margin-left: 50%; left: -42px; margin-top: 5px;">
                    <button id="character_turn_left" type="button" class="btn btn-secondary"><i class="fa fa-chevron-circle-left"></i></button>
                    <button id="character_turn_right" type="button" class="btn btn-secondary"><i class="fa fa-chevron-circle-right"></i></button>
                  </div>
                </td>
                <td></td>
              </tr>
            </table>
            <button id="character_button" class="btn btn-primary float-right">Save Character</button>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card" id="password_card">
          <div class="card-body">
            <h5>Change Password</h5>
            <form style="margin-bottom: 50px;">
              <div class="form-group">
                <label for="password_old">Present Password</label>
                <input type="password" class="form-control" id="password_old" placeholder="Old Password">
                <small id="password_old_help" class="form-text text-danger"></small>
              </div>
              <div class="form-group">
                <label for="password_new">New Password</label>
                <input type="password" class="form-control" id="password_new" placeholder="New Password">
                <small id="password_new_help" class="form-text text-danger"></small>
              </div>
              <div class="form-group">
                <label for="password_renew">New Re. Password</label>
                <input type="password" class="form-control" id="password_renew" placeholder="New Re. Password">
                <small id="password_renew_help" class="form-text text-danger"></small>
              </div>
            </form>
            <button id="password_button" class="btn btn-primary float-right">Change Password</button>
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom: 50px;">
      <div class="col-md-6 offset-md-6">
        <div class="card" id="delete_card">
          <div class="card-body">
            <h5>Delete Character</h5>
            <div class="form-group">
              <label for="delete_password">Your Password</label>
              <input type="password" class="form-control" id="delete_password" placeholder="Password Confirmation">
              <small id="delete_password_help" class="form-text text-danger"></small>
            </div>
            <button id="delete_button" class="btn btn-danger float-right">Delete Character</button>
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
  <script src="assets/javascript/settings.js"></script>
</body>
</html>
