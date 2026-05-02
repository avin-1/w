# How to Run — React Dark/Light Mode

## Setup (Vite)
```bash
npm create vite@latest 28-react-dark-light-mode -- --template react
cd 28-react-dark-light-mode
npm install
```
Copy the `src/` folder from this project, then:
```bash
npm run dev
```
App runs at: `http://localhost:5173`

## Structure
```
src/
├── main.jsx
├── index.css
├── App.jsx                    ← useState for theme, toggle button
└── components/
    └── ThemeCard.jsx          ← reusable card component
```
