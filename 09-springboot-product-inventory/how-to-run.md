# How to Run — Spring Boot Product Inventory (MongoDB)

## Requirements
- Java 17+ — download from https://adoptium.net
- Maven 3.6+ — usually bundled with IDE
- MongoDB — install from https://www.mongodb.com/try/download/community
- IDE: IntelliJ IDEA / Eclipse / VS Code with Java extension

## Steps

### 1. Start MongoDB
```bash
# On Linux/Mac
mongod

# On Windows — start MongoDB service from Services or run:
"C:\Program Files\MongoDB\Server\6.0\bin\mongod.exe"
```

### 2. Run the Spring Boot App

**Using Maven:**
```bash
cd 09-springboot-product-inventory
mvn spring-boot:run
```

**Using IDE:**
- Open the project folder in IntelliJ IDEA
- Run `ProductInventoryApplication.java`

App starts at: `http://localhost:8080`

## Test with Postman
| Method | URL | Description |
|--------|-----|-------------|
| GET    | `http://localhost:8080/api/products` | Get all products |
| POST   | `http://localhost:8080/api/products` | Add new product |
| PUT    | `http://localhost:8080/api/products/{id}` | Update product |
| DELETE | `http://localhost:8080/api/products/{id}` | Delete product |

## Basic Auth Credentials
- Username: `admin`
- Password: `admin123`
- Add these in Postman under **Authorization → Basic Auth**

## Project Structure
```
09-springboot-product-inventory/
├── src/main/java/com/example/inventory/
│   ├── ProductInventoryApplication.java
│   ├── model/Product.java
│   ├── repository/ProductRepository.java
│   ├── controller/ProductController.java
│   └── config/SecurityConfig.java
├── src/main/resources/
│   └── application.properties
└── pom.xml
```
