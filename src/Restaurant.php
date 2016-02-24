<?php
	 class Restaurant
		{
		private $name;
		private $address;
		private $cuisine_id;
		private $description;
		private $id;


		function __construct($name, $address, $cuisine_id, $description, $id = NULL)
		{
			$this->name = $name;
			$this->address = $address;
			$this->cuisine_id = $cuisine_id;
			$this->description = $description;
			$this->id = $id;
		}


		 function getName(){
			return $this->name;
			}

		function setName($name)
		{
			$this->name = $name;
		}

		 function getAddress()
		 {
			return $this->address;
			}

		function setAddress($address)
		{
			$this->address = $address;
		}

		function getCuisineId()
		{
			return $this->cuisine_id;
		}

		function setCusineId($cuisine_id)
		{
			$this->cuisine_id = $cuisine_id;
		}

		function getDescription()
		{
			return $this->description;
		}

		function setDescription($description)
		{
			$this->description = $description;
		}

		 function getId()
		 {
			return $this->id;
		 }

			function save()
			{
				$GLOBALS['DB']->query("INSERT INTO restaurants (name, address, cuisine_id, description) VALUES ('{$this->name}', '{$this->address}', {$this->cuisine_id}, '{$this->description}')");
				$this->id = $GLOBALS['DB']->lastInsertId();
			}

			static function getAll()
			{
				$returned_restaurants = $GLOBALS['DB']->query("SELECT * FROM restaurants;");
				$restaurants = array();
				foreach($returned_restaurants as $restaurant)
				{
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

			static function deleteAll()
			{
				$GLOBALS['DB']->exec("DELETE FROM restaurants;");
			}

			static function find($search_id)
			{
				$found_restaurant = null;
				$restaurants = Restaurant::getAll();
				foreach($restaurants as $restaurant) {
					$restaurant_id = $restaurant->getId();
					if ($restaurant_id == $search_id) {
					  $found_restaurant = $restaurant;
					}
				}
				return $found_restaurant;
			}
	}
 ?>
