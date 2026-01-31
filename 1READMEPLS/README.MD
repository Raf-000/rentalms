# Rental Management System

A comprehensive web-based boarding house management system built with Laravel 11, designed to streamline tenant management, billing, payments, and maintenance requests.

## 🎯 Features

- **Admin Dashboard**: Manage tenants, rooms, bills, payments, and maintenance requests
- **Tenant Portal**: View bills, upload payment proofs, submit maintenance requests
- **Public Website**: View available rooms, book viewings
- **Billing System**: Generate and track bills with multiple payment statuses
- **Payment Verification**: Upload and verify payment proofs
- **Maintenance Tracking**: Submit and track maintenance requests
- **Secure Authentication**: Login and password reset functionality

---

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2 or higher** ([Download](https://www.php.net/downloads))
- **Composer 2.x** ([Download](https://getcomposer.org/download/))
- **MySQL 8.0 or higher** ([Download](https://dev.mysql.com/downloads/))
- **Node.js 18.x or higher** (optional, for frontend assets)
- **Git** ([Download](https://git-scm.com/downloads))

### Check Your Versions
```bash
php --version       # Should show PHP 8.2.x or higher
composer --version  # Should show Composer 2.x
mysql --version     # Should show MySQL 8.0.x or higher
```

---

## 🚀 Installation & Setup

### 1. Clone the Repository
```bash
git clone https://github.com/your-username/rentalms.git
cd rentalms
```

### 2. Install Dependencies
```bash
composer install
```

**If you encounter errors:**
- Make sure you're using PHP 8.2+
- Try: `composer install --ignore-platform-reqs` (use cautiously)
- Update Composer: `composer self-update`

### 3. Environment Configuration
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Configure Database

**Option A: Using XAMPP/MAMP (Recommended for beginners)**

1. Start XAMPP/MAMP
2. Open phpMyAdmin (http://localhost/phpmyadmin)
3. Create a new database named `rentalms`

**Option B: Using MySQL command line**
```bash
mysql -u root -p
CREATE DATABASE rentalms;
EXIT;
```

**Edit `.env` file:**
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rentalms
DB_USERNAME=root
DB_PASSWORD=       # Leave empty for XAMPP/MAMP, or enter your MySQL password
```

### 5. Run Database Migrations
```bash
php artisan migrate
```

**This will create all necessary tables.**

### 6. Seed Database (Optional)
```bash
php artisan db:seed
```

**This creates sample data for testing.**

### 7. Start the Application
```bash
php artisan serve
```

**Access the application at:** `http://localhost:8000`

---

## 🔑 Default Login Credentials

After seeding, you can use these credentials:

**Admin Account:**
- Email: `admin@rentalms.com`
- Password: `password123`

**Tenant Account:**
- Email: `tenant@rentalms.com`
- Password: `password123`

---

## 🛠️ Common Issues & Solutions

### Issue: "Class 'PDO' not found"

**Solution:** Enable PDO extension in `php.ini`
```ini
# Find and uncomment these lines:
extension=pdo_mysql
extension=mysqli
```

Restart Apache/PHP after editing.

---

### Issue: "composer: command not found"

**Solution:** Composer is not installed or not in PATH

- **Mac:** `brew install composer`
- **Windows:** Reinstall Composer and check "Add to PATH"

---

### Issue: "SQLSTATE[HY000] [2002] Connection refused"

**Solution:** MySQL is not running

- **XAMPP:** Start MySQL module
- **MAMP:** Start servers
- **Command line:** `brew services start mysql` (Mac) or check Services (Windows)

---

### Issue: PHP version mismatch

**Solution:** 

**Mac (using Homebrew):**
```bash
brew install php@8.2
brew link php@8.2 --force --overwrite
php --version  # Verify
```

**Windows:**
- Download PHP 8.2 from php.net
- Update PATH to point to new PHP folder

---

### Issue: "Permission denied" on storage/logs

**Solution:**

**Mac/Linux:**
```bash
chmod -R 775 storage bootstrap/cache
```

**Windows:** Run terminal as Administrator

---

## 🌐 Deployment (Ngrok for Testing)

**For sharing with clients or testing remotely:**

### 1. Install Ngrok

**Mac:**
```bash
brew install ngrok
```

**Windows:** Download from https://ngrok.com/download

### 2. Start Laravel
```bash
php artisan serve
```

### 3. Start Ngrok (in new terminal)
```bash
ngrok http 8000
```

### 4. Update Environment

Copy the HTTPS URL from ngrok (e.g., `https://abc123.ngrok-free.dev`)

**Update `.env`:**
```env
APP_URL=https://your-ngrok-url.ngrok-free.dev
ASSET_URL=https://your-ngrok-url.ngrok-free.dev
SESSION_SAME_SITE=none
SESSION_SECURE_COOKIE=true
```

### 5. Clear Cache
```bash
php artisan config:clear
php artisan cache:clear
```

**Share the ngrok URL with your client!**

---

## 📁 Project Structure
```
rentalms/
├── app/
│   ├── Http/Controllers/     # Business logic
│   ├── Models/               # Database models
│   └── Providers/            # Service providers
├── database/
│   ├── migrations/           # Database schema
│   └── seeders/              # Sample data
├── public/
│   ├── css/                  # Stylesheets
│   ├── js/                   # JavaScript files
│   └── images/               # Images
├── resources/views/          # Blade templates
├── routes/
│   ├── web.php              # Web routes
│   └── auth.php             # Authentication routes
└── .env                     # Environment configuration
```

---

## 🤝 Contributing

1. Create a new branch: `git checkout -b feature/your-feature-name`
2. Make your changes
3. Commit: `git commit -m "Add your feature"`
4. Push: `git push origin feature/your-feature-name`
5. Create a Pull Request

---

## 📝 License

This project is for educational purposes.

---

## 👥 Team

- Rafael Abot - Main Developer | Full-stack
- Vevery Sumiwan - Project Manager | Documentation | Data Management
- Mary Toni Lugtu - Front-end | Documentation | Database Management
- Lawrence Sumile - Front-end | Database Management

---

## 📞 Support

For issues or questions:
- Create an issue on GitHub
- Contact: abotrafael03@gmail.com