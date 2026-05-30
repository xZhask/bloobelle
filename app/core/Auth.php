<?php
namespace App\Core;

class Auth {
    public static function login(array $user): void {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_nombre'] = $user['nombre'];
        $_SESSION['user_rol'] = $user['rol'];
        $_SESSION['user_sucursal_id'] = $user['sucursal_id'];
    }

    public static function user(): ?array {
        if (self::check()) {
            return [
                'id' => $_SESSION['user_id'],
                'nombre' => $_SESSION['user_nombre'],
                'rol' => $_SESSION['user_rol'],
                'sucursal_id' => $_SESSION['user_sucursal_id'],
            ];
        }
        return null;
    }

    public static function check(): bool {
        return isset($_SESSION['user_id']);
    }

    public static function requireLogin(): void {
        if (!self::check()) {
            $isApi = isset($_SERVER['REQUEST_URI']) && strncmp($_SERVER['REQUEST_URI'], '/api/', 5) === 0;
            if ($isApi) {
                Response::json(['error' => 'No autenticado'], 401);
                exit;
            }
            header('Location: /login');
            exit;
        }
    }

    public static function requireRole(string ...$roles): void {
        self::requireLogin();
        if (!in_array($_SESSION['user_rol'], $roles)) {
            $isApi = isset($_SERVER['REQUEST_URI']) && strncmp($_SERVER['REQUEST_URI'], '/api/', 5) === 0;
            if ($isApi) {
                Response::json(['error' => 'No autorizado'], 403);
                exit;
            }
            // For views, could redirect or show error
            echo "Acceso denegado. Se requiere rol: " . implode(', ', $roles);
            exit;
        }
    }

    public static function logout(): void {
        session_unset();
        session_destroy();
    }
}
