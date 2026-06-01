<?php
namespace App\Core;

use PDO;

class Database {
  public static function connect(): PDO {
    static $pdo = null;

    if ($pdo instanceof PDO) return $pdo;

    $config = require __DIR__ . '/../config/database.php';

    $dsn = sprintf(
      'mysql:host=%s;dbname=%s;charset=%s',
      $config['host'],
      $config['dbname'],
      $config['charset'] ?? 'utf8mb4'
    );

    $timezone = $config['timezone'] ?? '-05:00';

    $pdo = new PDO(
      $dsn,
      $config['user'],
      $config['pass'],
      [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        \Pdo\Mysql::ATTR_INIT_COMMAND => "SET time_zone = '{$timezone}'",
      ]
    );

    return $pdo;
  }
}
