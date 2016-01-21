<?php

require __DIR__ . '/vendor/autoload.php';

use DigitalOceanV2\adapter\GuzzleAdapter;
use DigitalOceanV2\DigitalOceanV2;

// create an adapter with DigitalOcean access token
// and initialize DigitalOceanV2 API object
$adapter = new BuzzAdapter('89ce7818d8f450c844d41e72f8b9be321a7d6d8401ddffb96aaad684ab3d6bda');
$digitalocean = new DigitalOceanV2($adapter);

$userInfo = $digitalocean->account()->getUserInformation();

var_dump($userInfo);

