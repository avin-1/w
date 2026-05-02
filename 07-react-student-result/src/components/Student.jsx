import React from 'react'

export default function Student({ name, course, marks, onMarksChange }) {
  const subjects = ['Maths', 'Physics', 'Chemistry', 'Computer']

  return (
    <div className="card">
      <h5>👤 {name} <span className="text-muted">{course}</span></h5>
      <table>
        <thead>
          <tr>
            <th>Subject</th>
            <th>MSE /30 (30%)</th>
            <th>ESE /70 (70%)</th>
          </tr>
        </thead>
        <tbody>
          {subjects.map((sub, i) => (
            <tr key={i}>
              <td>{sub}</td>
              <td>
                <input type="number" min="0" max="30"
                  value={marks[i]?.mse || 0}
                  onChange={e => onMarksChange(i, 'mse', e.target.value)} />
              </td>
              <td>
                <input type="number" min="0" max="70"
                  value={marks[i]?.ese || 0}
                  onChange={e => onMarksChange(i, 'ese', e.target.value)} />
              </td>
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  )
}
