import React, { useState, useEffect } from 'react'
import ClockSegment from './components/ClockSegment'

export default function App() {
  const [time, setTime]       = useState(new Date())
  const [running, setRunning] = useState(true)

  // useEffect — start/stop interval based on running state
  useEffect(() => {
    if (!running) return

    const interval = setInterval(() => {
      setTime(new Date())
    }, 1000)

    // Cleanup on unmount or when running changes
    return () => clearInterval(interval)
  }, [running])

  const hours   = time.getHours()
  const minutes = time.getMinutes()
  const seconds = time.getSeconds()

  const dateStr = time.toLocaleDateString('en-IN', {
    weekday: 'long', year: 'numeric', month: 'long', day: 'numeric'
  })

  return (
    <div className="clock-wrap">
      <h3>⏰ Digital Clock</h3>

      <div className="clock">
        <ClockSegment value={hours}   label="Hours"   />
        <span className="colon">:</span>
        <ClockSegment value={minutes} label="Minutes" />
        <span className="colon">:</span>
        <ClockSegment value={seconds} label="Seconds" />
      </div>

      <p className="date">{dateStr}</p>

      <button
        className={`btn ${running ? 'running' : 'stopped'}`}
        onClick={() => setRunning(r => !r)}
      >
        {running ? '⏸ Stop' : '▶ Start'}
      </button>
    </div>
  )
}
