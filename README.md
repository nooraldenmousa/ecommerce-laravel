# Multi-Branch E-Commerce Management System

A full-stack web application for managing a multi-branch e-commerce business with role-based access control.

> University Project — Web Programming 2 | Arab International University

## Features
- Multi-role authentication (Department Manager / Department Employee)
- RESTful API with search & filter endpoints
- Prepared Statements & Stored Procedures
- Dynamic search with JavaScript (no page reload)
- Responsive design with Bootstrap
- Session management

## Tech Stack
- **Backend:** Laravel 12, PHP 8.2
- **Frontend:** Blade, Tailwind CSS, JavaScript, Bootstrap, Vite
- **Database:** Microsoft SQL Server (DB_STORE)
- **Architecture:** MVC, Eloquent ORM, REST API

## Modules
| Module | Description |
|--------|-------------|
| HR | Employee & department management |
| Marketing | Customer & offer management (VIP support) |
| Store Branches | Store management across provinces |
| Warehouse | Warehouse & stock management |
| Products | Product management across stores & warehouses |

## Setup
```bash
git clone https://github.com/nooraldenmousa/ecommerce-laravel.git
cd ecommerce-laravel
composer install
# Requires PHP SQL Server drivers (sqlsrv, pdo_sqlsrv) enabled in php.ini
cp .env.example .env
php artisan key:generate
```
