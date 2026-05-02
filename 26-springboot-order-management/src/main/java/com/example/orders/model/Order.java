package com.example.orders.model;

import jakarta.persistence.*;
import java.time.LocalDate;

@Entity
@Table(name = "orders")
public class Order {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private String customerName;
    private String product;
    private int    quantity;
    private double totalPrice;
    private String status;       // e.g. Pending, Shipped, Delivered
    private LocalDate orderDate;

    public Order() {}

    // Getters
    public Long      getId()           { return id; }
    public String    getCustomerName() { return customerName; }
    public String    getProduct()      { return product; }
    public int       getQuantity()     { return quantity; }
    public double    getTotalPrice()   { return totalPrice; }
    public String    getStatus()       { return status; }
    public LocalDate getOrderDate()    { return orderDate; }

    // Setters
    public void setId(Long id)                   { this.id = id; }
    public void setCustomerName(String name)     { this.customerName = name; }
    public void setProduct(String product)       { this.product = product; }
    public void setQuantity(int quantity)        { this.quantity = quantity; }
    public void setTotalPrice(double totalPrice) { this.totalPrice = totalPrice; }
    public void setStatus(String status)         { this.status = status; }
    public void setOrderDate(LocalDate date)     { this.orderDate = date; }
}
