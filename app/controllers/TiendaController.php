<?php
namespace App\Controllers;

use App\Core\Auth;

class TiendaController {
    public function dashboard(): void {
        Auth::requireLogin();
        $user = Auth::user();
        if ($user['rol'] === 'admin' && !isset($_GET['pos'])) {
            header('Location: /tienda/reporte');
            exit;
        }
        require APP_ROOT . '/app/views/tienda/dashboard.php';
    }
}
