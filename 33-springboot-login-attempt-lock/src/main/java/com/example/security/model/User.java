package com.example.security.model;

import jakarta.persistence.*;
import java.time.LocalDateTime;

@Entity
@Table(name = "users")
public class User {

    @Id
    @GeneratedValue(strategy = GenerationType.IDENTITY)
    private Long id;

    @Column(unique = true)
    private String username;
    private String password;

    private int     failedAttempts = 0;
    private boolean locked         = false;
    private LocalDateTime lockTime;

    public User() {}

    public Long          getId()             { return id; }
    public String        getUsername()       { return username; }
    public String        getPassword()       { return password; }
    public int           getFailedAttempts() { return failedAttempts; }
    public boolean       isLocked()          { return locked; }
    public LocalDateTime getLockTime()       { return lockTime; }

    public void setId(Long id)                       { this.id = id; }
    public void setUsername(String username)         { this.username = username; }
    public void setPassword(String password)         { this.password = password; }
    public void setFailedAttempts(int n)             { this.failedAttempts = n; }
    public void setLocked(boolean locked)            { this.locked = locked; }
    public void setLockTime(LocalDateTime lockTime)  { this.lockTime = lockTime; }
}
