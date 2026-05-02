# How to Run — PHP Airplane Seat Booking

## Requirements
- PHP 7.4+ and MySQL — XAMPP recommended

## Steps
1. Copy folder to `htdocs/`, start Apache + MySQL
2. Open: `http://localhost/19-php-airplane-seat-booking/`

## Features
- Visual seat map (6 rows × 5 cols = 30 seats)
- Rows 1–2: Business class, Rows 3–6: Economy class
- Click a seat → enter passenger name → Book
- Cancel bookings from the booked seats table

## Files
| File | Purpose |
|------|---------|
| `db.php` | DB setup, auto-seeds 30 seats on first run |
| `index.php` | Seat map, booking form, booked list |
