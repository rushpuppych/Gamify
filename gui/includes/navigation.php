
<!-- MAIN NAVIGATION -->
<ul class="navbar-nav mr-auto">

  <!-- Quests -->
  <li class="nav-item <?php if($strNav == 'quests') {echo "active";}?>">
    <a class="nav-link" href="quests.php"> <i class="fa fa-chess-rook"></i> Quests</a>
  </li>

  <!-- Battle -->
  <li class="nav-item <?php if($strNav == 'battle') {echo "active";}?>">
    <a class="nav-link" href="battle.php"> <i class="fa fa-bomb"></i> Battle</a>
  </li>

  <!-- Character Equip & Stats -->
  <li class="nav-item <?php if($strNav == 'character') {echo "active";}?>">
    <a class="nav-link" href="character.php"> <i class="fa fa-street-view"></i> Character</a>
  </li>

  <!-- ScoreBoard -->
  <li class="nav-item <?php if($strNav == 'scoreboard') {echo "active";}?>">
    <a class="nav-link" href="scoreboard.php"> <i class="fa fa-trophy"></i> Scoreboard</a>
  </li>

  <!-- Archivements -->
  <li class="nav-item <?php if($strNav == 'achievements') {echo "active";}?>">
    <a class="nav-link" href="achievements.php"> <i class="fa fa-list-ul"></i> Achievements</a>
  </li>


</ul>

<!-- SPECIAL MENU -->
<ul class="nav navbar-nav navbar-right">
  <!-- Settings -->
  <li class="nav-item <?php if($strNav == 'settings') {echo "active";}?>">
    <a class="nav-link" href="settings.php"> <i class="fa fa-cogs"></i> Settings</a>
  </li>

  <!-- Logout -->
  <li><a href="#"><a class="nav-link" href="login.php"> <i class="fa fa-sign-out-alt"></i> Logout</a></li>
</ul>
