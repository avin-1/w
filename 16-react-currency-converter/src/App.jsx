import React, { useState } from 'react'

const RATE = 83.5  // 1 USD = 83.5 INR (fixed rate for demo)

export default function App() {
  const [dollars, setDollars] = useState('')
  const [rupees, setRupees]   = useState(null)
  const [error, setError]     = useState('')

  function handleConvert() {
    const amount = parseFloat(dollars)

    if (dollars === '') {
      setError('Please enter an amount.')
      setRupees(null)
      return
    }
    if (isNaN(amount) || amount < 0) {
      setError('Please enter a valid positive number.')
      setRupees(null)
      return
    }

    setError('')
    setRupees((amount * RATE).toFixed(2))
  }

  function handleChange(e) {
    setDollars(e.target.value)
    setRupees(null)
    setError('')
  }

  return (
    <div className="card">
      <h3>💱 Currency Converter</h3>
      <p className="subtitle">US Dollar → Indian Rupee</p>

      <div className="rate-info">Fixed Rate: 1 USD = ₹{RATE}</div>

      <label>Amount in US Dollars ($)</label>
      <input
        type="number"
        placeholder="e.g. 100"
        value={dollars}
        onChange={handleChange}
        min="0"
      />

      <button onClick={handleConvert}>Convert to Rupees</button>

      {error && <p className="error">{error}</p>}

      {rupees !== null && (
        <div className="result">
          <div className="amount">₹ {rupees}</div>
          <div className="label">${dollars} USD = ₹{rupees} INR</div>
        </div>
      )}
    </div>
  )
}
