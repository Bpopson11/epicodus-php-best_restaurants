<?php

		require_once __DIR__.'/../vendor/autoload.php';
		require_once __DIR__.'/../src/Cuisine.php';
		require_once __DIR__.'/../src/Restaurant.php';
		require_once __DIR__.'/../src/Review.php';

		// use Symfony\Component\Debug\Debug;
		//     Debug::enable();

		$server = 'mysql:host=localhost;dbname=best_rests';
		$username = 'root';
		$password = 'root';
		$DB = new PDO($server, $username, $password);

		$app = new Silex\Application();
		// $app['debug'] = true;

		$app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

		use Symfony\Component\HttpFoundation\Request;
		Request::enableHttpMethodParameterOverride();

		// Home page showing cuisines

		$app->get("/", function() use ($app)
		{
				return $app['twig']->render('home.html.twig', array('cuisines' => Cuisine::getAll(), 'form' => false));
		});


		$app->post("/cuisines", function() use ($app)
		{
				$cuisine = new Cuisine($_POST['type']);
				$cuisine->save();

				return $app['twig']->render('home.html.twig', array('cuisines' => Cuisine::getAll()));
		});


		$app->get("/cuisines/{id}/edit_form", function($id) use ($app)
		{
				$current_cuisine = Cuisine::find($id);
				$cuisines = Cuisine::getAll();

				return $app['twig']->render('home.html.twig', array('current_cuisine' => $current_cuisine, 'cuisines' => $cuisines, 'form' => true));
		});


		$app->patch("/cuisines/updated", function() use ($app)
		{
				$cuisine_to_edit = Cuisine::find($_POST['current_cuisineId']);
				$cuisine_to_edit->update($_POST['type']);

				return $app['twig']->render('home.html.twig', array('cuisines' => Cuisine::getAll()));
		});

		$app->delete("/cuisines/{id}/delete", function($id) use ($app)
		{
				$cuisine = Cuisine::find($id);
				$cuisine->delete();

				return $app['twig']->render('home.html.twig', array('cuisines' => Cuisine::getAll(), 'form' => false));
		});

		// Specific cuisine pages (show restaurants)

		$app->get("/cuisine/{id}", function($id) use ($app)
		{
				$cuisine = Cuisine::find($id);

				return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants(), 'form' => false));
		});

		$app->post("/restaurants", function() use ($app)
		{
				$restaurant = new Restaurant($_POST['name'], $_POST['address'], $_POST['cuisine_id'], $_POST['description']);
				$restaurant->save();
				$cuisine = Cuisine::find($_POST['cuisine_id']);

				return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));

		});

		$app->get("/restaurant/{cid}/{rid}/edit_form", function($cid, $rid) use ($app)
		{
				$current_restaurant = Restaurant::find($rid);
				$cuisine = Cuisine::find($cid);

				return $app['twig']->render('cuisine.html.twig', array('current_restaurant' => $current_restaurant, 'cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants(), 'form' => true));
		});

		$app->patch("/restaurants/updated", function() use ($app)
		{
				$restaurant_to_edit = Restaurant::find($_POST['current_restaurantId']);
				$restaurant_to_edit->update($_POST['name']);
				$cuisine = Cuisine::find($_POST['cuisine_id']);

				return $app['twig']->render('cuisine.html.twig', array('restaurants' => $cuisine->getRestaurants(), 'cuisine' => $cuisine));
		});

		$app->delete("/restaurants/{cuisine_id}/{restaurant_id}/delete", function($cuisine_id, $restaurant_id) use ($app)
		{
				$restaurant = Restaurant::find($restaurant_id);
				$restaurant->delete();
				$cuisine = Cuisine::find($cuisine_id);

				return $app['twig']->render('cuisine.html.twig', array('cuisine' => $cuisine, 'restaurants' => $cuisine->getRestaurants()));
		});


		// Review Pages
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

		$app->get("/review/{restaurant_id}/{review_id}/edit_form", function($restaurant_id, $review_id) use ($app)
		{
				$current_review = Review::find($review_id);
				$restaurant = Restaurant::find($restaurant_id);

				return $app['twig']->render('restaurant.html.twig', array('current_review' => $current_review, 'restaurant' => $restaurant, 'reviews' => $restaurant->getReviews(), 'form' => true));
		});

		$app->patch("/reviews/updated", function() use ($app)
		{
				$review_to_edit = Review::find($_POST['current_reviewId']);
				$review_to_edit->update($_POST['name']);
				$restaurant = Restaurant::find($_POST['restaurant_id']);

				return $app['twig']->render('restaurant.html.twig', array('reviews' => $restaurant->getReviews(), 'restaurant' => $restaurant));
		});

		$app->delete("/reviews/{restaurant_id}/{review_id}", function($restaurant_id, $review_id) use ($app)
		{
				$review = Review::find($review_id);
				$review->delete();
				$restaurant = Restaurant::find($restaurant_id);

				return $app['twig']->render('restaurant.html.twig', array('restaurant' => $restaurant, 'reviews' => $restaurant->getReviews()));
		});

		return $app;

?>
