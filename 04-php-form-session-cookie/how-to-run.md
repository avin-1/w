# How to Run — PHP Form, Session & Cookie

## Requirements
- PHP 7.4 or higher
- A local server: XAMPP / WAMP / MAMP or PHP built-in server

## Option 1: Using XAMPP (Recommended)
1. Install XAMPP from https://www.apachefriends.org
2. Copy the `04-php-form-session-cookie` folder into `C:/xampp/htdocs/` (Windows) or `/opt/lampp/htdocs/` (Linux)
3. Start **Apache** from the XAMPP Control Panel
4. Open browser and go to: `http://localhost/04-php-form-session-cookie/index.html`

## Option 2: PHP Built-in Server
1. Open terminal in this project folder
2. Run:
   ```bash
   php -S localhost:8000
   ```
3. Open browser and go to: `http://localhost:8000/index.html`

## Files
| File | Purpose |
|------|---------|
| `index.html` | Registration form with client-side validation |
| `process.php` | Handles form submission, sets cookie and session |
| `session_demo.php` | Session-based login/logout demo |

## Notes
- Cookies and sessions require a PHP server — won't work by just opening the HTML file directly.
- Demo login credentials: username = `admin`, password = `admin123`
