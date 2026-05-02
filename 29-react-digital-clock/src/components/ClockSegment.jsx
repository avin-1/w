import React from 'react'

export default function ClockSegment({ value, label }) {
  return (
    <div className="segment">
      <div className="val">{String(value).padStart(2, '0')}</div>
      <div className="lbl">{label}</div>
    </div>
  )
}
