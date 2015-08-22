<?php

require(__DIR__ . '/OAuth/http.php');
require(__DIR__ . '/OAuth/oauth_client.php');

$creds_file = file_get_contents('../config/config.json');
$creds      = json_decode($creds_file, true);

session_start();

$service = $_GET['service'];

print_r($_SESSION);

$client = new oauth_client_class;
$client->server = ucfirst($service);

session_start();

$client->client_id           = $creds[$service]['client_id'];;
$client->client_secret       = $creds[$service]['client_secret'];;
$client->access_token        = $_SESSION['OAUTH_ACCESS_TOKEN']['http://www.tumblr.com/oauth/access_token']['value'];
$client->access_token_secret = $_SESSION['OAUTH_ACCESS_TOKEN']['http://www.tumblr.com/oauth/access_token']['secret'];

if($success = $client->Initialize())
{
    if($success = $client->Process())
    {
        $_SESSION[$service]['token']          = $client->access_token;
        $_SESSION[$service]['secret']         = $client->access_token_secret;
        $_SESSION[$service]['client_id']      = $client->client_id;
        $_SESSION[$service]['client_secret']  = $client->client_secret;
    }
    $success = $client->Finalize($success);
}

if($success) {
    //header('Location: ../');
} else {
    die('Tokens are missing!');
}

?>