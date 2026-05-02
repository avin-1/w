# How to Run — React Currency Converter

## Setup (Vite)
```bash
npm create vite@latest 16-react-currency-converter -- --template react
cd 16-react-currency-converter
npm install
```

Copy the `src/` folder from this project into the Vite project (replace default `src/`).

```bash
npm run dev
```
App runs at: `http://localhost:5173`

## Notes
- Uses a fixed rate: 1 USD = ₹83.5
- Uses `useState` for input and conversion result
- No external libraries — plain CSS in `src/index.css`
