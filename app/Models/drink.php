<?php require_once __DIR__ . '/menu.php';
	class Drink extends Menu {
		private $type;
		
		public function __construct ($name, $price, $image, $type, $id = null){
			parent::__construct($name,$price,$image,$id);
			$this->type = $type;
		}
		
		public function getType(){
			return $this->type;
		}
		public function setType($type){
			$this->type = $type;
		}
	}
 ?>
