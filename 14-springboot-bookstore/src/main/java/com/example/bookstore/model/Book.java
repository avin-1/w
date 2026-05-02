package com.example.bookstore.model;

import jakarta.persistence.*;

@Entity
@Table(name = "books")
public class Book {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    private String title;
    private String author;
    private String category;
    private double price;

    public Book() {}

    // Getters and Setters
    public Long   getId()       { return id; }
    public String getTitle()    { return title; }
    public String getAuthor()   { return author; }
    public String getCategory() { return category; }
    public double getPrice()    { return price; }

    public void setId(Long id)           { this.id = id; }
    public void setTitle(String title)   { this.title = title; }
    public void setAuthor(String author) { this.author = author; }
    public void setCategory(String cat)  { this.category = cat; }
    public void setPrice(double price)   { this.price = price; }
}
