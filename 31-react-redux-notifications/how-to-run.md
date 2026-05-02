# How to Run — React Redux Notifications

## Setup (Vite)
```bash
npm create vite@latest 31-react-redux-notifications -- --template react
cd 31-react-redux-notifications
npm install @reduxjs/toolkit react-redux
```
Copy the `src/` folder, then:
```bash
npm run dev
```

## npm packages needed
```bash
npm install @reduxjs/toolkit react-redux
```

## Structure
```
src/
├── main.jsx                          ← Provider wraps App
├── index.css
├── App.jsx                           ← dispatches addNotification
├── components/
│   └── NotificationItem.jsx          ← dispatches removeNotification
└── store/
    ├── store.js
    └── notificationSlice.js          ← addNotification, removeNotification reducers
```
