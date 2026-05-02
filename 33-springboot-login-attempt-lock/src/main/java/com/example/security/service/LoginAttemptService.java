package com.example.security.service;

import com.example.security.model.User;
import com.example.security.repository.UserRepository;
import org.springframework.beans.factory.annotation.Autowired;
import org.springframework.stereotype.Service;

import java.time.LocalDateTime;

@Service
public class LoginAttemptService {

    private static final int    MAX_ATTEMPTS   = 3;
    private static final long   LOCK_MINUTES   = 5;

    @Autowired private UserRepository userRepo;

    public void loginFailed(User user) {
        int attempts = user.getFailedAttempts() + 1;
        user.setFailedAttempts(attempts);

        if (attempts >= MAX_ATTEMPTS) {
            user.setLocked(true);
            user.setLockTime(LocalDateTime.now());
        }
        userRepo.save(user);
    }

    public void loginSucceeded(User user) {
        user.setFailedAttempts(0);
        user.setLocked(false);
        user.setLockTime(null);
        userRepo.save(user);
    }

    // Returns true if lock has expired (auto-unlock after LOCK_MINUTES)
    public boolean isLockExpired(User user) {
        if (user.getLockTime() == null) return false;
        return user.getLockTime().plusMinutes(LOCK_MINUTES).isBefore(LocalDateTime.now());
    }

    public int getMaxAttempts()  { return MAX_ATTEMPTS; }
    public long getLockMinutes() { return LOCK_MINUTES; }
}
