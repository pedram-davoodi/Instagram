# Instagram Login Clone (PHP + MySQL)

کلون آموزشی صفحه‌ی لاگین اینستاگرام با بک‌اند **PHP خام + MySQL**.

> ⚠️ این پروژه یک سیستم لاگین/ثبت‌نام *برای خودِ این اپ* است. هیچ اطلاعاتی از کاربران واقعی اینستاگرام جمع‌آوری نمی‌کند و کاربر را به صفحه‌ی اصلی اینستاگرام ریدایرکت نمی‌کند.

## امکانات
- ثبت‌نام کاربر (`register.php`) با هش کردن پسورد (`password_hash` / bcrypt)
- ورود کاربر (`login.php`) با بررسی پسورد از طریق `password_verify`
- مدیریت session (با `session_regenerate_id` برای جلوگیری از session fixation)
- ثبت لاگ تلاش‌های ورود (موفق/ناموفق) در جدول `login_attempts` — بدون ذخیره‌ی پسورد
- صفحه‌ی داشبورد محافظت‌شده (`dashboard.php`) و خروج (`logout.php`)

## راه‌اندازی

### 1. دیتابیس
```bash
mysql -u root -p < database/schema.sql
```

### 2. متغیرهای محیطی
فایل `.env.example` را کپی کرده و مقادیر را تنظیم کنید (یا به صورت env واقعی export کنید):
```bash
cp .env.example .env
```
> توجه: PHP خام به‌طور پیش‌فرض فایل `.env` را نمی‌خوانَد؛ مقادیر را از طریق env سرور (مثلاً در `php.ini` یا با `export`) ست کنید، یا `config/db.php` را برای خواندن از `.env` گسترش دهید.

مقادیر پیش‌فرض در `config/db.php`:
- `DB_HOST=127.0.0.1`
- `DB_PORT=3306`
- `DB_NAME=instagram_clone`
- `DB_USER=root`
- `DB_PASS=` (خالی)

### 3. اجرا
```bash
php -S localhost:8000
```
سپس به `http://localhost:8000` بروید.

## ساختار پروژه
```
.
├── config/db.php         # اتصال PDO به MySQL
├── database/schema.sql   # اسکیمای جداول users و login_attempts
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
- کوئری‌ها با Prepared Statements (PDO) اجرا می‌شوند → مقاوم در برابر SQL Injection.
- خروجی‌های کاربر با `htmlspecialchars` escape می‌شوند → مقاوم در برابر XSS.
- Session ID بعد از لاگین موفق regenerate می‌شود.
