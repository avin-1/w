import React from 'react'

export default function ThemeCard({ title, description }) {
  return (
    <div className="card">
      <h5>{title}</h5>
      <p>{description}</p>
    </div>
  )
}
