# How to Run — PHP Complaint Management System

## Requirements
- PHP 7.4+ and MySQL — XAMPP recommended

## Steps
1. Copy folder to `htdocs/`, start Apache + MySQL
2. Open: `http://localhost/15-php-complaint-system/`

## Usage
- **Students** → `index.php` — register/login → submit complaints at `complaint.php`
- **Admin** → `admin.php` — login with `admin / admin123` → view and resolve all complaints

## Files
| File | Purpose |
|------|---------|
| `db.php` | DB connection, auto-creates tables |
| `index.php` | Student login + registration |
| `complaint.php` | Student complaint submission + history |
| `admin.php` | Admin panel — view all complaints, mark resolved |
