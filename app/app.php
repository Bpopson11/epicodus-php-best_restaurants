<?php

	require_once __DIR__.'/../vendor/autoload.php';
	require_once __DIR__.'/../src/Cuisine.php';
	require_once __DIR__.'/../src/Restaurant.php';
	require_once __DIR__.'/../src/Review.php';

	use Symfony\Component\Debug\Debug;
	    Debug::enable();

	$server = 'mysql:host=localhost;dbname=best_rests';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);

	$app = new Silex\Application();
	$app['debug'] = true;

	$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

	$app->get("/", function() use ($app)
	{
		return $app['twig']->render('home.html.twig', array('cuisines' => Cuisine::getAll()));
	});

    $app->post("/cuisines", function() use ($app)
	{
		$cuisine = new Cuisine($_POST['type']);
		$cuisine->save();
		return $app['twig']->render('home.html.twig', array('cuisines' => Cuisine::getAll()));
	});

	$app->get("/cuisine/{id}", function($id) use ($app)
	{
		$cuisine = Cuisine::find($id);
		return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
	});



	$app->post("/restaurants", function() use ($app)
	{
		$restaurant = new Restaurant($_POST['name'], $_POST['address'], $_POST['cuisine_id'], $_POST['description']);
		$restaurant->save();
		$cuisine = Cuisine::find($_POST['cuisine_id']);
		return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));

	});


	$app->get("/restaurant/{id}", function($id) use ($app)
	{
		$restaurant = Restaurant::find($id);
		return $app['twig']->render('restaurant.html.twig', array('restaurant' => $restaurant, 'reviews' => $restaurant->getReviews()));
	});

	$app->post("/reviews", function() use ($app)
	{
		$review = new Review($_POST['name'], $_POST['rating'], $_POST['comments'], $_POST['restaurant_id']);
		$review->save();
		$restaurant = Restaurant::find($_POST['restaurant_id']);
		return $app['twig']->render('restaurant.html.twig', array('restaurant' => $restaurant, 'reviews' => $restaurant->getReviews()));

	});



	return $app;

?>
