const mysql = require('mysql2');

const db = mysql.createConnection({
  host:     'localhost',
  user:     'root',
  password: '',
  multipleStatements: true
});

// Create DB and table if not exists
db.connect((err) => {
  if (err) {
    console.error('MySQL connection failed:', err.message);
    return;
  }
  console.log('Connected to MySQL');

  db.query(`
    CREATE DATABASE IF NOT EXISTS student_registration;
    USE student_registration;
    CREATE TABLE IF NOT EXISTS students (
      id     INT AUTO_INCREMENT PRIMARY KEY,
      name   VARCHAR(100) NOT NULL,
      email  VARCHAR(100) NOT NULL,
      course VARCHAR(100) NOT NULL
    );
  `, (err) => {
    if (err) console.error('DB setup error:', err.message);
    else console.log('Database ready');
  });
});

module.exports = db;
