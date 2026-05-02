package com.example.orders.controller;

import com.example.orders.model.Order;
import com.example.orders.repository.OrderRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.web.bind.annotation.*;

import java.util.List;

@RestController
@RequestMapping("/api/orders")
public class OrderController {

    @Autowired
    private OrderRepository repo;

    // GET all orders
    @GetMapping
    public List<Order> getAllOrders() {
        return repo.findAll();
    }

    // GET order by id
    @GetMapping("/{id}")
    public ResponseEntity<Order> getOrder(@PathVariable Long id) {
        return repo.findById(id)
            .map(ResponseEntity::ok)
            .orElse(ResponseEntity.notFound().build());
    }

    // POST create order
    @PostMapping
    public Order createOrder(@RequestBody Order order) {
        return repo.save(order);
    }

    // PUT update order
    @PutMapping("/{id}")
    public ResponseEntity<Order> updateOrder(@PathVariable Long id, @RequestBody Order updated) {
        return repo.findById(id).map(order -> {
            order.setCustomerName(updated.getCustomerName());
            order.setProduct(updated.getProduct());
            order.setQuantity(updated.getQuantity());
            order.setTotalPrice(updated.getTotalPrice());
            order.setStatus(updated.getStatus());
            order.setOrderDate(updated.getOrderDate());
            return ResponseEntity.ok(repo.save(order));
        }).orElse(ResponseEntity.notFound().build());
    }

    // DELETE order
    @DeleteMapping("/{id}")
    public ResponseEntity<String> deleteOrder(@PathVariable Long id) {
        if (!repo.existsById(id)) return ResponseEntity.notFound().build();
        repo.deleteById(id);
        return ResponseEntity.ok("Order deleted");
    }
}
