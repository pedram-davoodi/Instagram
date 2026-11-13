# Instagram Login Clone (PHP + JSON)

کلون آموزشی صفحه‌ی لاگین اینستاگرام با بک‌اند **PHP خام + فایل JSON (بدون دیتابیس)**.

> ⚠️ این پروژه یک سیستم لاگین/ثبت‌نام *برای خودِ این اپ* است. هیچ اطلاعاتی از کاربران واقعی اینستاگرام جمع‌آوری نمی‌کند و کاربر را به صفحه‌ی اصلی اینستاگرام ریدایرکت نمی‌کند.

## امکانات
- ثبت‌نام کاربر (`register.php`) با هش کردن پسورد (`password_hash` / bcrypt)
- ورود کاربر (`login.php`) با بررسی پسورد از طریق `password_verify`
- مدیریت session (با `session_regenerate_id` برای جلوگیری از session fixation)
- صفحه‌ی داشبورد محافظت‌شده (`dashboard.php`) و خروج (`logout.php`)

## راه‌اندازی
نیازی به دیتابیس نیست. کاربران در `data/users.json` ذخیره می‌شوند (به‌صورت خودکار ساخته می‌شود؛ پوشه‌ی `data/` باید برای PHP قابل نوشتن باشد).

### اجرا
```bash
php -S localhost:8000
```
سپس به `http://localhost:8000` بروید.

## ساختار پروژه
```
.
├── data/users.json       # ذخیره‌ی کاربران (ساخته می‌شود، در git نیست)
├── includes/storage.php  # خواندن/نوشتن کاربران در JSON
├── includes/auth.php     # توابع احراز هویت/session
├── assets/               # CSS و لوگو
├── index.php             # ریدایرکت به login یا dashboard
├── login.php             # فرم و پردازش ورود
├── register.php          # فرم و پردازش ثبت‌نام
├── dashboard.php          # صفحه‌ی محافظت‌شده بعد از ورود
└── logout.php            # خروج از حساب
```

## نکات امنیتی رعایت‌شده
- پسورد هرگز به صورت متن ساده ذخیره نمی‌شود (فقط `password_hash`).
- نوشتن در فایل JSON با `flock` انجام می‌شود تا ثبت‌نام همزمان فایل را خراب نکند.
- `data/` با `.htaccess` (Apache) مسدود است؛ با nginx/`php -S` آن را خارج از webroot قرار دهید یا دسترسی را ببندید.
- خروجی‌های کاربر با `htmlspecialchars` escape می‌شوند → مقاوم در برابر XSS.
- Session ID بعد از لاگین موفق regenerate می‌شود.
