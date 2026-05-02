import React from 'react'
import { useSelector } from 'react-redux'
import FilterPanel from './components/FilterPanel'
import ProductCard from './components/ProductCard'

// Product data stored in Redux state (via store)
const ALL_PRODUCTS = [
  { id: 1, name: 'Laptop',        category: 'Electronics', price: 45000, rating: 4.5 },
  { id: 2, name: 'T-Shirt',       category: 'Clothing',    price: 799,   rating: 4.0 },
  { id: 3, name: 'React Book',    category: 'Books',       price: 499,   rating: 4.8 },
  { id: 4, name: 'Headphones',    category: 'Electronics', price: 3500,  rating: 4.2 },
  { id: 5, name: 'Office Chair',  category: 'Furniture',   price: 12000, rating: 4.3 },
  { id: 6, name: 'Jeans',         category: 'Clothing',    price: 1499,  rating: 3.9 },
  { id: 7, name: 'Smartphone',    category: 'Electronics', price: 22000, rating: 4.6 },
  { id: 8, name: 'Study Table',   category: 'Furniture',   price: 8000,  rating: 4.1 },
  { id: 9, name: 'JavaScript Book', category: 'Books',     price: 399,   rating: 4.7 },
]

export default function App() {
  const { category, maxPrice } = useSelector(state => state.filter)

  // Filter products based on Redux state
  const filtered = ALL_PRODUCTS.filter(p => {
    const matchCategory = category === 'All' || p.category === category
    const matchPrice    = p.price <= maxPrice
    return matchCategory && matchPrice
  })

  return (
    <div className="container">
      <h3>🛒 Product Filter</h3>
      <FilterPanel />
      <p className="count">Showing {filtered.length} of {ALL_PRODUCTS.length} products</p>
      {filtered.length === 0
        ? <p className="empty">No products match the selected filters.</p>
        : <div className="grid">
            {filtered.map(p => <ProductCard key={p.id} product={p} />)}
          </div>
      }
    </div>
  )
}
