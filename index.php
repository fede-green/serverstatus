<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <META HTTP-EQUIV="refresh" CONTENT="15">
    <meta name="viewport" content="wxidth=device-width, initial-scale=1">
    <title>Care Status</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="css/style.css"/>
  </head>
  <body role="document">
<?php
require_once 'vendor/autoload.php';
//require_once 'vendor/ma-ve/uptimerobot/src/UptimeRobot.php';
require_once 'conf/config.php';

$upRobot = new \Mave\UptimeRobot\UptimeRobot($api);

/**
 * Get monitors
 */
$monitors = $upRobot->getMonitors(); //Get all monitors
$upservers = 0;
$downservers = 0;
$pausedservers = 0;
$paused_what = array();
$down_what = array();
foreach($monitors->monitors as $monitors_arr){
  foreach($monitors_arr as $monitor){
    switch ($monitor->status) {
      case '2':
        $upservers ++;
        break;
      case '0':
        $pausedservers ++;
        $paused_what[] = $monitor;
        break;
      case '8':
        $down_what[] = $monitor;
        $downservers ++;
      break;
      case '9':
        $down_what[] = $monitor;
        $downservers ++;
      break;
    }
  }
}
?>
<div role="main" class="container theme-showcase">
  <div class="page-header">
  <h1>Care Status</h1>
  </div>
  <h2>
  <span class='label label-success'><?= $upservers ?> servers up</span>
  <span class='label label-warning'><?= $pausedservers ?> servers paused</span>
  <span class='label label-danger'><?= $downservers ?> servers down</span>
  </h2>
  <div class="row">
  <?php
  if($pausedservers > 0){
    ?>
    <div class="page-header">
      <h2>Servers Paused</h2>
    </div>
    <?php
    foreach($paused_what as $monitor){
      ?>
      <div class="col-sm-4">
        <div class="panel panel-warning">
          <div class="panel-heading">
            <h3 class='panel-title'><?= $monitor->friendlyname ?></h3>
          </div>
          <div class='panel-body'><?= $monitor->url ?></div>
        </div>
      </div>
      <?php
    }
  }
  ?>
  <?php
  if($downservers > 0){
    ?>
    <div class="page-header">
      <h2>Servers down</h2>
    </div>
    <?php
    foreach($down_what as $monitor){
      ?>
      <div class="col-sm-4">
        <div class="panel panel-danger">
          <div class="panel-heading">
            <h3 class='panel-title'><?= $monitor->friendlyname ?></h3>
          </div>
          <div class='panel-body'><?= $monitor->url ?></div>
        </div>
      </div>
      <?php
    }
  }
  ?>
  </div>
</div>
<footer class="footer">
  <div class="container">
    <p>
      Dashboard recap of Wunderkraut's Uptimerobot monitors. Done with <a href="https://github.com/watchfulli/uptimeRobot">uptimeRobot</a> and using <a href="http://getbootstrap">Bootstrap</a>.
    </p>
  </div>
</footer>
</body>
