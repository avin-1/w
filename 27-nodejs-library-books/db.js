const mysql = require('mysql2');

const db = mysql.createConnection({
  host: 'localhost',
  user: 'root',
  password: 'root',
  multipleStatements: true
});

db.connect(err => {
  if (err) { console.error('MySQL error:', err.message); return; }
  console.log('Connected to MySQL');

  db.query(`
    CREATE DATABASE IF NOT EXISTS library_db;
    USE library_db;
    CREATE TABLE IF NOT EXISTS books (
      book_id INT AUTO_INCREMENT PRIMARY KEY,
      title   VARCHAR(200) NOT NULL,
      author  VARCHAR(100) NOT NULL,
      year    INT NOT NULL
    );
  `, err => {
    if (err) console.error('DB setup error:', err.message);
    else console.log('Database ready');
  });
});

module.exports = db;
