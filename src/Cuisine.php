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

		function setType()
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
	}
 ?>
