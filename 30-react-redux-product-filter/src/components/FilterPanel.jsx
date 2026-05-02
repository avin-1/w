import React from 'react'
import { useDispatch, useSelector } from 'react-redux'
import { setCategory, setMaxPrice, resetFilters } from '../store/filterSlice'

const categories = ['All', 'Electronics', 'Clothing', 'Books', 'Furniture']

export default function FilterPanel() {
  const dispatch  = useDispatch()
  const { category, maxPrice } = useSelector(state => state.filter)

  return (
    <div className="filters">
      <div className="filter-group">
        <label>Category</label>
        <select value={category} onChange={e => dispatch(setCategory(e.target.value))}>
          {categories.map(c => <option key={c}>{c}</option>)}
        </select>
      </div>

      <div className="filter-group">
        <label>Max Price: <span className="price-val">₹{maxPrice.toLocaleString()}</span></label>
        <input type="range" min="1000" max="50000" step="1000"
          value={maxPrice}
          onChange={e => dispatch(setMaxPrice(Number(e.target.value)))}/>
      </div>

      <button className="reset-btn" onClick={() => dispatch(resetFilters())}>
        Reset Filters
      </button>
    </div>
  )
}
