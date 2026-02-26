<?php
    class User {
    	private $id;
        private $name;
        private $gender;
        private static $count=0;

        public function __construct($name,$gender){
            $this->name = $name;
            $this->gender = $gender;
            self::$count ++;
            $this->id = self::$count;
        }
		public function getId(){
			return $this->id;
		}
		
        public function getName(){
            return $this->name;
        }
        public function getGender(){
            return $this->gender;
        }

        public static function fetchAll(PDO $pdo){
            $users = [];
            $userByDbId = [];

            $sqlUsers = 'SELECT id, name, gender FROM users ORDER BY id';
            foreach ($pdo->query($sqlUsers) as $row) {
                $user = new User($row['name'], $row['gender']);
                $users[] = $user;
                $userByDbId[(int)$row['id']] = $user;
            }

            return [$users, $userByDbId];
        }
    }
?>
