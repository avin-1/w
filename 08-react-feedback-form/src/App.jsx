import React, { useState } from 'react'
import FeedbackForm from './components/FeedbackForm'
import FeedbackList from './components/FeedbackList'

export default function App() {
  const [feedbacks, setFeedbacks] = useState([])

  function handleSubmit(fb) {
    setFeedbacks([fb, ...feedbacks])
  }

  return (
    <div className="container py-4" style={{ maxWidth: 600 }}>
      <h3 className="text-center mb-4">🎓 Student Feedback System</h3>
      <FeedbackForm onSubmit={handleSubmit} />
      <FeedbackList feedbacks={feedbacks} />
    </div>
  )
}
