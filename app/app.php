<?php

	require_once __DIR__.'/../vendor/autoload.php';


	$server = 'mysql:host=localhost;dbname=best_rests';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);

	$app = new Silex\Application();

	$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

	$app->get('/', function(){return 'Hello, World!';});

	return $app;

?>
