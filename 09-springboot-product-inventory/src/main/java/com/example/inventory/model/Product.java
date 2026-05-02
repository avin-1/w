package com.example.inventory.model;

import org.springframework.data.annotation.Id;
import org.springframework.data.mongodb.core.mapping.Document;

@Document(collection = "products")
public class Product {

    @Id
    private String id;
    private String name;
    private String category;
    private double price;
    private int quantity;

    public Product() {}

    public String getId()       { return id; }
    public String getName()     { return name; }
    public String getCategory() { return category; }
    public double getPrice()    { return price; }
    public int    getQuantity() { return quantity; }

    public void setId(String id)          { this.id = id; }
    public void setName(String name)      { this.name = name; }
    public void setCategory(String cat)   { this.category = cat; }
    public void setPrice(double price)    { this.price = price; }
    public void setQuantity(int quantity) { this.quantity = quantity; }
}
