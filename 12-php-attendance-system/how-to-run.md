# How to Run — PHP Attendance System

## Requirements
- PHP 7.4+ and MySQL — XAMPP recommended

## Steps
1. Copy folder to `htdocs/`, start Apache + MySQL in XAMPP
2. Open: `http://localhost/12-php-attendance-system/`

Or with built-in server (needs MySQL running separately):
```bash
cd 12-php-attendance-system
php -S localhost:8000
```

## Usage
- **Students** → open `index.php` to register
- **Teacher** → open `teacher.php` to mark attendance using checkboxes, view reports by date

## Files
| File | Purpose |
|------|---------|
| `db.php` | DB connection + auto-creates tables |
| `index.php` | Student self-registration |
| `teacher.php` | Mark attendance + view reports |
