package com.example.security.controller;

import com.example.security.model.User;
import com.example.security.repository.UserRepository;
import com.example.security.service.LoginAttemptService;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.http.ResponseEntity;
import org.springframework.security.crypto.password.PasswordEncoder;
import org.springframework.web.bind.annotation.*;

import java.util.Map;
import java.util.Optional;

@RestController
@RequestMapping("/api")
public class AuthController {

    @Autowired private UserRepository     userRepo;
    @Autowired private PasswordEncoder    passwordEncoder;
    @Autowired private LoginAttemptService attemptService;

    // Register a new user
    @PostMapping("/register")
    public ResponseEntity<Map<String, String>> register(@RequestBody Map<String, String> body) {
        String username = body.get("username");
        String password = body.get("password");

        if (userRepo.findByUsername(username).isPresent())
            return ResponseEntity.badRequest().body(Map.of("error", "Username already exists"));

        User user = new User();
        user.setUsername(username);
        user.setPassword(passwordEncoder.encode(password));
        userRepo.save(user);

        return ResponseEntity.ok(Map.of("message", "Registered successfully"));
    }

    // Login — tracks failed attempts, locks after 3 failures
    @PostMapping("/login")
    public ResponseEntity<Map<String, Object>> login(@RequestBody Map<String, String> body) {
        String username = body.get("username");
        String password = body.get("password");

        Optional<User> userOpt = userRepo.findByUsername(username);

        if (userOpt.isEmpty())
            return ResponseEntity.status(401).body(Map.of("error", "User not found"));

        User user = userOpt.get();

        // Auto-unlock if lock time has expired
        if (user.isLocked() && attemptService.isLockExpired(user)) {
            attemptService.loginSucceeded(user);
        }

        if (user.isLocked()) {
            return ResponseEntity.status(423).body(Map.of(
                "error",   "Account locked after " + attemptService.getMaxAttempts() + " failed attempts.",
                "message", "Try again after " + attemptService.getLockMinutes() + " minutes."
            ));
        }

        if (!passwordEncoder.matches(password, user.getPassword())) {
            attemptService.loginFailed(user);
            int remaining = attemptService.getMaxAttempts() - user.getFailedAttempts();
            return ResponseEntity.status(401).body(Map.of(
                "error",     "Invalid password",
                "attempts",  user.getFailedAttempts(),
                "remaining", Math.max(remaining, 0)
            ));
        }

        attemptService.loginSucceeded(user);
        return ResponseEntity.ok(Map.of("message", "Login successful", "username", username));
    }
}
