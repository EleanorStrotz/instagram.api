<?php
//Configuration for our PHP Server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make Constants using define.
define('clientID', '2181409914a14faeb598ef20216bc346');
define('client_Secret', 'd9a01b57658c4a1981efc3e91ae1a148');
define('redirectURI', 'http://localhost/eleanorstrotz/index.php');
define('ImageDirectory', 'pics/');

if (isset($_GET['code'])){
	$code = ($_GET['code']);
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_settings = array('client_id' => clientID,
		                           'client_secret' => clientSecret,
		                           'grant_type' => 'authorization_code',
		                           'redirect_uri' => redirectURI,
		                           'code' => $code
		                           );
}

?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Untitled</title>
	<link rel="stylesheet" href="css/style.css">
	<link rel="author" href="humans.txt">
</head>
<body>
	<!-- Creating a login for people to go and give approval for our web app to access their Instagram Account  
	After getting approval we are now going to have the information to that we can play with.
	-->
	<a href="https:api.instagram/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">
	LOGIN</a>
	<script src="js/main.js"></script>
</body>
</html>

