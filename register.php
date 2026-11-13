<?php
/**
 * ثبت‌نام کاربر جدید در جدول users خودِ این اپ.
 * پسورد فقط به صورت هش‌شده (bcrypt) ذخیره می‌شود.
 */

require_once __DIR__ . '/includes/auth.php';

$errors = [];
$old = ['username' => '', 'email' => ''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $old['username'] = $username;
    $old['email'] = $email;

    if ($username === '' || $email === '' || $password === '') {
        $errors[] = 'همه فیلدها الزامی هستند.';
    }
    if ($password !== '' && strlen($password) < 6) {
        $errors[] = 'رمز عبور باید حداقل ۶ کاراکتر باشد.';
    }
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = 'ایمیل وارد شده معتبر نیست.';
    }

    if (!$errors) {
        $pdo = get_pdo();

        $stmt = $pdo->prepare('SELECT id FROM users WHERE username = :u OR email = :e LIMIT 1');
        $stmt->execute(['u' => $username, 'e' => $email]);
        if ($stmt->fetch()) {
            $errors[] = 'این نام کاربری یا ایمیل قبلاً ثبت شده است.';
        }
    }

    if (!$errors) {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $stmt = $pdo->prepare(
            'INSERT INTO users (username, email, password_hash) VALUES (:u, :e, :p)'
        );
        $stmt->execute(['u' => $username, 'e' => $email, 'p' => $hash]);

        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sign up - Instagram</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>

  <div class="page" dir="ltr">
    <div class="login-box">

      <div class="card">
        <img src="assets/logo.svg" alt="Instagram" class="logo" width="175">

        <?php foreach ($errors as $err): ?>
          <p style="color:#ed4956; font-size:13px; text-align:center; margin:0 0 10px;">
            <?php echo htmlspecialchars($err, ENT_QUOTES, 'UTF-8'); ?>
          </p>
        <?php endforeach; ?>

        <form method="POST" action="register.php" autocomplete="off">
          <div class="input-group">
            <input type="text" name="username" placeholder="Username"
                   value="<?php echo htmlspecialchars($old['username'], ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>
          <div class="input-group">
            <input type="email" name="email" placeholder="Email"
                   value="<?php echo htmlspecialchars($old['email'], ENT_QUOTES, 'UTF-8'); ?>" required>
          </div>
          <div class="input-group">
            <input type="password" name="password" placeholder="Password" required minlength="6">
          </div>

          <button type="submit" class="btn-login active">Sign up</button>
        </form>
      </div>

      <div class="signup-card">
        Have an account? <a href="login.php">Log in</a>
      </div>

    </div>
  </div>

</body>
</html>
