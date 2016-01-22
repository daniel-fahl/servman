<?php

require __DIR__ . '/vendor/autoload.php';

use DigitalOceanV2\Adapter\GuzzleAdapter;
use DigitalOceanV2\DigitalOceanV2;

include_once 'config.php';

// create an adapter with DigitalOcean access token
// and initialize DigitalOceanV2 API object
$adapter = new GuzzleAdapter($apikey);
$digitalocean = new DigitalOceanV2($adapter);

$userInfo = $digitalocean->account()->getUserInformation();

// Get all available images
$allImages = $digitalocean->image()->getAll(['type' => 'snapshot', 'private' => true]);
$images = array();
foreach($allImages as $image) {
  if (strpos($image->name, 'servman-') === 0) {
    array_push($images, $image);
  }
}

// Get all manageabe running droplets
$allDroplets = $digitalocean->droplet()->getAll();
$droplets = array();
foreach($allDroplets as $droplet) {
  array_push($droplets, $droplet);
}


?>
<!doctype html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang=""> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8" lang=""> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9" lang=""> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang=""> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>servman - Manage GodmodeX.de Servers</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="apple-touch-icon" href="apple-touch-icon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <style>
            body {
                padding-top: 50px;
                padding-bottom: 20px;
            }
        </style>
        <link rel="stylesheet" href="css/bootstrap-theme.min.css">
        <link rel="stylesheet" href="css/main.css">

        <script src="js/vendor/modernizr-2.8.3-respond-1.4.2.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
            <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">ServMan</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
          <ul class="nav navbar-nav navbar-right">
            <li>
              <a href="#">You are using the account of <?=$userInfo->email?></a>
            </li>
          </ul>
        </div><!--/.navbar-collapse -->
      </div>
    </nav>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="jumbotron">
      <div class="container">
        <h1>Server Management</h1>
        <p>This website can be used as a management console for game servers. Select one of the snapshots you want to create a server from, and get your gaming started.</p>
        <p>And as always: <b>Get your Godmode on!</b></p>
      </div>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <h3>Images</h3>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Image Name</th>
                <th>Date Created</th>
                <th>Setup Server</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($images as $image): ?>
              <tr>
                <td><?=$image->id?></td>
                <td><?=str_replace('servman-', '', $image->name)?></td>
                <td><?=$image->createdAt?></td>
                <td><a class="btn btn-success" href="#" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
      <div class="row">

        <div class="col-md-12">
          <h3>Servers</h3>
          <table class="table">
            <thead>
              <tr>
                <th>#</th>
                <th>Server Name</th>
                <th>Server IP</th>
                <th>Server Status</th>
                <th>Date Created</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($droplets as $server): ?>
              <tr>
                <td><?=$server->id?></td>
                <td><?=str_replace('servman-', '', $server->name)?></td>
                <td><?=$server->networks[0]->ipAddress?></td>
                <td><?=$server->status?></td>
                <td><?=$server->createdAt?></td>
                <td>
                  <a class="btn btn-warning" href="#" role="button">Restart</a>
                  <a class="btn btn-danger" href="#" role="button">Destroy</a>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>





        <!--div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec id elit non mi porta gravida at eget metus. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus. Etiam porta sem malesuada magna mollis euismod. Donec sed odio dui. </p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
       </div>
        <div class="col-md-4">
          <h2>Heading</h2>
          <p>Donec sed odio dui. Cras justo odio, dapibus ac facilisis in, egestas eget quam. Vestibulum id ligula porta felis euismod semper. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
          <p><a class="btn btn-default" href="#" role="button">View details &raquo;</a></p>
        </div>
      </div-->

      <hr>

      <footer>
        <p>&copy; GodmodeX Germany</p>
      </footer>
    </div> <!-- /container -->        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="js/vendor/jquery-1.11.2.min.js"><\/script>')</script>

        <script src="js/vendor/bootstrap.min.js"></script>

        <script src="js/main.js"></script>

        <!-- Google Analytics: change UA-XXXXX-X to be your site's ID. -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-XXXXX-X','auto');ga('send','pageview');
        </script>
    </body>
</html>
