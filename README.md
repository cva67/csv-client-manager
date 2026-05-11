# CSV Client Management System

A robust Laravel-based **Client Management System** with CSV import/export functionality and  duplicate detection.

Built with **pure Laravel + Core PHP** (With third-party Excel libraries like Maatwebsite) to demonstrate strong fundamentals in file handling, memory efficiency, and clean architecture.

---

## ✨ Features Implemented

### Backend (Core)
- **CSV Import** using pure PHP 
- **Advanced Duplicate Detection**:
  - Detects duplicates **within the uploaded CSV file**
  - Smart grouping using `original_hash` + `duplicate_group_id`
- **Data Validation**
  - Email, Company Name and Phone Number format validation
  - Required fields validation
- **Batch Processing** for large files (memory efficient)
- **CSV Export** with filters:
  - All
  - Duplicates Only
  - Unique Only
- **RESTful API** with consistent JSON responses
- Proper error handling and validation messages

### Additional Highlights
- Fast duplicate checking using hashed composite key
- Detailed import info
- Clean, maintainable, and well-tested codebase
- Comprehensive test coverage

---

## 🛠 Prerequisites

- PHP ≥ 8.4
- Composer ≥ 2.0
- SQLite
- Node.js & npm (optional – for frontend expansion)
- Laravel 13.x

---

## 📥 Installation

### 1. Clone the Repository
```bash
git clone <your-repository-url>
cd csv-client-management-system
```

### 2. Install Dependencies
```bash
composer install
```

### 3. Environment Setup
```bash
cp .env.example .env
```

Update `.env`:

```env
DB_CONNECTION=SQLite

```

### 4. Generate Application Key
```bash
php artisan key:generate
```

### 5. Database Setup
```bash

php artisan migrate
php artisan db:seed     # optional
```

### 6. Run the Application
```bash
php artisan serve
```

App URL:
```
http://127.0.0.1:8000
```

API Base URL:
```
http://127.0.0.1:8000/api/imports
http://127.0.0.1:8000/api/client
```

---

## 📁 Project Structure (Key Folders)

```
app/
├── Services/             # Core services (CSV reader/export logic)
├── Requests/             # Form Requests (validation)
├── Resources/            # API Resources
├── Exports/              # CSV Export logic
|── Exports/              # CSV Import logic
└── Models/

routes/
├── api.php

database/
├── migrations/
└── seeders/

tests/
```

---

## 🧪 Running Tests

```bash
# Run all tests
php artisan test

```

### Test Coverage Includes
- Valid CSV import
- Duplicate detection
- Export functionality
- Validation rules
- Store Data when expection occurs

---

## 🔌 API Endpoints

| Method | Endpoint | Description |
|--------|----------|-------------|
| POST | `/api/import` | Upload and import CSV file |
| GET | `/api/import/{import_job_id}/duplicate-groups` | List all duplicates gropus |
| GET | `/api/import/duplicates` | Get all duplicates |
| GET | `/api/client/export` | Export CSV |

---

## 📤 Export Filters

Use query parameter:

```
?filter=all        (default)
?filter=duplicates
?filter=unique
```

---

## 📮 Postman Collection

You can test all API endpoints using the shared Postman collection:

https://web.postman.co/workspace/Personal-Workspace~5c0e57db-c73b-40c2-8d82-ef88b7d20cd5/collection/9432570-f2f7c537-051a-4193-a7f8-bf23d18b4f4c?action=share&source=copy-link&creator=9432570

## 🚀 Notes

- Built with Excel libraries show to showcase Laravel ecosystem
- Optimized for large CSV files
- Designed with clean architecture principles
- Focus on performance + scalability + maintainability

