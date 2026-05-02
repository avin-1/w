package com.example.auth.controller;

import com.example.auth.model.User;
import com.example.auth.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.web.bind.annotation.*;

import java.util.Map;
import java.util.Optional;

@RestController
@RequestMapping("/api/auth")
public class AuthController {

    @Autowired private UserRepository    userRepo;
    @Autowired private PasswordEncoder   passwordEncoder;

    // POST /api/auth/register — store user with encrypted password
    @PostMapping("/register")
    public ResponseEntity<Map<String, String>> register(@RequestBody Map<String, String> body) {
        String username = body.get("username");
        String password = body.get("password");

        if (username == null || password == null)
            return ResponseEntity.badRequest().body(Map.of("error", "Username and password required"));

        if (userRepo.findByUsername(username).isPresent())
            return ResponseEntity.badRequest().body(Map.of("error", "Username already exists"));

        User user = new User();
        user.setUsername(username);
        user.setPassword(passwordEncoder.encode(password)); // BCrypt hash
        userRepo.save(user);

        return ResponseEntity.ok(Map.of(
            "message",        "User registered successfully",
            "username",       username,
            "passwordStored", user.getPassword()  // show the hash for demo
        ));
    }

    // POST /api/auth/login — verify password against stored hash
    @PostMapping("/login")
    public ResponseEntity<Map<String, String>> login(@RequestBody Map<String, String> body) {
        String username = body.get("username");
        String password = body.get("password");

        Optional<User> userOpt = userRepo.findByUsername(username);

        if (userOpt.isEmpty())
            return ResponseEntity.status(401).body(Map.of("error", "User not found"));

        boolean matches = passwordEncoder.matches(password, userOpt.get().getPassword());

        if (matches)
            return ResponseEntity.ok(Map.of("message", "Login successful", "username", username));
        else
            return ResponseEntity.status(401).body(Map.of("error", "Invalid password"));
    }
}
