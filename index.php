<?php

spl_autoload_register(function($class)
{
    $accessClass = [
    	'User' => 'MODULE/USER/MODEL/'.$class.'.class.php',
    	'UserManager' => 'MODULE/USER/MODEL/'.$class.'.class.php', 
    	'Message' => 'MODULE/MESSAGE/MODEL/'.$class.'.class.php',
    	'MessageManager' => 'MODULE/MESSAGE/MODEL/'.$class.'.class.php', 
    ];
    require($accessClass[$class]);
});

session_start();

var_dump($_POST);
// var_dump($_GET);
var_dump($_SESSION);

$page = 'home';

require('APPS/listeErrors.php');
require('config.php');

$bdd = @mysqli_connect($config['host'], $config['login'], $config['password'], $config['bdd']);
if (!$bdd) {
	require('VIEWS/errors500.phtml');
	// $_GET['page'] = 'errors';
}

$access = ['home'];
$accessConnecter = ['message', 'profil'];
if (isset($_GET['page']))
{
	if (in_array($_GET['page'], $access)) 
	{
		$page = $_GET['page'];
	} 
	elseif (isset($_SESSION['id'])) 
	{
		if (in_array($_GET['page'], $accessConnecter)) 
		{
		$page = $_GET['page'];
		}
	}
	else
	{
		header('Location: home');
		exit;
	}
}

$traitement_action = array(
	'register' => 'User',
	'login' => 'User',
	'logout' => 'User',
	'information' => 'User',
	'create_message' => 'Message',
);

if (isset($_POST['action'])) 
{
	$action = $_POST['action'];
	if (isset($traitement_action[$action])) 
	{
		$value = $traitement_action[$action];
		require('APPS/traitement'.$value.'.php');
	}
}
require('APPS/skel.php');
?>