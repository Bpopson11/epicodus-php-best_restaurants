<?php

	require_once __DIR__.'/../vendor/autoload.php';
	require_once __DIR__.'/../src/Cuisine.php';
	require_once __DIR__.'/../src/Restaurant.php';
	require_once __DIR__.'/../src/Review.php';


	$server = 'mysql:host=localhost;dbname=best_rests';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);

	$app = new Silex\Application();

	$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

	$app->get("/", function() use ($app)
	{
		return $app['twig']->render('home.html.twig', array('cuisines' => Cuisine::getAll()));
	});

    $app->post("/cuisines", function() use ($app)
	{
		$cuisine = new Cuisine($_POST['name']);
		$cuisine->save();
		return $app['twig']->render('index.html.twig', array('cuisines' => Cuisine::getAll()));
	});

	$app->get("/cuisine/{id}", function($id) use ($app)
	{
		$cuisine = Cuisine::find($id);
		return $app['twig']->render('category.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
	});

	return $app;

?>
