# How to Run — Express Blog REST API

## Steps
```bash
cd 34-express-blog-api
npm install
node app.js
```
API runs at: `http://localhost:3000`

## Endpoints (test with Postman)
| Method | URL | Description |
|--------|-----|-------------|
| GET    | `/api/posts` | Get all posts |
| GET    | `/api/posts/:id` | Get post by ID |
| POST   | `/api/posts` | Create new post |
| PUT    | `/api/posts/:id` | Update post |
| DELETE | `/api/posts/:id` | Delete post |

## Sample POST body
```json
{
  "title":   "My First Blog",
  "content": "This is the blog content.",
  "author":  "John Doe"
}
```

## Notes
- Data stored in memory — resets on server restart
- No database needed
