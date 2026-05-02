import { createSlice } from '@reduxjs/toolkit'

const notificationSlice = createSlice({
  name: 'notifications',
  initialState: [],
  reducers: {
    addNotification: (state, action) => {
      state.push({
        id:      Date.now(),
        message: action.payload.message,
        type:    action.payload.type || 'info',
      })
    },
    removeNotification: (state, action) => {
      return state.filter(n => n.id !== action.payload)
    },
  }
})

export const { addNotification, removeNotification } = notificationSlice.actions
export default notificationSlice.reducer
