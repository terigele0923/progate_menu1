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
    }
?>