# User Management System API - Laravel 12

## Installation Guide

### Prerequisites
- PHP >= 8.2
- Composer
- MySQL
- XAMPP/Laragon
- Git
- Postman (for API testing)

### Step 1: Clone the Repository
```bash
git clone https://github.com/hemanshusite/User-management-system.git
cd user-management-system
```

### Step 2: Install Dependencies
```bash
composer install
```

### Step 3: Environment Setup
```bash
cp .env.example .env
```
Update the .env file with your database credentials:

```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=user_management
DB_USERNAME=root
DB_PASSWORD=yourpassword

CACHE_DRIVER=file
SESSION_DRIVER=file
```

### Step 4: Generate Application Key
```bash
php artisan key:generate
```

### Step 5: Run Migrations and Seeders
```bash
php artisan migrate
php artisan db:seed --class=UserSeeder
```

### Step 6: Start the Development Server
```bash
php artisan serve
```

The application will be available at http://localhost:8000

## 📬 Postman Collection

The project includes a pre-configured Postman collection in the folder at the root of the project.