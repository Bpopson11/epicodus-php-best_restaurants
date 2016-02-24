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



	class RestaurantTest extends PHPUnit_Framework_TestCase
	{
		protected function tearDown()
		{
			Cuisine::deleteAll();
			Restaurant::deleteAll();
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
			}

?>
