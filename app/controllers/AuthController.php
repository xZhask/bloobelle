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
        header('Location: /perfumes');
        exit;
    }

    public function cambiarPassword(): void {
        Auth::requireLogin();
        $data = Request::json();
        $actual    = $data['actual'] ?? '';
        $nueva     = $data['nueva'] ?? '';
        $confirmar = $data['confirmar'] ?? '';

        if ($actual === '' || $nueva === '' || $confirmar === '') {
            Response::json(['error' => 'Completa todos los campos'], 400); return;
        }
        if ($nueva !== $confirmar) {
            Response::json(['error' => 'La nueva contraseña no coincide'], 400); return;
        }
        if (strlen($nueva) < 8) {
            Response::json(['error' => 'La nueva contraseña debe tener al menos 8 caracteres'], 400); return;
        }
        if ($nueva === $actual) {
            Response::json(['error' => 'La nueva contraseña debe ser distinta de la actual'], 400); return;
        }

        $id  = Auth::user()['id'];
        $pdo = Database::connect();
        $stmt = $pdo->prepare("SELECT password_hash FROM usuarios WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $hash = $stmt->fetchColumn();

        if (!$hash || !password_verify($actual, $hash)) {
            Response::json(['error' => 'La contraseña actual es incorrecta'], 401); return;
        }

        $upd = $pdo->prepare("UPDATE usuarios SET password_hash = ? WHERE id = ?");
        $upd->execute([password_hash($nueva, PASSWORD_DEFAULT), $id]);

        Response::json(['ok' => true]);
    }
}
