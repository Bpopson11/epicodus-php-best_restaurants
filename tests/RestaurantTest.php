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



	class RestaurantTest extends PHPUnit_Framework_TestCase
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


			//Act
			$result = Restaurant::getAll();

			//Assert
			$this->assertEquals($new_restaurant, $result[0]);
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

			$restaurant_name2 = "Qdoba Mexican Grill";
			$restaurant_address2 = "321 Real Ave.";
			$restaurant_cuisine_id2 =  $new_cuisine->getId();
			$restaurant_description2 = "A warm place";
			$new_restaurant2 = new Restaurant($restaurant_name2, $restaurant_address2, $restaurant_cuisine_id2, $restaurant_description2);
			$new_restaurant2->save();



			$result = Restaurant::getAll();

			$this->assertEquals([$new_restaurant, $new_restaurant2], $result);

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

					$restaurant_name2 = "Qdoba Mexican Grill";
					$restaurant_address2 = "321 Real Ave.";
					$restaurant_cuisine_id2 =  $new_cuisine->getId();
					$restaurant_description2 = "A warm place";
					$new_restaurant2 = new Restaurant($restaurant_name2, $restaurant_address2, $restaurant_cuisine_id2, $restaurant_description2);
					$new_restaurant2->save();


					Restaurant::deleteAll();

					$result = Restaurant::getAll();

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


			            //Act
			            $result = Restaurant::find($new_restaurant->getId());

			            //Assert
			            $this->assertEquals($new_restaurant, $result);
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

						$restaurant_name2 = "Qdoba Mexican Grill";
						$restaurant_address2 = "321 Real Ave.";
						$restaurant_cuisine_id2 =  $new_cuisine->getId();
						$restaurant_description2 = "A warm place";
						$new_restaurant2 = new Restaurant($restaurant_name2, $restaurant_address2, $restaurant_cuisine_id2, $restaurant_description2);
						$new_restaurant2->save();


						//Act
						$new_restaurant->delete();

						$result = Restaurant::getAll();
						//Assert
						$this->assertEquals([$new_restaurant2], $result);

					}

					function test_update()
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

						$new_name = "Taco Hell";

						//Act
						$new_restaurant->update($new_name);

						//Assert
						$this->assertEquals('Taco Hell', $new_restaurant->getName());
					}

					function test_getReviews()
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
						$result = $new_restaurant->getReviews();
						//Assert
						$this->assertEquals([$new_review], $result);
					}
			}

?>
