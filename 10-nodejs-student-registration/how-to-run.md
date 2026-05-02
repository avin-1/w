# How to Run — Node.js Student Registration System

## Requirements
- Node.js 16+ and npm — download from https://nodejs.org
- MySQL 5.7+ — via XAMPP or standalone install

## Steps

### 1. Install dependencies
```bash
cd 10-nodejs-student-registration
npm install
```

### 2. Setup Database
Start MySQL (via XAMPP or standalone), then either:
- Let the app auto-create the table on first run, OR
- Run this manually in phpMyAdmin or MySQL CLI:
  ```sql
  CREATE DATABASE IF NOT EXISTS student_registration;
  USE student_registration;
  CREATE TABLE students (
      id     INT AUTO_INCREMENT PRIMARY KEY,
      name   VARCHAR(100),
      email  VARCHAR(100),
      course VARCHAR(100)
  );
  ```

### 3. Configure DB connection
Edit `db.js` and update your credentials:
```js
host: 'localhost',
user: 'root',
password: '',       // your MySQL password
database: 'student_registration'
```

### 4. Start the server
```bash
node app.js
```
App runs at: `http://localhost:3000`

## API Endpoints
| Method | URL | Description |
|--------|-----|-------------|
| GET    | `/` | View all students (HTML page) |
| POST   | `/register` | Register a new student |
| GET    | `/students` | Get all students as JSON |

## Project Structure
```
10-nodejs-student-registration/
├── app.js          # Express server + routes
├── db.js           # MySQL connection
├── views/
│   └── index.html  # Student list + registration form
└── package.json
```
