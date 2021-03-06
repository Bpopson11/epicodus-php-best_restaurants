<?php
	 class Cuisine
		{
		private $type;
		private $id;

		function __construct($type, $id = NULL)
		{
			$this->type = $type;
			$this->id = $id;
		}


		 function getType()
		 {
				return $this->type;
			}

		function setType($type)
		{
			$this->type = $type;
		}

		 function getId()
		 {
				return $this->id;
			}

			function save()
			{
				$GLOBALS['DB']->query("INSERT INTO cuisines (type) VALUES ('{$this->type}')");
				$this->id = $GLOBALS['DB']->lastInsertId();
			}

			static function getAll()
			{
				$returned_cuisines = $GLOBALS['DB']->query("SELECT * FROM cuisines;");
				$cuisines = array();
				foreach($returned_cuisines as $cuisine)
				{
					$type = $cuisine['type'];
					$id = $cuisine['id'];
					$new_cuisine = new Cuisine($type, $id);
					array_push($cuisines, $new_cuisine);
				}
				return $cuisines;
			}

			static function deleteAll()
			{
				$GLOBALS['DB']->exec("DELETE FROM cuisines;");
			}

			static function find($search_id)
			{
				$found_cuisine = null;
				$cuisines = Cuisine::getAll();
				foreach($cuisines as $cuisine) {
					$cuisine_id = $cuisine->getId();
					if ($cuisine_id == $search_id) {
					  $found_cuisine = $cuisine;
					}
				}
				return $found_cuisine;
			}

			function delete()
			{
				$GLOBALS['DB']->exec("DELETE c, rest, rev FROM cuisines c LEFT OUTER JOIN restaurants rest ON c.id = rest.cuisine_id LEFT OUTER JOIN reviews rev ON rest.id = rev.restaurant_id WHERE c.id = {$this->getId()};");
			}

			function update($new_type)
			{
			    $GLOBALS['DB']->exec("UPDATE cuisines SET type = '{$new_type}' WHERE id = {$this->getId()};");
			    $this->setType($new_type);
			}

			function getRestaurants()
			{
				$restaurants = Array();
				$returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants WHERE cuisine_id = {$this->getId()};");
				foreach($returned_restaurants as $restaurant) {
					$name = $restaurant['name'];
					$address = $restaurant['address'];
					$cuisine_id = $restaurant['cuisine_id'];
					$description = $restaurant['description'];
					$id = $restaurant['id'];
					$new_restaurant = new Restaurant($name, $address, $cuisine_id, $description, $id);
				  	array_push($restaurants, $new_restaurant);
				}
				return $restaurants;
			}
	}
 ?>
