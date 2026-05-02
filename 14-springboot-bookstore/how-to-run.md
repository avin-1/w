# How to Run — Spring Boot Online Bookstore

## Requirements
- Java 17+
- Maven 3.6+
- MySQL running (XAMPP or standalone)

## Steps

### 1. Create the database
In phpMyAdmin or MySQL CLI:
```sql
CREATE DATABASE bookstore_db;
```
(Or set `createDatabaseIfNotExist=true` in `application.properties` — already done)

### 2. Update DB credentials if needed
Edit `src/main/resources/application.properties`:
```properties
spring.datasource.username=root
spring.datasource.password=yourpassword
```

### 3. Run the app
```bash
cd 14-springboot-bookstore
mvn spring-boot:run
```
App starts at: `http://localhost:8080`

## Pages
| URL | Page |
|-----|------|
| `/` | Home page |
| `/catalog` | Book catalog (filter by category) |
| `/login` | Login page |
| `/register` | Registration page |

## Project Structure
```
src/main/java/com/example/bookstore/
├── BookstoreApplication.java
├── model/         Book.java, User.java
├── repository/    BookRepository.java, UserRepository.java
└── controller/    BookstoreController.java
src/main/resources/
├── application.properties
└── templates/     home.html, catalog.html, login.html, register.html
```
