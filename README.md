# Laravel E-commerce-Back-End

This is a simple Laravel backend project for managing products, cart, and orders.

## Requirements

- PHP >= 8.2
- Laravel 12
- MySQL / SQLite

## Setup

1. Clone the repo:
```bash
git clone https://github.com/username/laravel-orders-cart.git
cd laravel-orders-cart
```

2. Install dependencies:
```bash
composer install
```

3. Copy .env file:
```bash
cp .env.example .env
```

4. Set up database in .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=[the name of your database]
DB_USERNAME=root
DB_PASSWORD=
```

5- Run migrations & seeders:
```bash
php artisan migrate --seed
```

6. Serve the project:
```bash
php artisan serve
```


## API Usage

### Auth
```bash
POST /api/auth/register → Register a user

POST /api/auth/login → Login

GET /api/auth/me → Get user profile

POST /api/auth/logout → Logout
```

### Products
```bash
GET /api/auth/products → List all products

GET /api/auth/products/{id} → Get product details

POST /api/auth/products → Create product

PUT /api/auth/products/{id} → Update product

DELETE /api/auth/products/{id} → Delete product
```

### Cart
```bash
GET /api/auth/cart → View cart

POST /api/auth/cart → Add to cart

PUT /api/auth/cart/{product_id} → Update cart item

DELETE /api/auth/cart/{product_id} → Remove from cart
```

### Orders
```bash
POST /api/auth/orders → Create an order from user cart
```


## Notes 
- Stock validation is handled when creating orders.
- Decrease stock after order
- Cart is cleared after successful order.
- JWT authentication is required for cart and order endpoints.

## DB Diagram
```text
+-------------------+
|       users       |
+-------------------+
| id (PK)           |
| name              |
| email (unique)    |
| email_verified_at |
| password          |
| remember_token    |
| timestamps        |
+-------------------+
          |
          | (1 - many)
          |
+-------------------+
|      carts        |
+-------------------+
| id (PK)           |
| user_id (FK) ------------------------+
| product_id (FK) --------------------+ |
| quantity                             |
| timestamps                           |
| UNIQUE (user_id, product_id)         |
+--------------------------------------+
          | many                                     many |
          |                                               |
          v                                               v
+-------------------+                    +-------------------+
|     products      |                    |   order_items     |
+-------------------+                    +-------------------+
| id (PK)           |<------------------ | id (PK)           |
| name              |      (FK) product  | order_id (FK)     |
| description       |                    | product_id (FK)   |
| price             |                    | quantity          |
| quantity          |                    | price             |
| sku (unique)      |                    | timestamps        |
| is_active         |                    +-------------------+
| timestamps        |
+-------------------+
                                ^
                                | (1 - many)
                                |
                     +-------------------+
                     |      orders       |
                     +-------------------+
                     | id (PK)           |
                     | order_number (UQ) |
                     | address           |
                     | phone             |
                     | total             |
                     | timestamps        |
                     +-------------------+







