# Rental Management System

A web-based rental management system for boarding houses built with Laravel.

## Team Members
- Rafael A. - Backend & Database
- Veverly S. - 
- Mary Toni L. - 
- Lawrence S. - 

## Prerequisites
Before you start, make sure you have these installed:
- XAMPP or Laragon (includes PHP and MySQL)
- Composer (https://getcomposer.org/)
- Node.js and npm (https://nodejs.org/)
- Git (https://git-scm.com/)

## First Time Setup

1. **Clone the repository**
```bash
git clone [YOUR-GITHUB-REPO-URL-HERE]
cd rentalms
```

2. **Install PHP dependencies**
```bash
composer install
```

3. **Install JavaScript dependencies**
```bash
npm install
```

4. **Set up environment file**
```bash
copy .env.example .env
```
(On Mac/Linux use `cp .env.example .env`)

5. **Generate application key**
```bash
php artisan key:generate
```

6. **Configure your database**
- Open `.env` file
- Update these lines with your database info:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rentalms
DB_USERNAME=root
DB_PASSWORD=
```

7. **Create the database**
- Open phpMyAdmin (http://localhost/phpmyadmin)
- Create a new database called `rentalms`

8. **Run migrations and seed data**
```bash
php artisan migrate --seed
```

9. **Start the development servers**

Open TWO terminal windows:

Terminal 1 (for Vite):
```bash
npm run dev
```

Terminal 2 (for Laravel):
```bash
php artisan serve
```

10. **Access the website**
Open browser and go to: http://127.0.0.1:8000

## Test Accounts

**Admin:**
- Email: unocutie@gmail.com
- Password: 123

**Tenant 1:**
- Email: aldubyou@gmail.com
- Password: 221

**Tenant 2:**
- Email: rmph@gmail.com
- Password: 222

## Daily Workflow

1. Pull latest changes: `git pull`
2. Start servers: `npm run dev` + `php artisan serve`
3. Work on your tasks
4. Commit your changes: `git add .` then `git commit -m "your message"`
5. Push to GitHub: `git push`

## Project Structure

- `app/` - Backend logic (Controllers, Models)
- `resources/views/` - Frontend HTML (Blade templates)
- `public/css/` - Your custom CSS files
- `public/js/` - Your custom JavaScript files
- `routes/web.php` - All page routes
- `database/migrations/` - Database structure

## Need Help?

- Laravel docs: https://laravel.com/docs
- Contact [Your Name] for backend questions
- Contact [Frontend Person] for CSS/JS questions
```

**Before you push to GitHub, also create `.env.example`:**

Copy your `.env` file, rename it to `.env.example`, and **remove sensitive info**:
```
APP_NAME=RentalMS
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rentalms
DB_USERNAME=root
DB_PASSWORD=
```

**Also create a `.gitignore` file** (if it doesn't exist) to avoid pushing sensitive files:
```
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.phpunit.result.cache
npm-debug.log
yarn-error.log