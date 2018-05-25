
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
          <a class="nav-link" href="login.php">Login</a>
        </li>
      </ul>
    </div>
  </nav>

  <div class="container" style="margin-bottom: 100px;">
    <div class="row">
      <div class="col-md-12">
        <div class="jumbotron">
          <h1 class="display-4"><i class="fa fa-gamepad"></i> About Gamify</h1>
          <p class="lead">You are using Gamify version 1.0.0 Beta</p>
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom: 50px;">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h4>What is Gamification?</h4>
            <p>
              Gamification is the idea of adapting the concepts of gaming with reallife business cases. It is the technique of extracting the motivators from games (for example: levelsystem, itemsystems, scoreboards, archivements, challenge) and adding them to business tasks. This application is helping you if you want to add some gamification to your business.
            </p>
          </div>
        </div>
      </div>
    </div>
    <div class="row" style="margin-bottom: 50px;">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h4>Gamify Application</h4>
            <p>
              The Gamify Application (Framework) was coded because we didnt found something like that on the internet. We wantet do have a powefull motivation tool with full controll over the code. It can be used for research reason or as a business tool.
            </p>
            <h5>Licence (MIT)</h5>
            <p>
              Copyright 2018 John Doe (because i dont care.. just use it ;-)<br>
              Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:<br>
              The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.<br>
              THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.<br>
            </p>
            <h5>Project Goals</h5>
            <p>
              We want to provide a easy to use tool for every business application. So our goal is to deliver a slim application that works with just basic components and is easy to adapt or expand. For example it would be very easy to build in web_hooks or other features so that the tool fits your needs.
            </p>
            <h5>Resources</h5>
            <p>
              Here you can find all External resources we used for this Project.<br>
              <b>If you want to use this tool comercialy you should look at the licences for each resource.</b><br>
              <ul>
                <li>Text Logos: <a href="https://textcraft.net/">https://textcraft.net/</a></li>
                <li>Sprites: <a href="http://charas-project.net/">http://charas-project.net/</a></li>
              </ul>
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom: 50px;">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h4>Looking for Help ?</h4>
            <p>
              User Guide, Sys Admin Guide
            </p>
            <h5>Developement</h5>
            <p>
              <b>GitHub Repo:</b><br>
              https://github.com/rushpuppych/Gamify.git
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom: 50px;">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <h4>Credits</h4>
            <p>
              The Gamify project was developed in 2018 as a schoolar project. The goal behind the Gamify project was to realize a relational database driven application. So we decided to develop something usefull that is still tricky to manage.
            </p>
            <h5>Project Team:</h5>
            <p>
              <b>Mario Bruderer</b> - Projectmanager<br>
              <b>Andreas Datilo</b> - Database Administrator<br>
              <b>Severin Holm</b> - Core Web Developer<br>
            </p>
            <h5>Special Thanks to:</h5>
            <p>
              <b>Marc Löwenthal</b> - Database Instructor, Assessment Leader (hf-ict.ch)<br>
              <b>Italian John Doe</b> - For the invention of Coffe and Pizza (it wouldn't be possible without you)<br>
            </p>
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
</body>
</html>
