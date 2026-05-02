import React from 'react'
import { useDispatch } from 'react-redux'
import { removeNotification } from '../store/notificationSlice'

const icons = { info: 'ℹ️', success: '✅', warning: '⚠️', error: '❌' }

export default function NotificationItem({ notification }) {
  const dispatch = useDispatch()

  return (
    <div className={`notif-item ${notification.type}`}>
      <div>
        <div className="type">{icons[notification.type]} {notification.type}</div>
        <div className="msg">{notification.message}</div>
      </div>
      <button className="dismiss-btn"
        onClick={() => dispatch(removeNotification(notification.id))}>
        ×
      </button>
    </div>
  )
}
