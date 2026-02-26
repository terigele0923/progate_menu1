<?php
class Menu {
		protected $id;
		protected $name;
		protected $price;
		protected $image;
		private $orderCount = 0;
		protected static $count = 0;
		
		public function __construct ($name,$price,$image,$id = null){
			$this->name = $name;
			$this->price = $price;
			$this->image = $image;
			$this->id = $id;
			self::$count++;
		}
		
		public function getId(){
			return $this->id;
		}
		public function getName(){
			return $this->name;
		}
		public function getPrice(){
			return $this->price;
		}
		public function getImage(){
			return $this->image;
		}
		public function getTaxIncludedPrice() {
			return floor($this->price * 1.08 );
		}
		public function getOrderCount(){
			return $this->orderCount;
		}
		public function setOrderCount($orderCount){
			$this->orderCount = $orderCount;
		}
		public function getTotalPrice(){
			return $this->getTaxIncludedPrice() * $this->orderCount;
		}
		
		public function getReviews($reviews){
			$reviewsForMenu = array();
			foreach($reviews as $review){
				if($review->getMenuName()==$this->name){
					$reviewsForMenu[]= $review;
				}
			}
			return $reviewsForMenu;
		}
		
		public static function getCount(){
			return self::$count;
		}

		public static function findByName($menus,$name){
				foreach($menus as $menu){
					if($menu->getName() === $name){
						return $menu;
					}
				}
				return null;
		}

		public static function findById(PDO $pdo, $id){
			$stmt = $pdo->prepare('SELECT id, name, price, image, category, type, spiciness FROM menus WHERE id = ?');
			$stmt->execute([(int)$id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!$row) {
				return null;
			}

			if ($row['category'] === 'drink') {
				return new Drink($row['name'], (int)$row['price'], $row['image'], $row['type'], (int)$row['id']);
			}
			return new Food($row['name'], (int)$row['price'], $row['image'], (int)$row['spiciness'], (int)$row['id']);
		}

		public static function fetchAll(PDO $pdo){
			$menus = [];
			$menuNameById = [];

			$sqlMenus = 'SELECT id, name, price, image, category, type, spiciness FROM menus ORDER BY id';
			foreach ($pdo->query($sqlMenus) as $row) {
				if ($row['category'] === 'drink') {
					$menu = new Drink($row['name'], (int)$row['price'], $row['image'], $row['type'], (int)$row['id']);
				} else {
					$menu = new Food($row['name'], (int)$row['price'], $row['image'], (int)$row['spiciness'], (int)$row['id']);
				}
				$menus[] = $menu;
				$menuNameById[(int)$row['id']] = $menu->getName();
			}

			return [$menus, $menuNameById];
		}

		public static function create(PDO $pdo, $name, $price, $image, $category, $type, $spiciness){
			$stmt = $pdo->prepare('INSERT INTO menus (name, price, image, category, type, spiciness) VALUES (?, ?, ?, ?, ?, ?)');
			$stmt->execute([$name, $price, $image, $category, $type, $spiciness]);
			return (int)$pdo->lastInsertId();
		}

		public static function updateById(PDO $pdo, $id, $name, $price, $image, $category, $type, $spiciness){
			$stmt = $pdo->prepare('UPDATE menus SET name = ?, price = ?, image = ?, category = ?, type = ?, spiciness = ? WHERE id = ?');
			$stmt->execute([$name, $price, $image, $category, $type, $spiciness, (int)$id]);
		}

		public static function deleteByIds(PDO $pdo, $ids){
			if (!is_array($ids)) {
				return;
			}
			$filtered = array_values(array_filter(array_map('intval', $ids), function($v){
				return $v > 0;
			}));
			if (count($filtered) === 0) {
				return;
			}
			$placeholders = implode(',', array_fill(0, count($filtered), '?'));
			$stmt = $pdo->prepare("DELETE FROM menus WHERE id IN ($placeholders)");
			$stmt->execute($filtered);
		}
	}
?>
