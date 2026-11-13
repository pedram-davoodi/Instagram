<?php
/**
 * اتصال به دیتابیس MySQL با PDO.
 * مقادیر را از طریق متغیرهای محیطی (env) بخوانید؛ در صورت نبود، مقدار پیش‌فرض محلی استفاده می‌شود.
 */

function get_pdo(): PDO
{
    static $pdo = null;

    if ($pdo !== null) {
        return $pdo;
    }

    $host = getenv('DB_HOST') ?: '127.0.0.1';
    $port = getenv('DB_PORT') ?: '3306';
    $db   = getenv('DB_NAME') ?: 'instagram_clone';
    $user = getenv('DB_USER') ?: 'root';
    $pass = getenv('DB_PASS') ?: '';

    $dsn = "mysql:host={$host};port={$port};dbname={$db};charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $pdo = new PDO($dsn, $user, $pass, $options);
    } catch (PDOException $e) {
        http_response_code(500);
        die('Database connection failed: ' . htmlspecialchars($e->getMessage()));
    }

    return $pdo;
}
