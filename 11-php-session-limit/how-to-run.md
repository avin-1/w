# How to Run — PHP Session Limit

## Requirements
- PHP 7.4+
- XAMPP or PHP built-in server

## Steps
```bash
cd 11-php-session-limit
php -S localhost:8000
```
Open: `http://localhost:8000`

## How to Test
1. Open the page in **3 different browser tabs**
2. Login with the same username in each tab — all 3 succeed
3. Try a **4th tab** — it will be blocked with an error
4. Sessions auto-expire after **5 minutes** of inactivity

## Files
| File | Purpose |
|------|---------|
| `index.php` | Login/logout + session tracking logic |
| `active_sessions.json` | Auto-created — stores active session data |
