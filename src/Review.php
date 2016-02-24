<?php
	 class Review
		{
		private $name;
		private $rating;
		private $comments;
		private $restaurant_id;
		private $id;


		function __construct($name, $rating, $comments, $restaurant_id, $id = NULL)
		{
			$this->name = $name;
			$this->rating = $rating;
			$this->comments = $comments;
			$this->restaurant_id = $restaurant_id;
			$this->id = $id;
		}

		 function getName(){
			return $this->name;
			}

		function setName($name){
			$this->name = $name;
		}
		 function getRating(){
			return $this->rating;
			}

		function setRating($rating){
			$this->rating = $rating;
		}
		 function getComments(){
			return $this->comments;
			}

		function setComments($comments){
			$this->comments = $comments;
		}
		function getRestaurantId(){
		   return $this->restaurant_id;
		   }

	   function setRestaurantId($restaurant_id){
		   $this->restaurant_id = $restaurant_id;
	   }

		 function getId(){
			return $this->id;
			}

			function save()
			{
				$GLOBALS['DB']->query("INSERT INTO reviews (name, rating, comments, restaurant_id) VALUES ('{$this->name}', {$this->rating}, '{$this->comments}', {$this->restaurant_id})");
				$this->id = $GLOBALS['DB']->lastInsertId();
			}

			static function getAll()
			{
				$returned_reviews = $GLOBALS['DB']->query("SELECT * FROM reviews;");
				$reviews = array();
				foreach($returned_reviews as $review)
				{
					$name = $review['name'];
					$rating = $review['rating'];
					$comments = $review['comments'];
					$restaurant_id = $review['restaurant_id'];
					$id = $review['id'];
					$new_review = new Review($name, $address, $comments, $restaurant_id, $id);
					array_push($reviews, $new_review);
				}
				return $reviews;
			}

			static function deleteAll()
			{
				$GLOBALS['DB']->exec("DELETE FROM reviews;");
			}
	}
 ?>
