#!/bin/bash

echo "🚀 Setting up Rental Management System..."
echo ""

# Check PHP version
echo "📌 Checking PHP version..."
php_version=$(php -r "echo PHP_VERSION;")
required_version="8.2"

if php -r "exit(version_compare(PHP_VERSION, '$required_version', '<') ? 0 : 1);"; then
    echo "❌ PHP version $php_version is too old. Please install PHP 8.2 or higher."
    echo "   Mac: brew install php@8.2"
    echo "   Windows: Download from https://www.php.net/downloads"
    exit 1
else
    echo "✅ PHP $php_version detected"
fi

# Check if composer exists
if ! command -v composer &> /dev/null; then
    echo "❌ Composer not found. Please install Composer first."
    echo "   Visit: https://getcomposer.org/download/"
    exit 1
else
    echo "✅ Composer detected"
fi

# Install dependencies
echo ""
echo "📦 Installing PHP dependencies..."
composer install

# Copy .env if not exists
if [ ! -f .env ]; then
    echo ""
    echo "⚙️  Creating .env file..."
    cp .env.example .env
    php artisan key:generate
    echo "✅ .env file created"
else
    echo "⚠️  .env file already exists, skipping..."
fi

# Create database
echo ""
echo "🗄️  Database setup..."
read -p "Enter database name [rentalms]: " db_name
db_name=${db_name:-rentalms}

read -p "Enter MySQL username [root]: " db_user
db_user=${db_user:-root}

read -sp "Enter MySQL password (press Enter if none): " db_pass
echo ""

# Update .env
sed -i '' "s/DB_DATABASE=.*/DB_DATABASE=$db_name/" .env
sed -i '' "s/DB_USERNAME=.*/DB_USERNAME=$db_user/" .env
sed -i '' "s/DB_PASSWORD=.*/DB_PASSWORD=$db_pass/" .env

echo "✅ Database configuration updated"

# Try to create database
echo ""
echo "Creating database..."
mysql -u "$db_user" -p"$db_pass" -e "CREATE DATABASE IF NOT EXISTS $db_name;" 2>/dev/null
if [ $? -eq 0 ]; then
    echo "✅ Database '$db_name' created successfully"
else
    echo "⚠️  Could not create database automatically. Please create it manually."
fi

# Run migrations
echo ""
echo "🔄 Running database migrations..."
php artisan migrate

read -p "Do you want to seed the database with sample data? (y/n): " seed_choice
if [ "$seed_choice" == "y" ]; then
    php artisan db:seed
    echo "✅ Database seeded with sample data"
fi

# Clear cache
echo ""
echo "🧹 Clearing cache..."
php artisan config:clear
php artisan cache:clear

echo ""
echo "✨ Setup complete!"
echo ""
echo "🎉 You can now run the application with:"
echo "   php artisan serve"
echo ""
echo "📌 Access the application at: http://localhost:8000"
echo ""
echo "🔑 Default login credentials:"
echo "   Admin: admin@rentalms.com / password123"
echo "   Tenant: tenant@rentalms.com / password123"
echo ""