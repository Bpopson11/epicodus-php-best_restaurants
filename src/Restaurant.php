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

			function delete()
			{
				$GLOBALS['DB']->exec("DELETE rest, rev FROM restaurants rest LEFT OUTER JOIN reviews rev ON rest.id = rev.restaurant_id WHERE rest.id = {$this->getId()};");
			}

			function update($new_name)
			{
			    $GLOBALS['DB']->exec("UPDATE restaurants SET name = '{$new_name}' WHERE id = {$this->getId()};");
			    $this->setName($new_name);
			}

			function getReviews()
			{
				$reviews = Array();
				$returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews WHERE restaurant_id = {$this->getId()};");
				foreach($returned_reviews as $review) {
					$name = $review['name'];
					$rating = $review['rating'];
					$comments = $review['comments'];
					$restaurant_id = $review['restaurant_id'];
					$id = $review['id'];
					$new_review = new Review($name, $rating, $comments, $restaurant_id, $id);
				  	array_push($reviews, $new_review);
				}
				return $reviews;
			}
	}
 ?>
