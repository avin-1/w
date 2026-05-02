# How to Run — Spring Boot Password Encryption (BCrypt)

## Requirements
- Java 17+, Maven, MySQL running

## Steps
```bash
cd 32-springboot-password-encryption
mvn spring-boot:run
```
App runs at: `http://localhost:8080`

## Test with Postman

### Register (POST)
`POST http://localhost:8080/api/auth/register`
```json
{ "username": "john", "password": "mypassword123" }
```
Response shows the BCrypt hash stored in DB.

### Login (POST)
`POST http://localhost:8080/api/auth/login`
```json
{ "username": "john", "password": "mypassword123" }
```

## Structure
```
src/main/java/com/example/auth/
├── AuthApplication.java
├── config/     SecurityConfig.java   ← BCryptPasswordEncoder bean
├── model/      User.java
├── repository/ UserRepository.java
└── controller/ AuthController.java   ← register (encode) + login (matches)
```
