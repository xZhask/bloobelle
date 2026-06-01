<?php
namespace App\Core;

class Logger {
    private static string $logDir = __DIR__ . '/../../app/logs';
    private static string $logFile = 'error.log';

    public static function error(string $message, array $context = []): void {
        self::log('ERROR', $message, $context);
    }

    public static function info(string $message, array $context = []): void {
        self::log('INFO', $message, $context);
    }

    public static function warning(string $message, array $context = []): void {
        self::log('WARNING', $message, $context);
    }

    private static function log(string $level, string $message, array $context = []): void {
        if (!is_dir(self::$logDir)) {
            @mkdir(self::$logDir, 0777, true);
        }

        $date = date('Y-m-d H:i:s');
        $contextString = !empty($context) ? ' ' . json_encode($context, JSON_UNESCAPED_UNICODE) : '';
        
        $logEntry = sprintf("[%s] %s: %s%s" . PHP_EOL, $date, $level, $message, $contextString);
        
        $filePath = self::$logDir . '/' . self::$logFile;
        @file_put_contents($filePath, $logEntry, FILE_APPEND);
    }
}
