# How to Run — PHP + MySQL Student CRUD

## Requirements
- PHP 7.4 or higher
- MySQL 5.7 or higher
- XAMPP / WAMP / MAMP (includes both PHP and MySQL)

## Steps using XAMPP (Recommended)
1. Install XAMPP from https://www.apachefriends.org
2. Copy the `05-php-mysql-crud` folder into `C:/xampp/htdocs/` (Windows) or `/opt/lampp/htdocs/` (Linux)
3. Start **Apache** and **MySQL** from the XAMPP Control Panel
4. Open browser and go to: `http://localhost/05-php-mysql-crud/`

## Database Setup
- No manual setup needed — the app **automatically creates** the database `student_db` and table `students` on first run.
- If you want to set it up manually, open **phpMyAdmin** at `http://localhost/phpmyadmin` and run:
  ```sql
  CREATE DATABASE student_db;
  USE student_db;
  CREATE TABLE students (
      id    INT AUTO_INCREMENT PRIMARY KEY,
      name  VARCHAR(100) NOT NULL,
      email VARCHAR(100) NOT NULL
  );
  ```

## Changing DB Credentials
Edit `db.php` and update:
```php
define('DB_USER', 'root');   // your MySQL username
define('DB_PASS', '');       // your MySQL password
```

## Files
| File | Purpose |
|------|---------|
| `db.php` | Database connection and table creation |
| `index.php` | Main page — Add, View, Edit, Delete students |
