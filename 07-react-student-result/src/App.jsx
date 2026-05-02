import React, { useState } from 'react'
import Student from './components/Student'
import Result from './components/Result'

export default function App() {
  const [name, setName]     = useState('John Doe')
  const [course, setCourse] = useState('B.Tech CSE')
  const [marks, setMarks]   = useState(
    Array(4).fill(null).map(() => ({ mse: 0, ese: 0 }))
  )
  const [showResult, setShowResult] = useState(false)

  function handleMarksChange(index, field, value) {
    const updated = marks.map((m, i) =>
      i === index ? { ...m, [field]: value } : m
    )
    setMarks(updated)
    setShowResult(false)
  }

  return (
    <div className="container">
      <h3>🎓 VIT Student Result System</h3>

      <div className="row">
        <div className="col">
          <label>Student Name</label>
          <input type="text" value={name}
            onChange={e => { setName(e.target.value); setShowResult(false) }} />
        </div>
        <div className="col">
          <label>Course</label>
          <input type="text" value={course}
            onChange={e => { setCourse(e.target.value); setShowResult(false) }} />
        </div>
      </div>

      <Student name={name} course={course} marks={marks} onMarksChange={handleMarksChange} />

      <button className="btn" onClick={() => setShowResult(true)}>Generate Result</button>

      {showResult && <Result name={name} marks={marks} />}
    </div>
  )
}
