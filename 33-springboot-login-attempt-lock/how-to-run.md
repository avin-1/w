# How to Run — Spring Boot Login Attempt Lock

## Requirements
- Java 17+, Maven, MySQL running

## Steps
```bash
cd 33-springboot-login-attempt-lock
mvn spring-boot:run
```
App runs at: `http://localhost:8080`

## Test with Postman

### Register
`POST /api/register` → `{ "username": "john", "password": "pass123" }`

### Login (fail 3 times to trigger lock)
`POST /api/login` → `{ "username": "john", "password": "wrongpass" }`

After 3 failures → account locked for 5 minutes.

## Structure
```
src/main/java/com/example/security/
├── SecurityApplication.java
├── config/     SecurityConfig.java        ← BCrypt bean, permit all
├── model/      User.java                  ← failedAttempts, locked, lockTime fields
├── repository/ UserRepository.java
├── service/    LoginAttemptService.java   ← track/reset attempts, auto-unlock logic
└── controller/ AuthController.java        ← register + login endpoints
```
