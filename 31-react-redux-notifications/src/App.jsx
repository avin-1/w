import React, { useState } from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { addNotification } from './store/notificationSlice'
import NotificationItem from './components/NotificationItem'

export default function App() {
  const dispatch       = useDispatch()
  const notifications  = useSelector(state => state.notifications)
  const [msg, setMsg]  = useState('')
  const [type, setType] = useState('info')

  function handleAdd() {
    if (!msg.trim()) return
    dispatch(addNotification({ message: msg.trim(), type }))
    setMsg('')
  }

  return (
    <div className="container">
      <h3>🔔 Notification System</h3>

      <div className="add-form">
        <h5>Add Notification</h5>
        <div className="form-row">
          <input
            type="text"
            placeholder="Enter notification message..."
            value={msg}
            onChange={e => setMsg(e.target.value)}
            onKeyDown={e => e.key === 'Enter' && handleAdd()}
          />
          <select value={type} onChange={e => setType(e.target.value)}>
            <option value="info">ℹ️ Info</option>
            <option value="success">✅ Success</option>
            <option value="warning">⚠️ Warning</option>
            <option value="error">❌ Error</option>
          </select>
          <button onClick={handleAdd}>Add</button>
        </div>
      </div>

      <div className="notif-list">
        <h5>Notifications ({notifications.length})</h5>
        {notifications.length === 0
          ? <p className="empty">No notifications. Add one above.</p>
          : notifications.map(n => (
              <NotificationItem key={n.id} notification={n} />
            ))
        }
      </div>
    </div>
  )
}
