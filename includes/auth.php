<?php
require_once __DIR__ . '/../config/db.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function require_login(): void
{
    if (!current_user()) {
        header('Location: /login.php');
        exit;
    }
}

function log_login_attempt(?int $userId, string $usernameTried, bool $success): void
{
    $pdo = get_pdo();
    $stmt = $pdo->prepare(
        'INSERT INTO login_attempts (user_id, username_tried, success, ip_address)
         VALUES (:user_id, :username_tried, :success, :ip_address)'
    );
    $stmt->execute([
        'user_id'        => $userId,
        'username_tried' => $usernameTried,
        'success'        => $success ? 1 : 0,
        'ip_address'     => $_SERVER['REMOTE_ADDR'] ?? null,
    ]);
}
