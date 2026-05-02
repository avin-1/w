# How to Run — Express Task Manager REST API

## Steps
```bash
cd 35-express-task-manager-api
npm install
node app.js
```
API runs at: `http://localhost:3000`

## Endpoints (test with Postman)
| Method | URL | Description |
|--------|-----|-------------|
| GET    | `/api/tasks` | Get all tasks |
| GET    | `/api/tasks?status=pending` | Filter by status |
| GET    | `/api/tasks/:id` | Get task by ID |
| POST   | `/api/tasks` | Add new task |
| PUT    | `/api/tasks/:id` | Update task (title, status) |
| DELETE | `/api/tasks/:id` | Delete task |

## Sample POST body
```json
{ "title": "Buy groceries", "description": "Milk, eggs, bread" }
```

## Mark as completed (PUT)
```json
{ "status": "completed" }
```

## Notes
- Data stored in memory — resets on restart
- Status values: `pending` or `completed`
