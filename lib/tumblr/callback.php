<?php

require(__DIR__ . '/OAuth/http.php');
require(__DIR__ . '/OAuth/oauth_client.php');

$creds_file = file_get_contents('../config/config.json');
$creds      = json_decode($creds_file, true);

$client = new oauth_client_class;
$client->server = 'Tumblr';

session_start();

$client->client_id           = $creds['tumblr']['client_id'];;
$client->client_secret       = $creds['tumblr']['client_secret'];;
$client->access_token        = $_SESSION['OAUTH_ACCESS_TOKEN']['http://www.tumblr.com/oauth/access_token']['value'];
$client->access_token_secret = $_SESSION['OAUTH_ACCESS_TOKEN']['http://www.tumblr.com/oauth/access_token']['secret'];

if($success = $client->Initialize())
{
    if($success = $client->Process())
    {
        $_SESSION['token']          = $client->access_token;
        $_SESSION['secret']         = $client->access_token_secret;
        $_SESSION['client_id']      = $client->client_id;
        $_SESSION['client_secret']  = $client->client_secret;
    }
    $success = $client->Finalize($success);
}

if($success) {
    header('Location: ../');
} else {
    die('Tokens are missing!');
}

?>