const express = require('express');
const app     = express();
const PORT    = 3000;

app.use(express.json());

// In-memory store (no DB needed)
let posts  = [];
let nextId = 1;

// GET all posts
app.get('/api/posts', (req, res) => {
  res.json(posts);
});

// GET single post by id
app.get('/api/posts/:id', (req, res) => {
  const post = posts.find(p => p.id === parseInt(req.params.id));
  if (!post) return res.status(404).json({ error: 'Post not found' });
  res.json(post);
});

// POST create post
app.post('/api/posts', (req, res) => {
  const { title, content, author } = req.body;

  if (!title || !content || !author)
    return res.status(400).json({ error: 'title, content and author are required' });

  const post = {
    id:        nextId++,
    title,
    content,
    author,
    createdAt: new Date().toISOString(),
  };
  posts.push(post);
  res.status(201).json(post);
});

// PUT update post
app.put('/api/posts/:id', (req, res) => {
  const index = posts.findIndex(p => p.id === parseInt(req.params.id));
  if (index === -1) return res.status(404).json({ error: 'Post not found' });

  const { title, content, author } = req.body;
  posts[index] = { ...posts[index], title, content, author };
  res.json(posts[index]);
});

// DELETE post
app.delete('/api/posts/:id', (req, res) => {
  const index = posts.findIndex(p => p.id === parseInt(req.params.id));
  if (index === -1) return res.status(404).json({ error: 'Post not found' });

  posts.splice(index, 1);
  res.json({ message: 'Post deleted successfully' });
});

app.listen(PORT, () => console.log(`Blog API running at http://localhost:${PORT}`));
