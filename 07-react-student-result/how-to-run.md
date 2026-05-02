# How to Run — React Student Result System

## Frontend (React + Vite)

### 1. Create a Vite React app
```bash
npm create vite@latest 07-react-student-result -- --template react
cd 07-react-student-result
```

### 2. Install dependencies
```bash
npm install
```
> No extra packages needed — uses plain CSS (`src/index.css`)

### 3. Copy source files
Copy the `src/` folder from this project into the Vite project (replace the default `src/`).

### 4. Start the app
```bash
npm run dev
```
App runs at: `http://localhost:5173`

---

## Backend (PHP + MySQL)
1. Copy `backend/` folder into `htdocs/07-react-student-result/`
2. Start Apache + MySQL in XAMPP
3. Backend runs at: `http://localhost/07-react-student-result/backend/result.php`

## Project Structure
```
src/
├── main.jsx                  ← entry point
├── App.jsx                   ← parent component (manages state)
└── components/
    ├── Student.jsx            ← mark input form (props)
    └── Result.jsx             ← result display (pass/fail)
backend/
├── db.php
└── result.php
```
