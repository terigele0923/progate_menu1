<?php
class User {
		private $id;
		private $user_id;
		private $user_name;
		private $password_hash;
		private $gender;

		public function __construct($userId, $userName, $userGender = null, $passwordHash = null, $id = null){
			$this->user_id = $userId;
			$this->user_name = $userName;
			$this->gender = $userGender;
			$this->password_hash = $passwordHash;
			$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}
		public function getUserId(){
			return $this->user_id;
		}
		public function getUserName(){
			return $this->user_name;
		}
		public function getName(){
			return $this->user_name;
		}
		public function getGender(){
			return $this->gender;
		}

		public function verifyPassword($plainPassword){
			if ($this->password_hash === null || $this->password_hash === '') {
				return false;
			}
			return password_verify($plainPassword, $this->password_hash);
		}

		public static function findById(PDO $pdo, $id){
			$stmt = $pdo->prepare('SELECT id, user_id, user_name, gender FROM users WHERE id = ?');
			$stmt->execute([(int)$id]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!$row) {
				return null;
			}
			return new User($row['user_id'], $row['user_name'], $row['gender'], null, (int)$row['id']);
		}

		public static function findByUserId(PDO $pdo, $userId){
			$stmt = $pdo->prepare('SELECT id, user_id, user_name, password_hash, gender FROM users WHERE user_id = ?');
			$stmt->execute([$userId]);
			$row = $stmt->fetch(PDO::FETCH_ASSOC);
			if (!$row) {
				return null;
			}
			return new User($row['user_id'], $row['user_name'], $row['gender'], $row['password_hash'], (int)$row['id']);
		}

		public static function create(PDO $pdo, $userId, $userName, $plainPassword, $userGender){
			$hash = password_hash($plainPassword, PASSWORD_DEFAULT);
			$stmt = $pdo->prepare('INSERT INTO users (user_id, user_name, password_hash, gender) VALUES (?, ?, ?, ?)');
			$stmt->execute([$userId, $userName, $hash, $userGender]);
			return new User($userId, $userName, $userGender, $hash, (int)$pdo->lastInsertId());
		}

		public static function fetchAll(PDO $pdo){
			$users = [];
			$userByDbId = [];

			$sqlUsers = 'SELECT id, user_id, user_name, gender FROM users ORDER BY id';
			foreach ($pdo->query($sqlUsers) as $row) {
				$user = new User($row['user_id'], $row['user_name'], $row['gender'], null, (int)$row['id']);
				$users[] = $user;
				$userByDbId[(int)$row['id']] = $user;
			}

			return [$users, $userByDbId];
		}
	}
?>
