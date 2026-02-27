<?php

class AuthController
{
    public function login()
    {
        $errors = [];
        $userId = '';

        require __DIR__ . '/../Views/auth/login.php';
    }

    public function loginPost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=login');
            exit;
        }

        require_once __DIR__ . '/../../config/data.php';

        $errors = [];
        $userId = trim($_POST['user_id'] ?? '');
        $password = (string)($_POST['password'] ?? '');

        if ($userId === '' || $password === '') {
            $errors[] = 'User ID and password are required.';
        } else {
            $user = User::findByUserId($pdo, $userId);
            if ($user === null || !$user->verifyPassword($password)) {
                $errors[] = 'Invalid user ID or password.';
            }
        }

        if (count($errors) > 0) {
            require __DIR__ . '/../Views/auth/login.php';
            return;
        }

        $this->startSession();
        $_SESSION['user_id'] = $user->getId();
        $_SESSION['user_name'] = $user->getUserName();

        header('Location: index.php');
        exit;
    }

    public function account()
    {
        $errors = [];
        $userId = '';
        $userName = '';

        require __DIR__ . '/../Views/auth/account.php';
    }

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=register');
            exit;
        }

        require_once __DIR__ . '/../../config/data.php';

        $errors = [];
        $userId = trim($_POST['user_id'] ?? '');
        $userName = trim($_POST['user_name'] ?? '');
        $userGender = $_POST['gender'] ?? '';
        $password = (string)($_POST['password'] ?? ''); 
        if ($userId === '' || $userName === '' || $password === '' || $userGender === '') {
            $errors[] = 'All fields are required.';
        } else {
            if (User::findByUserId($pdo, $userId) !== null) {
                $errors[] = 'User ID is already taken.';
            }
        }

        if (count($errors) > 0) {
            require __DIR__ . '/../Views/auth/account.php';
            return;
        }

        User::create($pdo, $userId, $userName, $password, $userGender);

        header('Location: index.php?page=login');
        exit;
    }
    public function logout()
    {
        $this->startSession();

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();

        header('Location: index.php?page=login');
        exit;
    }

    private function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }
}
