<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/User.php';

class AuthController {
    public function login() {
        if ($_POST) {
            $database = new Database();
            $db = $database->getConnection();
            $user = new User($db);

            $loggedUser = $user->login($_POST['correo'], $_POST['password']);
            if ($loggedUser) {
                session_start();
                $_SESSION['user_id'] = $loggedUser['id'];
                $_SESSION['nombre'] = $loggedUser['nombre'];
                $_SESSION['rol'] = $loggedUser['rol'];
                header("Location: index.php?action=dashboard");
                exit();
            } else {
                $error = "Credenciales incorrectas";
            }
        }
        include_once 'views/auth/login.php';
    }

    public function logout() {
        session_start();
        session_unset();
        session_destroy();
        header("Location: index.php?action=login");
        exit();
    }
}
?>