import React from 'react'

export default function FeedbackList({ feedbacks }) {
  if (feedbacks.length === 0) return null

  return (
    <div>
      <h5>📋 Submitted Feedbacks ({feedbacks.length})</h5>
      {feedbacks.map((fb, index) => (
        <div key={index} className="feedback-item">
          <div className="top">
            <strong>{fb.name}</strong>
            <span>{'⭐'.repeat(parseInt(fb.rating))}</span>
          </div>
          <div className="course">{fb.course}</div>
          <p>{fb.comment}</p>
        </div>
      ))}
    </div>
  )
}
