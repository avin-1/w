# How to Run — PHP Waste Collection System

## Requirements
- PHP 7.4+ and MySQL — XAMPP recommended

## Steps
1. Copy folder to `htdocs/`, start Apache + MySQL
2. Open: `http://localhost/17-php-waste-collection/`

## Usage
- **Public** → `index.php` — report waste with type and location
- **Authority** → `authority.php` — assign and mark reports as collected

## Files
| File | Purpose |
|------|---------|
| `db.php` | DB connection, auto-creates `waste_db` and table |
| `index.php` | Public waste reporting form + report list |
| `authority.php` | Authority panel to manage report statuses |
