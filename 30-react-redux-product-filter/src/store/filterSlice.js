import { createSlice } from '@reduxjs/toolkit'

const filterSlice = createSlice({
  name: 'filter',
  initialState: {
    category: 'All',
    maxPrice: 50000,
  },
  reducers: {
    setCategory: (state, action) => { state.category = action.payload },
    setMaxPrice:  (state, action) => { state.maxPrice  = action.payload },
    resetFilters: (state) => { state.category = 'All'; state.maxPrice = 50000 },
  }
})

export const { setCategory, setMaxPrice, resetFilters } = filterSlice.actions
export default filterSlice.reducer
