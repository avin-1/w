import React from 'react'

export default function Result({ name, marks }) {
  const subjects = ['Maths', 'Physics', 'Chemistry', 'Computer']

  const rows = subjects.map((sub, i) => {
    const mse    = parseFloat(marks[i]?.mse) || 0
    const ese    = parseFloat(marks[i]?.ese) || 0
    const total  = (mse + ese).toFixed(1)
    const passed = mse >= 12 && ese >= 28
    return { sub, mse, ese, total, passed }
  })

  const overallPass = rows.every(r => r.passed)

  return (
    <div className="card">
      <h5>📊 Result — {name}</h5>
      <table>
        <thead className="result-head">
          <tr><th>Subject</th><th>MSE</th><th>ESE</th><th>Total</th><th>Status</th></tr>
        </thead>
        <tbody>
          {rows.map((r, i) => (
            <tr key={i}>
              <td>{r.sub}</td>
              <td>{r.mse}/30</td>
              <td>{r.ese}/70</td>
              <td>{r.total}/100</td>
              <td className={r.passed ? 'pass' : 'fail'}>
                {r.passed ? '✅ Pass' : '❌ Fail'}
              </td>
            </tr>
          ))}
        </tbody>
      </table>
      <h5 style={{ marginTop: 12, color: overallPass ? 'green' : 'red' }}>
        Overall: {overallPass ? '🎉 PASS' : '❌ FAIL'}
      </h5>
    </div>
  )
}
