<?php require_once __DIR__ . '/menu.php' ;
	class Food extends Menu {
		private $spiciness;
		public function __construct($name, $price, $image, $spiciness, $id = null){
			parent::__construct($name,$price,$image,$id);
			$this->spiciness = $spiciness;
		}
		public function getSpiciness(){
			return $this->spiciness;
		}
		public function setSpiciness($spiciness){
			$this->spiciness = $spiciness;
		}
	}
?>
