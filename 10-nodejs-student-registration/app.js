const express = require('express');
const db      = require('./db');

const app  = express();
const PORT = 3000;

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

const styles = `
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 24px; }
  .container { max-width: 700px; margin: 0 auto; }
  h3 { margin-bottom: 20px; color: #333; }
  h5 { margin-bottom: 12px; color: #333; }
  .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
  label { display: block; font-weight: bold; margin-bottom: 4px; margin-top: 10px; }
  input[type="text"], input[type="email"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
  button { width: 100%; padding: 10px; margin-top: 14px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 15px; }
  button:hover { background: #2563eb; }
  table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
  th { background: #3b82f6; color: white; padding: 10px; text-align: left; }
  td { padding: 10px; border-bottom: 1px solid #eee; }
  tr:hover td { background: #f9f9f9; }
  .empty { color: #888; margin-top: 10px; }
`;

app.get('/', (req, res) => {
  db.query('USE student_registration; SELECT * FROM students ORDER BY id DESC', (err, results) => {
    if (err) return res.status(500).send('DB error: ' + err.message);

    const students = results[1] || [];
    const rows = students.map(s => `
      <tr>
        <td>${s.id}</td>
        <td>${s.name}</td>
        <td>${s.email}</td>
        <td>${s.course}</td>
      </tr>`).join('');

    res.send(`<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Registration</title>
  <style>${styles}</style>
</head>
<body>
<div class="container">
  <h3>🎓 Student Registration System</h3>

  <div class="card">
    <h5>Register New Student</h5>
    <form action="/register" method="POST">
      <label>Name</label>
      <input type="text" name="name" placeholder="Student name" required/>
      <label>Email</label>
      <input type="email" name="email" placeholder="Email address" required/>
      <label>Course</label>
      <input type="text" name="course" placeholder="e.g. B.Tech CSE" required/>
      <button type="submit">Register</button>
    </form>
  </div>

  <h5>All Registered Students (${students.length})</h5>
  ${students.length === 0
    ? '<p class="empty">No students registered yet.</p>'
    : `<table>
        <thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Course</th></tr></thead>
        <tbody>${rows}</tbody>
      </table>`
  }
</div>
</body>
</html>`);
  });
});

app.post('/register', (req, res) => {
  const { name, email, course } = req.body;
  if (!name || !email || !course) return res.status(400).send('All fields are required.');

  db.query('USE student_registration', () => {
    db.query(
      'INSERT INTO students (name, email, course) VALUES (?, ?, ?)',
      [name, email, course],
      (err) => {
        if (err) return res.status(500).send('Insert error: ' + err.message);
        res.redirect('/');
      }
    );
  });
});

app.get('/students', (req, res) => {
  db.query('USE student_registration', () => {
    db.query('SELECT * FROM students ORDER BY id DESC', (err, results) => {
      if (err) return res.status(500).json({ error: err.message });
      res.json(results);
    });
  });
});

app.listen(PORT, () => console.log(`Server running at http://localhost:${PORT}`));
