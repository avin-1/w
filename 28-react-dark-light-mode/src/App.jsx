import React, { useState } from 'react'
import ThemeCard from './components/ThemeCard'

const cards = [
  { title: '🎨 Design',     description: 'Clean UI that adapts to your preferred theme.' },
  { title: '⚡ Performance', description: 'Smooth transitions using CSS and React state.' },
  { title: '♿ Accessible',  description: 'High contrast in both light and dark modes.' },
]

export default function App() {
  // useState to store current theme — persists during re-renders
  const [theme, setTheme] = useState('light')

  function toggleTheme() {
    setTheme(prev => prev === 'light' ? 'dark' : 'light')
  }

  return (
    <div className={`app ${theme}`}>
      <h3>🌗 Theme Switcher</h3>
      <p className="subtitle">Toggle between Light and Dark mode using React Hooks</p>

      {/* Toggle button */}
      <button className="toggle-btn" onClick={toggleTheme}>
        {theme === 'light' ? '🌙 Switch to Dark' : '☀️ Switch to Light'}
      </button>

      {/* Display current theme */}
      <div className="theme-badge">
        Current Mode: {theme === 'light' ? '☀️ Light Mode' : '🌙 Dark Mode'}
      </div>

      {/* Cards */}
      <div className="cards">
        {cards.map((c, i) => (
          <ThemeCard key={i} title={c.title} description={c.description} />
        ))}
      </div>

      {/* Sample form to show input styling */}
      <div className="sample-form">
        <label>Sample Input</label>
        <input type="text" placeholder="Type something..."/>
        <label>Another Field</label>
        <input type="email" placeholder="Email address"/>
      </div>
    </div>
  )
}
