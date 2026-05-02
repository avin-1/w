const express = require('express');
const app     = express();
const PORT    = 3000;

app.use(express.json());

// In-memory task store
let tasks  = [];
let nextId = 1;

// GET all tasks (optional filter: ?status=pending or ?status=completed)
app.get('/api/tasks', (req, res) => {
  const { status } = req.query;
  if (status) {
    return res.json(tasks.filter(t => t.status === status));
  }
  res.json(tasks);
});

// GET single task
app.get('/api/tasks/:id', (req, res) => {
  const task = tasks.find(t => t.id === parseInt(req.params.id));
  if (!task) return res.status(404).json({ error: 'Task not found' });
  res.json(task);
});

// POST add task
app.post('/api/tasks', (req, res) => {
  const { title, description } = req.body;

  if (!title)
    return res.status(400).json({ error: 'title is required' });

  const task = {
    id:          nextId++,
    title,
    description: description || '',
    status:      'pending',
    createdAt:   new Date().toISOString(),
  };
  tasks.push(task);
  res.status(201).json(task);
});

// PUT update task status
app.put('/api/tasks/:id', (req, res) => {
  const task = tasks.find(t => t.id === parseInt(req.params.id));
  if (!task) return res.status(404).json({ error: 'Task not found' });

  const { title, description, status } = req.body;

  if (status && !['pending', 'completed'].includes(status))
    return res.status(400).json({ error: 'status must be pending or completed' });

  if (title)       task.title       = title;
  if (description) task.description = description;
  if (status)      task.status      = status;

  res.json(task);
});

// DELETE task
app.delete('/api/tasks/:id', (req, res) => {
  const index = tasks.findIndex(t => t.id === parseInt(req.params.id));
  if (index === -1) return res.status(404).json({ error: 'Task not found' });

  tasks.splice(index, 1);
  res.json({ message: 'Task deleted' });
});

app.listen(PORT, () => console.log(`Task Manager API running at http://localhost:${PORT}`));
