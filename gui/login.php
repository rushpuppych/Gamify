
<?php
// Login Page Security Only
include_once "../lib/global.php";
$arrConfig = getConfig('page');
SESSION_START();
SESSION_DESTROY();
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
      <ul class="navbar-nav mr-auto">
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container" style="margin-bottom: 100px;">
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="display-4"><i class="fa fa-lock"></i> Login</h1>
          <p class="lead">Please Login or signup and experience the awesomenes of Gamification.</p>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6" style="margin-bottom: 50px;">
        <div class="card" id="login_card">
          <div class="card-body">
            <h4>Login</h4>
            <form>
              <div class="form-group">
                <label for="login_email">Email address</label>
                <input type="email" class="form-control" id="login_email" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="login_email_help" class="form-text text-danger"></small>
              </div>
              <div class="form-group">
                <label for="login_password">Password</label>
                <input type="password" class="form-control" id="login_password" placeholder="Password">
                <small id="login_password_help" class="form-text text-danger"></small>
              </div>
              <br>
              <button type="button" class="btn btn-primary float-right" id="login_button">Login</button>
              <a href="#" class="float-right" id="login_reset" style="margin-right: 30px; margin-top: 10px;">forgot your password ?</a>
            </form>
          </div>
        </div>

        <div class="card" style="margin-top: 40px;">
          <div class="card-body">
            <h4>Impressum</h4>
              <?php echo $arrConfig['impressum_info'];?><br>
              <img src="<?php echo $arrConfig['impressum_logo'];?>" width="200px" class="float-right">
              <b><?php echo $arrConfig['impressum_name'];?></b><br>
              <?php echo $arrConfig['impressum_street'];?><br>
              <?php echo $arrConfig['impressum_place'];?><br>
              <?php echo $arrConfig['impressum_website'];?><br>
              <?php echo $arrConfig['impressum_email'];?><br>
              <?php echo $arrConfig['impressum_phone'];?><br>
              <br>
          </div>
        </div>
      </div>
      <div class="col-md-6" style="margin-bottom: 50px;">
        <div class="card" id="signup_card">
          <div class="card-body">
            <h4>Signup</h4>
            <form>
              <div class="form-group">
                <label for="exampleInputEmail1">Select your Fraction (Company Team)</label>
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel" data-interval="false" style="border: 1px solid #999999; border-radius: 5px; min-height: 200px;">
                  <ol class="carousel-indicators" style="padding: 5px; background-color: #555555; border-radius: 10px;">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="5"></li>
                  </ol>
                  <div class="carousel-inner">
                    <div class="carousel-item active" data-fraction="holy_knights">
                      <img class="d-block w-100" src="assets/images/fraction/holy_knights.png" alt="First slide">
                    </div>
                    <div class="carousel-item" data-fraction="high_elves">
                      <img class="d-block w-100" src="assets/images/fraction/high_elves.png" alt="First slide">
                    </div>
                    <div class="carousel-item" data-fraction="orcish_horde">
                      <img class="d-block w-100" src="assets/images/fraction/orcish_horde.png" alt="First slide">
                    </div>
                    <div class="carousel-item" data-fraction="deamons">
                      <img class="d-block w-100" src="assets/images/fraction/deamons.png" alt="First slide">
                    </div>
                    <div class="carousel-item" data-fraction="the_undead">
                      <img class="d-block w-100" src="assets/images/fraction/the_undead.png" alt="First slide">
                    </div>
                    <div class="carousel-item" data-fraction="mountain_clan">
                      <img class="d-block w-100" src="assets/images/fraction/mountain_clan.png" alt="First slide">
                    </div>
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true" style="background-color: #555555; border: 10px solid #555555; padding: 10px; border-radius: 30px;"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true" style="background-color: #555555; border: 10px solid #555555; padding: 10px; border-radius: 30px;"></span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
              <div class="form-group">
                <label for="signup_email">Email address</label>
                <input type="email" class="form-control" id="signup_email" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="signup_email_help" class="form-text text-danger"></small>
              </div>
              <div class="form-group">
                <label for="signup_password">Password</label>
                <input type="password" class="form-control" id="signup_password" placeholder="Password">
                <small id="signup_password_help" class="form-text text-danger"></small>
              </div>
              <div class="form-group">
                <label for="signup_repassword">Retype Password</label>
                <input type="password" class="form-control" id="signup_repassword" placeholder="Password">
                <small id="signup_repassword_help" class="form-text text-danger"></small>
              </div>
              <br>
              <button type="button" class="btn btn-primary float-right" id="signup_button">Signup</button>
            </form>

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
  <script src="assets/javascript/login.js"></script>
</body>
</html>
