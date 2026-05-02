import React, { useState, useRef, useEffect } from 'react'

export default function FeedbackForm({ onSubmit }) {
  const [form, setForm]     = useState({ name: '', course: '', rating: '', comment: '' })
  const [errors, setErrors] = useState({})

  const nameRef = useRef(null)
  useEffect(() => { nameRef.current.focus() }, [])

  function handleChange(e) {
    setForm({ ...form, [e.target.name]: e.target.value })
    setErrors({ ...errors, [e.target.name]: '' })
  }

  function validate() {
    const errs = {}
    if (!form.name.trim())    errs.name    = 'Name is required.'
    if (!form.course.trim())  errs.course  = 'Course is required.'
    if (!form.rating)         errs.rating  = 'Please select a rating.'
    if (!form.comment.trim()) errs.comment = 'Comment is required.'
    return errs
  }

  function handleSubmit(e) {
    e.preventDefault()
    const errs = validate()
    if (Object.keys(errs).length > 0) { setErrors(errs); return }
    onSubmit(form)
    setForm({ name: '', course: '', rating: '', comment: '' })
    nameRef.current.focus()
  }

  return (
    <div className="card">
      <h5>📝 Submit Feedback</h5>
      <form onSubmit={handleSubmit}>
        <label>Your Name</label>
        <input ref={nameRef} type="text" name="name"
          className={errors.name ? 'error' : ''}
          value={form.name} onChange={handleChange} placeholder="Enter your name" />
        {errors.name && <div className="error-msg">{errors.name}</div>}

        <label>Course / Session</label>
        <input type="text" name="course"
          className={errors.course ? 'error' : ''}
          value={form.course} onChange={handleChange} placeholder="e.g. Web Technology" />
        {errors.course && <div className="error-msg">{errors.course}</div>}

        <label>Rating</label>
        <select name="rating"
          className={errors.rating ? 'error' : ''}
          value={form.rating} onChange={handleChange}>
          <option value="">-- Select Rating --</option>
          <option value="5">⭐⭐⭐⭐⭐ Excellent</option>
          <option value="4">⭐⭐⭐⭐ Good</option>
          <option value="3">⭐⭐⭐ Average</option>
          <option value="2">⭐⭐ Poor</option>
          <option value="1">⭐ Very Poor</option>
        </select>
        {errors.rating && <div className="error-msg">{errors.rating}</div>}

        <label>Comment</label>
        <textarea name="comment" rows="3"
          className={errors.comment ? 'error' : ''}
          value={form.comment} onChange={handleChange} placeholder="Write your feedback..." />
        {errors.comment && <div className="error-msg">{errors.comment}</div>}

        <button type="submit">Submit Feedback</button>
      </form>
    </div>
  )
}
