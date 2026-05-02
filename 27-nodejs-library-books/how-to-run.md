# How to Run — Node.js Library Book Management

## Requirements
- Node.js 16+, MySQL running

## Steps
```bash
cd 27-nodejs-library-books
npm install
node app.js
```
Open: `http://localhost:3000`

## API
| Method | URL | Description |
|--------|-----|-------------|
| GET | `/` | HTML page — add books + view list |
| POST | `/add` | Add a new book |
| GET | `/books` | All books as JSON |

## Files
| File | Purpose |
|------|---------|
| `db.js` | MySQL connection, auto-creates `library_db` and `books` table |
| `app.js` | Express server, routes, HTML rendering |
| `package.json` | Dependencies: express, mysql2 |
