<?php
/*
 * login_with_tumblr.php
 *
 * @(#) $Id: login_with_tumblr.php,v 1.3 2013/07/31 11:48:04 mlemos Exp $
 *
 */

	/*
	 *  Get the http.php file from http://www.phpclasses.org/httpclient
	 */
	require(__DIR__ . '/lib/http.php');
	require(__DIR__ . '/lib/oauth_client.php');
	require(__DIR__ . '/lib/devCredentials.php');
	
	
	$dev_id = new dev_id;
	
	$client = new oauth_client_class;
	$client->debug = 1;
	$client->debug_http = 1;
	$client->server = 'Tumblr';
	$client->redirect_uri = 'http://'.$_SERVER['HTTP_HOST'].
		dirname(strtok($_SERVER['REQUEST_URI'],'?')).'/new_index.php';

	$client->client_id = $dev_id->client_id; $application_line = __LINE__;
	$client->client_secret = $dev_id->client_secret;
	
	if(strlen($client->client_id) == 0
	|| strlen($client->client_secret) == 0)
		die('Please go to Tumblr Apps page http://www.tumblr.com/oauth/apps , '.
			'create an application, and in the line '.$application_line.
			' set the client_id to Consumer key and client_secret with Consumer secret. '.
			'The Default callback URL must be '.$client->redirect_uri);

	if(($success = $client->Initialize()))
	{
		if(($success = $client->Process()))
		{
			if(strlen($client->access_token))
			{
				$success = $client->CallAPI(
					'http://api.tumblr.com/v2/user/info', 
					'GET', array(), array('FailOnAccessError'=>true), $user);
			}
		}
		$success = $client->Finalize($success);
	}
	if($client->exit)
		exit;
	if($success)
	{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>WATCH THE FRONT!</title>
<link href="lib/watchstyle.css" rel="stylesheet" type="text/css">
</head>
<body style="background-color:#2c4762" onload="setInterval('ShowTimes()',500)">

<h1 class="h1bigger">Welcome!</h1>	

<h1> To sign up : </h1>
</br>
</br>
</div>
  
</script></iframe>
</form>


<?php 
        
        
        
        
        	echo '<pre>', HtmlSpecialChars(print_r($user, 1)), '</pre>';
		echo '<h1> Hi ', HtmlSpecialChars($user->response->user->name), 
		
		echo '<pre>', HtmlSpecialChars(print_r($user, 1)), '</pre>';
			
?>

</body>
</html>
<?php
	}
	else
	{
	    session_unset($_SESSION['OAUTH_ACCESS_TOKEN'][$access_token_url]);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>OAuth client error</title>
</head>
<body>
<h1>OAuth client error</h1>
<pre>Error: <?php echo HtmlSpecialChars($client->error); ?></pre>
</body>
</html>
<?php
	}

?>
