<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	define('FACEBOOK_SDK_V4_SRC_DIR', 'api/facebook/src/Facebook/');
	define('APP_ID', '');
	define('APP_SECRET', '');
	define('APP_TOKEN', '');
	require 'api/facebook/autoload.php';

	use Facebook\FacebookSession;
	use Facebook\FacebookJavaScriptLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\GraphUser;

	FacebookSession::setDefaultApplication(APP_ID, APP_SECRET);
	$helper = new FacebookJavaScriptLoginHelper();
	
	try {

		$session = new FacebookSession(APP_TOKEN);


		if (!$session) exit('Usuário não logado ou token expirado.');



} catch(Exception $ex) {
	var_dump($ex);
}

try {
	$response = (new FacebookRequest($session, 'GET', '/me'))->execute();
	$object = $response->getGraphObject();
 
	$fbid = $object->getProperty('id');
	$fbname = $object->getProperty('name');
	$fbgender = $object->getProperty('gender');
 
} catch (FacebookRequestException $ex) {
   echo $ex->getMessage();
} catch (\Exception $ex) {
   echo $ex->getMessage();
}
 
 
/* PEGA OS ALBUNS */
$response = (new FacebookRequest($session, 'GET', '/me/albums'))->execute();
$graphObject = $response->getGraphObject()->asArray();
$albuns = array();
foreach($graphObject['data'] as $v) $albuns[] = $v->id;
 
/* PEGA AS FOTOS */
// $x = 0;
foreach($albuns as $v){
	$response = (new FacebookRequest($session, 'GET', "/$v/photos"))->execute()->getGraphObject()->asArray();
 
	foreach($response['data'] as $fotos){
		echo '<img src="'.$fotos->picture . '" data-source="'.$fotos->source.'"><br>';
		 if (++$x === 50) break;
	}	
}
?>