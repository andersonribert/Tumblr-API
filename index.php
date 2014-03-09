<?php

ini_set('display_errors',1);

include(__DIR__ . '/tumblr/vendor/autoload.php');

session_start();

use Tumblr\API\Client as TClient;

$consumerKey = $_SESSION['client_id'];
$consumerSecret = $_SESSION['client_secret'];
$token = $_SESSION['token'];
$tokenSecret = $_SESSION['secret'];

$client = new TClient($consumerKey, $consumerSecret);
$client->setToken($_SESSION['token'], $_SESSION['secret']);

session_start();

print_r($client->getUserInfo());


?>