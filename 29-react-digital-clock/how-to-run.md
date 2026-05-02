# How to Run — React Digital Clock

## Setup (Vite)
```bash
npm create vite@latest 29-react-digital-clock -- --template react
cd 29-react-digital-clock
npm install
```
Copy the `src/` folder, then:
```bash
npm run dev
```
App runs at: `http://localhost:5173`

## Structure
```
src/
├── main.jsx
├── index.css
├── App.jsx                  ← useState (time), useEffect (interval), start/stop
└── components/
    └── ClockSegment.jsx     ← reusable HH / MM / SS segment
```
