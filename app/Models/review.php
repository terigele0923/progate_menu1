<?php 
    class Review {
        private $menuName;
        private $body;
        private $userId;

        public function __construct($menuName,$userId,$body){
            $this->menuName = $menuName;
            $this->userId = $userId;
            $this->body = $body;
        }

        public function getMenuName(){
            return $this->menuName;
        }
        public function getUser($users){
            foreach($users as $user){
                if($user->getId() === $this->userId){
                    return $user;
                }
            }
        }
        public function getBody(){
            return $this->body;
        }

        public static function fetchAll(PDO $pdo, $menuNameById, $userByDbId){
            $reviews = [];

            $sqlReviews = 'SELECT id, user_id, menu_id, body FROM reviews ORDER BY id';
            foreach ($pdo->query($sqlReviews) as $row) {
                $menuName = $menuNameById[(int)$row['menu_id']] ?? null;
                $user = $userByDbId[(int)$row['user_id']] ?? null;

                if ($menuName === null || $user === null) {
                    continue;
                }

                $reviews[] = new Review($menuName, $user->getId(), $row['body']);
            }

            return $reviews;
        }
    }
?>
