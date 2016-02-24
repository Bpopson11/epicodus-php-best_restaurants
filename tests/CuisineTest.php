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


	class CuisineTest extends PHPUnit_Framework_TestCase
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

			//Act
			$result = Cuisine::getAll();

			//Assert
			$this->assertEquals($new_cuisine, $result[0]);
		}


		function test_getAll()
		{
			//Arrange
			$cuisine_name = "Mexican";
			$new_cuisine = new Cuisine($cuisine_name);
			$new_cuisine->save();

			$cuisine_name2 = "Korean";
			$new_cuisine2 = new Cuisine($cuisine_name2);
			$new_cuisine2->save();


			$result = Cuisine::getAll();

			$this->assertEquals([$new_cuisine, $new_cuisine2], $result);

		}

				function test_deleteAll()
				{
					$cuisine_name = "Mexican";
					$new_cuisine = new Cuisine($cuisine_name);
					$new_cuisine->save();

					$cuisine_name2 = "Korean";
					$new_cuisine2 = new Cuisine($cuisine_name2);
					$new_cuisine2->save();

					Cuisine::deleteAll();
					$result = Cuisine::getAll();

					$this->assertEquals([], $result);
				}

				function test_find()
					{
						//Arrange
						$cuisine_name = "Mexican";
						$new_cuisine = new Cuisine($cuisine_name);
						$new_cuisine->save();

						//Act
						$result = Cuisine::find($new_cuisine->getId());

						//Assert
						$this->assertEquals($new_cuisine, $result);
					}

					function test_delete()
					{
						//Arrange
						$cuisine_name = "Mexican";
						$new_cuisine = new Cuisine($cuisine_name);
						$new_cuisine->save();

						$cuisine_name2 = "Korean";
						$new_cuisine2 = new Cuisine($cuisine_name2);
						$new_cuisine2->save();

						//Act
						$new_cuisine->delete();

						$result = Cuisine::getAll();
						//Assert
						$this->assertEquals([$new_cuisine2], $result);

					}

					function test_update()
					{
						//Arrange
						$cuisine_name = "Mexican";
						$new_cuisine = new Cuisine($cuisine_name);
						$new_cuisine->save();
						$new_type = "Latin";

						//Act
						$new_cuisine->update($new_type);

						$result = Cuisine::getAll();
						//Assert
						$this->assertEquals('Latin', $new_cuisine->getType());
					}

					function test_getRestaurants()
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
						$result = $new_cuisine->getRestaurants();
						//Assert
						$this->assertEquals([$new_restaurant], $result);

					}
			}

?>
