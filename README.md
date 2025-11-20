# Laravel E-commerce-Back-End

This is a simple Laravel backend project for managing products, cart, and orders.

## Requirements

- PHP >= 8.1
- Laravel 10
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
- Cart is cleared after successful order.
- JWT authentication is required for cart and order endpoints.

## DB Diagram
```text
users
-----
id (PK)
name
email
password
created_at
updated_at

products
--------
id (PK)
name
description
price
quantity
created_at
updated_at

cart
----
id (PK)
user_id (FK -> users.id)
product_id (FK -> products.id)
quantity
created_at
updated_at

orders
------
id (PK)
order_number
user_id (FK -> users.id)
address
phone
total
created_at
updated_at

order_items
-----------
id (PK)
order_id (FK -> orders.id)
product_id (FK -> products.id)
quantity
price
created_at
updated_at

