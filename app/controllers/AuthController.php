<?php
namespace App\Controllers;

use App\Core\Auth;
use App\Core\Request;
use App\Core\Response;
use App\Core\Database;

class AuthController {
    public function showLogin(): void {
        if (Auth::check()) {
            header('Location: /tienda');
            exit;
        }
        require APP_ROOT . '/app/views/auth/login.php';
    }

    public function login(): void {
        $data = Request::json();
        $usuario = $data['usuario'] ?? '';
        $password = $data['password'] ?? '';

        if (empty($usuario) || empty($password)) {
            Response::json(['error' => 'Faltan credenciales'], 400);
            return;
        }

        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE usuario = ? AND activo = 1 LIMIT 1");
        $stmt->execute([$usuario]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password_hash'])) {
            Auth::login($user);
            Response::json([
                'ok' => true,
                'user' => [
                    'nombre' => $user['nombre'],
                    'rol' => $user['rol'],
                    'sucursal_id' => $user['sucursal_id']
                ]
            ]);
        } else {
            Response::json(['error' => 'Usuario o contraseña incorrectos'], 401);
        }
    }

    public function logout(): void {
        Auth::logout();
        header('Location: /login');
        exit;
    }
}
