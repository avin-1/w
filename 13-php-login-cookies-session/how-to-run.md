# How to Run — PHP Login with Cookies & Sessions

## Requirements
- PHP 7.4+ and MySQL — XAMPP recommended

## Steps
1. Copy folder to `htdocs/`, start Apache + MySQL
2. Open: `http://localhost/13-php-login-cookies-session/register.php`

## Files
| File | Purpose |
|------|---------|
| `db.php` | DB connection, auto-creates `login_db` and `users` table |
| `register.php` | User registration with hashed password |
| `login.php` | Login with "Remember Me" cookie support |
| `dashboard.php` | Protected page — shows session + cookie info |
