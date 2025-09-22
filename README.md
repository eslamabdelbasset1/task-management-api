# 🚀 Task Management REST API

**Laravel-based clean code REST API demonstrating senior-level backend development practices.**

## Quick Start

### 1. Project Setup
```bash
# Create new Laravel project
composer create-project laravel/laravel task-management
cd task-management

# Install additional dependencies
composer require laravel/sanctum

# Copy environment file and generate key
cp .env.example .env
php artisan key:generate
```

### 2. Environment Configuration
Create `.env` file with database configuration:
```env
APP_NAME="Task Management API"
APP_ENV=local
APP_KEY=base64:your-generated-key-here
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=

CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

### 3. Database Setup
```bash
# Create database
mysql -u root -p -e "CREATE DATABASE task_management;"

# Run migrations and seed data
php artisan migrate
php artisan db:seed

# Start development server
php artisan serve
```

## 📋 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| `GET` | `/api/tasks` | List all tasks (with filtering & pagination) |
| `POST` | `/api/tasks` | Create new task |
| `GET` | `/api/tasks/{id}` | Get single task |
| `PATCH` | `/api/tasks/{id}/toggle` | Toggle task completion status |
| `GET` | `/api/categories` | List all categories with stats |

## 🔧 Query Parameters

**Tasks Filtering:**
- `?completed=true|false` - Filter by completion status
- `?priority=low|medium|high` - Filter by priority level
- `?category_id=1` - Filter by category ID

**Example:** `/api/tasks?completed=false&priority=high&category_id=1`

## 📝 Request Examples

### Create Task
```bash
curl -X POST "http://localhost:8000/api/tasks" \
  -H "Content-Type: application/json" \
  -d '{
    "title": "Complete project documentation",
    "description": "Write comprehensive API documentation",
    "category_id": 1,
    "priority": "high"
  }'
```

### Get All Tasks
```bash
curl -X GET "http://localhost:8000/api/tasks" \
  -H "Accept: application/json"
```

## 🏗️ Database Schema

### Categories
- `id`, `name` (unique), `color` (hex), `timestamps`

### Tasks
- `id`, `title`, `description`, `category_id` (FK), `priority` (enum), `completed` (boolean), `image_url`, `timestamps`

## ✅ Advanced Features

- **Clean Architecture** - Service layer separation, base controllers
- **Database Optimization** - Strategic indexes, eager loading, N+1 prevention
- **Validation & Security** - Custom form requests, SQL injection prevention
- **Error Handling** - Global API exception handling
- **Testing** - Comprehensive feature test coverage
- **Auto-Generated URLs** - Dynamic image URLs (`https://picsum.photos/seed/task{id}/400/300`)
- **API Resources** - Consistent JSON formatting
- **Pagination** - Built-in Laravel pagination for large datasets

## 🧪 Running Tests

### Execute All Tests

Update `.env` file:
```env
APP_NAME="Task Management API"
APP_ENV=testing
```

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/TaskApiTest.php

# Run tests with coverage
php artisan test --coverage

# Run tests in parallel
php artisan test --parallel


PASS  Tests\Feature\TaskApiTest
✓ can list tasks
✓ can create task
✓ can show single task
✓ can toggle task status

PASS  Tests\Feature\CategoryApiTest
✓ can list categories
✓ categories include task counts

Tests:  6 passed
Time:   0.45s
```

## 📊 Sample Response

```json
{
  "success": true,
  "message": "Tasks retrieved successfully",
  "data": {
    "tasks": [
      {
        "id": 1,
        "title": "Complete project documentation",
        "description": "Write comprehensive API documentation",
        "priority": "high",
        "priority_formatted": "High",
        "completed": false,
        "image_url": "https://picsum.photos/seed/task1/400/300",
        "created_at": "2025-09-22T10:30:00.000000Z",
        "updated_at": "2025-09-22T10:30:00.000000Z",
        "category": {
          "id": 1,
          "name": "Work",
          "color": "#3B82F6",
          "created_at": "2025-09-22T10:00:00.000000Z"
        }
      }
    ],
    "pagination": {
      "current_page": 1,
      "last_page": 1,
      "per_page": 15,
      "total": 1
    }
  }
}
```

## 🔧 Development Commands

```bash
# Generate fresh test data
php artisan migrate:fresh --seed

# Clear all caches
php artisan optimize:clear

# Generate API documentation
php artisan ide-helper:generate
php artisan ide-helper:models

# Code analysis
./vendor/bin/phpstan analyse
./vendor/bin/php-cs-fixer fix
```

## 🚀 Production Deployment

```bash
# Optimize for production
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set production environment
APP_ENV=production
APP_DEBUG=false
```

## 📚 Key Files Structure

```
app/
├── Http/
│   ├── Controllers/Api/
│   │   ├── BaseController.php
│   │   ├── TaskController.php
│   │   └── CategoryController.php
│   ├── Requests/
│   │   └── StoreTaskRequest.php
│   └── Resources/
│       ├── TaskResource.php
│       └── CategoryResource.php
├── Models/
│   ├── Task.php
│   └── Category.php
└── Exceptions/
    └── Handler.php

database/
├── migrations/
├── factories/
└── seeders/

tests/
└── Feature/
    ├── TaskApiTest.php
    └── CategoryApiTest.php
```

This implementation showcases **production-ready Laravel API development** with clean code principles, 
comprehensive testing, and advanced features suitable for senior backend developer roles.
