const express = require('express');
const db      = require('./db');

const app  = express();
const PORT = 3000;

app.use(express.urlencoded({ extended: true }));
app.use(express.json());

const css = `
  * { box-sizing: border-box; margin: 0; padding: 0; }
  body { font-family: Arial, sans-serif; background: #f0f4f8; padding: 24px 16px; }
  .container { max-width: 750px; margin: 0 auto; }
  h3 { color: #333; margin-bottom: 16px; }
  h5 { color: #333; margin-bottom: 10px; }
  .card { background: white; padding: 20px; border-radius: 8px; margin-bottom: 20px; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
  .form-row { display: flex; gap: 10px; flex-wrap: wrap; }
  .form-row .col { flex: 1; min-width: 120px; }
  label { display: block; font-weight: bold; margin-bottom: 4px; font-size: 14px; }
  input[type="text"], input[type="number"] { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 14px; }
  button { padding: 9px 20px; margin-top: 12px; background: #3b82f6; color: white; border: none; border-radius: 4px; cursor: pointer; font-size: 14px; }
  table { width: 100%; border-collapse: collapse; background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 6px rgba(0,0,0,0.08); }
  th, td { padding: 10px 12px; border-bottom: 1px solid #eee; font-size: 14px; text-align: left; }
  th { background: #1e293b; color: white; }
  tr:hover td { background: #f9f9f9; }
  .empty { color: #888; font-size: 14px; }
`;

function useDB(callback) {
  db.query('USE library_db', () => callback());
}

// GET / — show all books + add form
app.get('/', (req, res) => {
  useDB(() => {
    db.query('SELECT * FROM books ORDER BY book_id DESC', (err, books) => {
      if (err) return res.status(500).send(err.message);

      const rows = (books || []).map(b => `
        <tr>
          <td>${b.book_id}</td>
          <td>${b.title}</td>
          <td>${b.author}</td>
          <td>${b.year}</td>
        </tr>`).join('');

      res.send(`<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Library Books</title>
  <style>${css}</style>
</head>
<body>
<div class="container">
  <h3>📚 Library Book Management</h3>

  <div class="card">
    <h5>Add New Book</h5>
    <form action="/add" method="POST">
      <div class="form-row">
        <div class="col">
          <label>Title</label>
          <input type="text" name="title" placeholder="Book title" required/>
        </div>
        <div class="col">
          <label>Author</label>
          <input type="text" name="author" placeholder="Author name" required/>
        </div>
        <div class="col">
          <label>Year</label>
          <input type="number" name="year" placeholder="e.g. 2020" required/>
        </div>
      </div>
      <button type="submit">Add Book</button>
    </form>
  </div>

  <h5>All Books (${(books || []).length})</h5>
  ${!books || books.length === 0
    ? '<p class="empty">No books added yet.</p>'
    : `<table>
        <thead><tr><th>ID</th><th>Title</th><th>Author</th><th>Year</th></tr></thead>
        <tbody>${rows}</tbody>
      </table>`
  }
</div>
</body>
</html>`);
    });
  });
});

// POST /add — insert book
app.post('/add', (req, res) => {
  const { title, author, year } = req.body;
  if (!title || !author || !year) return res.status(400).send('All fields required.');

  useDB(() => {
    db.query('INSERT INTO books (title, author, year) VALUES (?, ?, ?)',
      [title, author, parseInt(year)],
      err => {
        if (err) return res.status(500).send(err.message);
        res.redirect('/');
      }
    );
  });
});

// GET /books — JSON API
app.get('/books', (req, res) => {
  useDB(() => {
    db.query('SELECT * FROM books ORDER BY book_id DESC', (err, results) => {
      if (err) return res.status(500).json({ error: err.message });
      res.json(results);
    });
  });
});

app.listen(PORT, () => console.log(`Server running at http://localhost:${PORT}`));
