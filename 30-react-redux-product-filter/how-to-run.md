# How to Run — React Redux Product Filter

## Setup (Vite)
```bash
npm create vite@latest 30-react-redux-product-filter -- --template react
cd 30-react-redux-product-filter
npm install @reduxjs/toolkit react-redux
```
Copy the `src/` folder, then:
```bash
npm run dev
```
App runs at: `http://localhost:5173`

## npm packages needed
```bash
npm install @reduxjs/toolkit react-redux
```

## Structure
```
src/
├── main.jsx                        ← wraps app in Redux <Provider>
├── index.css
├── App.jsx                         ← reads filter state, renders filtered products
├── components/
│   ├── FilterPanel.jsx             ← dispatches setCategory, setMaxPrice, resetFilters
│   └── ProductCard.jsx             ← displays single product
└── store/
    ├── store.js                    ← configureStore
    └── filterSlice.js              ← actions + reducer for category & maxPrice
```
