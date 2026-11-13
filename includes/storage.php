<?php
/**
 * ذخیره‌سازی کاربران در فایل JSON (بدون دیتابیس).
 * فایل: data/users.json — پسورد به صورت متن ساده (plain text) ذخیره می‌شود.
 */

const USERS_FILE = __DIR__ . '/../data/users.json';

function load_users(): array
{
    if (!is_file(USERS_FILE)) {
        return [];
    }
    $data = json_decode((string) file_get_contents(USERS_FILE), true);
    return is_array($data) ? $data : [];
}

function find_user(string $identifier): ?array
{
    $needle = mb_strtolower($identifier);
    foreach (load_users() as $user) {
        if (mb_strtolower($user['username']) === $needle || mb_strtolower($user['email']) === $needle) {
            return $user;
        }
    }
    return null;
}

/**
 * کاربر جدید را اتمیک (با قفل فایل) اضافه می‌کند.
 * اگر نام کاربری/ایمیل تکراری باشد false برمی‌گرداند.
 */
function create_user(string $username, string $email, string $password): bool
{
    if (!is_dir(dirname(USERS_FILE))) {
        mkdir(dirname(USERS_FILE), 0700, true);
    }

    $fp = fopen(USERS_FILE, 'c+');
    if ($fp === false) {
        throw new RuntimeException('Cannot open users file.');
    }
    flock($fp, LOCK_EX);

    $users = json_decode((string) stream_get_contents($fp), true);
    $users = is_array($users) ? $users : [];

    foreach ($users as $u) {
        if (mb_strtolower($u['username']) === mb_strtolower($username)
            || mb_strtolower($u['email']) === mb_strtolower($email)) {
            flock($fp, LOCK_UN);
            fclose($fp);
            return false;
        }
    }

    $users[] = [
        'id'            => count($users) ? max(array_column($users, 'id')) + 1 : 1,
        'username'      => $username,
        'email'         => $email,
        'password'      => $password,
        'created_at'    => date('c'),
    ];

    ftruncate($fp, 0);
    rewind($fp);
    fwrite($fp, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return true;
}
