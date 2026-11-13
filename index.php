<?php
/**
 * صفحه‌ی لاگین — فقط رابط کاربری (UI).
 * این فایل هیچ منطقی برای پردازش، اعتبارسنجی یا ذخیره‌سازی اطلاعات ندارد.
 * فرم زیر به صورت نمادین (placeholder) است و هیچ درخواستی ارسال نمی‌کند.
 */
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
        <img src="assets/logo.svg" alt="Instagram" class="logo" width="175">

        <form onsubmit="return false;">
          <div class="input-group">
            <input type="text" name="username" placeholder="Phone number, username, or email" autocomplete="off">
          </div>
          <div class="input-group">
            <input type="password" name="password" placeholder="Password" autocomplete="off">
          </div>

          <button type="submit" class="btn-login">Log in</button>
        </form>

        <div class="divider">OR</div>

        <a href="#" class="fb-login">
          <svg viewBox="0 0 24 24" fill="#385185"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.5h-1.3c-1.2 0-1.6.8-1.6 1.6V12h2.8l-.4 2.9h-2.4v7A10 10 0 0 0 22 12z"/></svg>
          Log in with Facebook
        </a>

        <a href="#" class="forgot">Forgot password?</a>
      </div>

      <div class="signup-card">
        Don't have an account? <a href="#">Sign up</a>
      </div>

      <div class="get-app">
        <p>Get the app.</p>
        <div class="store-badges">
          <img src="https://static.cdninstagram.com/rsrc.php/v4/yz/r/c5RitZLuQQH.png" alt="App Store">
          <img src="https://static.cdninstagram.com/rsrc.php/v4/yu/r/EHY6QnZYdNX.png" alt="Google Play">
        </div>
      </div>

    </div>
  </div>

  <footer>
    <div class="footer-links">
      <a href="#">Meta</a>
      <a href="#">About</a>
      <a href="#">Blog</a>
      <a href="#">Jobs</a>
      <a href="#">Help</a>
      <a href="#">API</a>
      <a href="#">Privacy</a>
      <a href="#">Terms</a>
      <a href="#">Top Accounts</a>
      <a href="#">Hashtags</a>
      <a href="#">Locations</a>
      <a href="#">Instagram Lite</a>
      <a href="#">Threads</a>
      <a href="#">Contact Uploading &amp; Non-Users</a>
      <a href="#">Meta Verified</a>
    </div>
    <div class="lang-select">
      <select>
        <option>English</option>
      </select>
    </div>
    <div>&copy; <?php echo date('Y'); ?> Instagram UI Clone (Demo)</div>
  </footer>

  <script>
    // فقط فعال/غیرفعال کردن ظاهری دکمه هنگام پر شدن فیلدها (بدون ارسال داده)
    const form = document.querySelector('form');
    const btn = document.querySelector('.btn-login');
    const inputs = document.querySelectorAll('.input-group input');

    function toggleBtn() {
      const filled = Array.from(inputs).every(i => i.value.trim().length > 0);
      btn.classList.toggle('active', filled);
    }

    inputs.forEach(i => i.addEventListener('input', toggleBtn));
  </script>

</body>
</html>
