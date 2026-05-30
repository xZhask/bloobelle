<?php
require __DIR__ . '/app/core/Database.php';

try {
    $pdo = \App\Core\Database::connect();
    $sql = file_get_contents(__DIR__ . '/tienda_migrations.sql');
    $pdo->exec($sql);
    echo "SQL ejecutado correctamente.\n";
} catch (\PDOException $e) {
    echo "Error ejecutando SQL: " . $e->getMessage() . "\n";
}
