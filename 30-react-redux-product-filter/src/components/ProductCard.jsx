import React from 'react'

export default function ProductCard({ product }) {
  return (
    <div className="product-card">
      <div className="name">{product.name}</div>
      <div className="category">{product.category}</div>
      <div className="price">₹{product.price.toLocaleString()}</div>
      <div className="rating">⭐ {product.rating}</div>
    </div>
  )
}
