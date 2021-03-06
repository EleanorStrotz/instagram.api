<!-- Second Page -->
<!-- Html code to link to css -->
<!DOCTYPE html>
<html>
<head>
	<title></title>
	<link rel="stylesheet" href="css/style.css">
	<div id="here">
</head>
<body>
<!-- php code starts -->
<?php
//Configuration for our PHP Server
set_time_limit(0);
ini_set('default_socket_timeout', 300);
session_start();

//Make Constants using define.
define('clientID', '2181409914a14faeb598ef20216bc346');
define('clientSecret', 'd9a01b57658c4a1981efc3e91ae1a148');
define('redirectURI', 'http://localhost/eleanorstrotz/index.php');
define('ImageDirectory', 'pics/');



//Function that is going to connect to Instagram.
function connectToInstagram($url){
	$ch = curl_init();

	curl_setopt_array($ch, array(
		CURLOPT_URL => $url,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_SSL_VERIFYPEER => false,
		CURLOPT_SSL_VERIFYHOST => 2,
		));
		$result = curl_exec($ch);
		curl_close($ch);
		return $result;
}

//Function to get UserID cause userName doesn't allow us to get pictures!
function getUserID($userName){
	$url = 'https://api.instagram.com/v1/users/search?q='.$userName. '&client_id='.clientID;
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);

	return $results['data'][0]['id'];
}

//Function to print images onto screen
function printImages($userID){
	$url = 'https://api.instagram.com/v1/users/'.$userID.'/media/recent?client_id='.clientID.'&count=5';
	$instagramInfo = connectToInstagram($url);
	$results = json_decode($instagramInfo, true);
	//Parse through the information one by one
	foreach ($results['data'] as $items){
		$image_url = $items['images']['low_resolution']['url'];//going to go through all of my results and give myself back the URL of those pictures 
		//because we want to have it in the PHP Server.
		echo '<img align="center" class="here" src="'.$image_url.'"/><br/>';
		//calling a function to save that $image_url
		savePictures($image_url);
	}
}

//Function to save a image to server
function savePictures($image_url){
	echo '<body class="body">';
	return '<div id="image">' .$image_url. '<br></div>'; 
	$filename = basename($image_url);// the filename is what we are storing. basename is the PHP built in method that we are using to store $image_url
	echo $filename . '<br>';

	$destination = ImageDirectory . $filename;//making sure that the image doesnt exist in the storage.
	file_put_contents($destination, file_get_contents($image_url));//goes and grabs an imagefile and stores it into our server
}
if (isset($_GET['code'])){
	$code = $_GET['code'];
	$url = 'https://api.instagram.com/oauth/access_token';
	$access_token_settings = array('client_id' => clientID,
		                           'client_secret' => clientSecret,
		                           'grant_type' => 'authorization_code',
		                           'redirect_uri' => redirectURI,
		                           'code' => $code
		                           );
//cURL is what we use in PHP, its a library calls to other API's.
$curl =  curl_init($url);//Setting a cURL session and we put in $url because that's where we are getting the data from.
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_POSTFIELDS, $access_token_settings);//setting the POSTFIELDS to the array setup that we created.
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // setting it equal to 1 because we are getting strings back
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//but in live work-production we want to set this to true.

$result = curl_exec($curl);
curl_close($curl);

$results = json_decode($result, true);

$userName =  $results['user']['username'];
echo $userName;

$userID = getUserID($userName);

printImages($userID);

echo "<div id= here>";
echo "</div>";


}
else{
?>
<!-- end to html of second page -->
</body>
</html>
<!-- end to second page -->


<!-- opening page -->
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Untitled</title>
	<!-- main.css is the first pages style -->
	<link rel="stylesheet" href="css/main.css">
	<link href='http://fonts.googleapis.com/css?family=Amatic+SC' rel='stylesheet' type='text/css'>
	<link rel="author" href="humans.txt">
</head>
<body>
	<div class="container">
	<div class="LOGIN">
	<!-- Creating a login for people to go and give approval for our web app to access their Instagram Account  
	After getting approval we are now going to have the information to that we can play with.
	-->
	<a href="https://api.instagram.com/oauth/authorize/?client_id=<?php echo clientID; ?>&redirect_uri=<?php echo redirectURI; ?>&response_type=code">
	<div class="LOGIN">
	Please Access Instagram Here!</a>
	</div>
	</div>
</body>
</html>
<?php
}
?>
