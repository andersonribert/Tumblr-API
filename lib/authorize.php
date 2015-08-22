<?php
ini_set('display_errors',1);
require(__DIR__ . '/OAuth/http.php');
require(__DIR__ . '/OAuth/oauth_client.php');

$creds_file = file_get_contents('../config/config.json');
$creds      = json_decode($creds_file, true);

$service = $_GET['service'];
// callback address, to receive tokens
$URL_CALLBACK = $creds[$service]['callback_url'];
// client id - from http://www.tumblr.com/oauth/apps
$CLIENT_ID = $creds[$service]['client_id'];
// client secret - from http://www.tumblr.com/oauth/apps
$CLIENT_SECRET = $creds[$service]['client_secret'];

$client = new oauth_client_class;
$client->debug = true;
$client->debug_http = true;
$client->server = ucfirst($service);
$client->redirect_uri = $URL_CALLBACK;

$client->client_id = $CLIENT_ID;
$client->client_secret = $CLIENT_SECRET;

if(!$client->client_id || !$client->client_secret)
	die('App Credentials missing');

if($success = $client->Initialize()) {
	$success = $client->Process();
	print_r($client);
	$success = $client->Finalize($success);
} else {
    die('Failed to get authorization');
}

?>
