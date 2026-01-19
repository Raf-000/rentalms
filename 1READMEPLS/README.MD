RENTAL MANAGEMENT SYSTEM
A web-based rental management system for boarding houses built with Laravel.

TEAM MEMBERS:

Rafael A. - Backend & Database
Veverly S. - 
Mary Toni L. -
Lawrence S. - 

PREREQUISITES (Install these first!)
Before you start, make sure you have these installed: HUWAG KA MA-OVERWHELM, BAKA NAGAWA MO NA MOSTLY NANDITO like yung XAMPP ganon.

GOODLUCK!

XAMPP or Laragon (includes PHP and MySQL)
Composer (download from getcomposer.org)
Node.js and npm (download from nodejs.org)
Git (download from git-scm.com)

FIRST TIME SETUP
STEP 1: Clone the repository
git clone [YOUR-GITHUB-REPO-URL-HERE]
cd rentalms
STEP 2: Install PHP dependencies
composer install
STEP 3: Install JavaScript dependencies
npm install
STEP 4: Set up environment file
copy .env.example .env
(On Mac/Linux use: cp .env.example .env)
STEP 5: Generate application key
php artisan key:generate
STEP 6: Configure your database
Open the .env file and update these lines with your database info:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=rentalms
DB_USERNAME=root
DB_PASSWORD=
STEP 7: Create the database

Open phpMyAdmin (go to http://localhost/phpmyadmin)
Click "New" to create a new database
Name it exactly: rentalms
Click "Create"

STEP 8: Run migrations and seed data
php artisan migrate --seed
This creates all the tables and adds test accounts.
STEP 9: Start the development servers
You need to open TWO terminal windows:
Terminal 1 (for Vite - keeps CSS/JS working):
npm run dev
Terminal 2 (for Laravel server):
php artisan serve
IMPORTANT: Keep both terminals running! Don't close them.
STEP 10: Access the website
Open your browser and go to: http://127.0.0.1:8000
TEST ACCOUNTS
Admin Account:
Email: unocutie@gmail.com
Password: 123
Tenant Account 1:
Email: aldubyou@gmail.com
Password: 221
Tenant Account 2:
Email: rmph@gmail.com
Password: 222
DAILY WORKFLOW (After first setup)
Every time you work on the project:

Pull latest changes from GitHub:
git pull
Start the two servers:
Terminal 1: npm run dev
Terminal 2: php artisan serve
Work on your tasks (edit files, add features, etc.)
When done, save and commit your changes:
git add .
git commit -m "describe what you changed"
git push

PROJECT STRUCTURE (Where to find things)
app/                        - Backend logic (Controllers, Models)
resources/views/            - Frontend HTML files (Blade templates)
resources/views/admin/      - Admin dashboard pages
resources/views/tenant/     - Tenant dashboard pages
public/css/                 - Your custom CSS files
public/js/                  - Your custom JavaScript files
routes/web.php              - All page routes (URLs)
database/migrations/        - Database table structure
COMMON ISSUES & SOLUTIONS
Problem: "Access denied for user 'root'"
Solution: Check your .env file, make sure DB_PASSWORD matches your MySQL password
Problem: "Base table or view not found"
Solution: Run: php artisan migrate --seed
Problem: Changes not showing up
Solution: Clear cache with: php artisan config:clear
Problem: npm run dev not working
Solution: Delete node_modules folder, then run: npm install
NEED HELP?

Laravel documentation: laravel.com/docs
Contact [Your Name] for backend/database questions
Contact [Frontend Person] for CSS/JS questions

IMPORTANT NOTES

NEVER push the .env file to GitHub (it contains sensitive info)
ALWAYS pull before you push to avoid conflicts
Keep both terminals running while working
Don't edit database directly, use migrations instead
