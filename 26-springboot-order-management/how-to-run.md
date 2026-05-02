# How to Run — Spring Boot Order Management

## Requirements
- Java 17+, Maven 3.6+, MySQL running

## Steps
```bash
cd 26-springboot-order-management
mvn spring-boot:run
```
App runs at: `http://localhost:8080`

## API Endpoints (test with Postman)
| Method | URL | Body |
|--------|-----|------|
| GET    | `/api/orders` | — |
| GET    | `/api/orders/{id}` | — |
| POST   | `/api/orders` | JSON body |
| PUT    | `/api/orders/{id}` | JSON body |
| DELETE | `/api/orders/{id}` | — |

## Sample POST body
```json
{
  "customerName": "John Doe",
  "product": "Laptop",
  "quantity": 1,
  "totalPrice": 55000.00,
  "status": "Pending",
  "orderDate": "2026-05-01"
}
```

## Structure
```
src/main/java/com/example/orders/
├── OrderManagementApplication.java
├── model/      Order.java
├── repository/ OrderRepository.java
└── controller/ OrderController.java
```
