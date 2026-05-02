# How to Run — React Student Feedback Form

## Setup (Vite)

### 1. Create Vite app
```bash
npm create vite@latest 08-react-feedback-form -- --template react
cd 08-react-feedback-form
```

### 2. Install dependencies
```bash
npm install
```
> No extra packages needed — uses plain CSS (`src/index.css`)

### 3. Copy source files
Copy the `src/` folder from this project into the Vite project (replace default `src/`).

### 4. Run
```bash
npm run dev
```
App runs at: `http://localhost:5173`

## Project Structure
```
src/
├── main.jsx                      ← entry point, imports bootstrap CSS
├── App.jsx                       ← manages feedback state
└── components/
    ├── FeedbackForm.jsx           ← useState (controlled), useRef, validation
    └── FeedbackList.jsx           ← renders list with key prop
```
