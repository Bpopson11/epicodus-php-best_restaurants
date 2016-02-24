<?php

	/**
	* @backupGlobals disabled
	* @backupStaticAttributes disabled
	*/

	$server = 'mysql:host=localhost;dbname=best_rests_test';
	$username = 'root';
	$password = 'root';
	$DB = new PDO($server, $username, $password);

	require_once 'src/Cuisine.php';
	require_once 'src/Restaurant.php';
	require_once 'src/Review.php';

	class ReviewTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Cuisine::deleteAll();
			Restaurant::deleteAll();
			Review::deleteAll();
		}

		function test_save()
		{
			//Arrange
			$cuisine_name = "Mexican";
			$new_cuisine = new Cuisine($cuisine_name);
			$new_cuisine->save();

			$restaurant_name = "Taco Bell";
			$restaurant_address = "123 Test Street";
			$restaurant_cuisine_id =  $new_cuisine->getId();
			$restaurant_description = "A lovely place";
			$new_restaurant = new Restaurant($restaurant_name, $restaurant_address, $restaurant_cuisine_id, $restaurant_description);
			$new_restaurant->save();

			$review_name = "Jason Awbrey";
			$review_rating = 4;
			$review_comments = "This place is amazing!";
			$review_restId = $new_restaurant->getId();
			$new_review = new Review($review_name, $review_rating, $review_comments, $review_restId);
			$new_review->save();

			//Act
			$result = Review::getAll();

			//Assert
			$this->assertEquals($new_review, $result[0]);
		}


		function test_getAll()
		{
			//Arrange
			$cuisine_name = "Mexican";
			$new_cuisine = new Cuisine($cuisine_name);
			$new_cuisine->save();

			$restaurant_name = "Taco Bell";
			$restaurant_address = "123 Test Street";
			$restaurant_cuisine_id =  $new_cuisine->getId();
			$restaurant_description = "A lovely place";
			$new_restaurant = new Restaurant($restaurant_name, $restaurant_address, $restaurant_cuisine_id, $restaurant_description);
			$new_restaurant->save();

			$review_name = "Jason Awbrey";
			$review_rating = 4;
			$review_comments = "This place is amazing!";
			$review_restId = $new_restaurant->getId();
			$new_review = new Review($review_name, $review_rating, $review_comments, $review_restId);
			$new_review->save();

			$review_name2 = "Joe Karasek";
			$review_rating2 = 0;
			$review_comments2 = "This place is horrible!";
			$review_restId2 = $new_restaurant->getId();
			$new_review2 = new Review($review_name2, $review_rating2, $review_comments2, $review_restId2);
			$new_review2->save();


			$result = Review::getAll();

			$this->assertEquals([$new_review, $new_review2], $result);

		}

				function test_deleteAll()
				{
					$cuisine_name = "Mexican";
					$new_cuisine = new Cuisine($cuisine_name);
					$new_cuisine->save();

					$restaurant_name = "Taco Bell";
					$restaurant_address = "123 Test Street";
					$restaurant_cuisine_id =  $new_cuisine->getId();
					$restaurant_description = "A lovely place";
					$new_restaurant = new Restaurant($restaurant_name, $restaurant_address, $restaurant_cuisine_id, $restaurant_description);
					$new_restaurant->save();

					$review_name = "Jason Awbrey";
					$review_rating = 4;
					$review_comments = "This place is amazing!";
					$review_restId = $new_restaurant->getId();
					$new_review = new Review($review_name, $review_rating, $review_comments, $review_restId);
					$new_review->save();

					$review_name2 = "Joe Karasek";
					$review_rating2 = 0;
					$review_comments2 = "This place is horrible!";
					$review_restId2 = $new_restaurant->getId();
					$new_review2 = new Review($review_name2, $review_rating2, $review_comments2, $review_restId2);
					$new_review2->save();


					Review::deleteAll();
					$result =  Review::getAll();

					$this->assertEquals([], $result);
				}

				function test_find()
					{
						//Arrange
						$cuisine_name = "Mexican";
						$new_cuisine = new Cuisine($cuisine_name);
						$new_cuisine->save();

						$restaurant_name = "Taco Bell";
						$restaurant_address = "123 Test Street";
						$restaurant_cuisine_id =  $new_cuisine->getId();
						$restaurant_description = "A lovely place";
						$new_restaurant = new Restaurant($restaurant_name, $restaurant_address, $restaurant_cuisine_id, $restaurant_description);
						$new_restaurant->save();

						$review_name = "Jason Awbrey";
						$review_rating = 4;
						$review_comments = "This place is amazing!";
						$review_restId = $new_restaurant->getId();
						$new_review = new Review($review_name, $review_rating, $review_comments, $review_restId);
						$new_review->save();


						//Act
						$result = Review::find($new_review->getId());

						//Assert
						$this->assertEquals($new_review, $result);
					}

					function test_delete()
					{
						//Arrange
						$cuisine_name = "Mexican";
						$new_cuisine = new Cuisine($cuisine_name);
						$new_cuisine->save();

						$restaurant_name = "Taco Bell";
						$restaurant_address = "123 Test Street";
						$restaurant_cuisine_id =  $new_cuisine->getId();
						$restaurant_description = "A lovely place";
						$new_restaurant = new Restaurant($restaurant_name, $restaurant_address, $restaurant_cuisine_id, $restaurant_description);
						$new_restaurant->save();

						$review_name = "Jason Awbrey";
						$review_rating = 4;
						$review_comments = "This place is amazing!";
						$review_restId = $new_restaurant->getId();
						$new_review = new Review($review_name, $review_rating, $review_comments, $review_restId);
						$new_review->save();

						$review_name2 = "Joe Karasek";
						$review_rating2 = 0;
						$review_comments2 = "This place is horrible!";
						$review_restId2 = $new_restaurant->getId();
						$new_review2 = new Review($review_name2, $review_rating2, $review_comments2, $review_restId2);
						$new_review2->save();

						//Act
						$new_review->delete();

						$result = Review::getAll();
						//Assert
						$this->assertEquals([$new_review2], $result);

					}
			}

?>
