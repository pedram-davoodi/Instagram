<?php
require_once __DIR__ . '/includes/auth.php';
require_login();

$user = current_user();
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
  <div class="page">
    <div class="login-box">
      <div class="card" style="text-align:center;">
        <h2>خوش آمدید، <?php echo htmlspecialchars($user['username'], ENT_QUOTES, 'UTF-8'); ?> 👋</h2>
        <p>با موفقیت وارد شدید.</p>
        <a href="logout.php" class="forgot">خروج از حساب</a>
      </div>
    </div>
  </div>
</body>
</html>
