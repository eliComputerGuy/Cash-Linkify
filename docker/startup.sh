#!/bin/bash

# Check if database has been seeded by looking for existing data
echo "Checking if database has been initialized..."

# Check if we should force refresh the database
if [ "$FRESH_DATABASE" = "true" ]; then
    echo "FRESH_DATABASE flag detected. Running fresh migrations and seeding..."
    php artisan migrate:fresh --force
    php artisan db:seed --force
    echo "Database has been completely refreshed!"
else
    # Run migrations first
    php artisan migrate --force

    # Check if levels table has data (indicates seeding has been done)
    if php artisan tinker --execute="echo \App\Models\Level::count();" | grep -q "0"; then
        echo "Database appears to be empty. Running seeders..."
        php artisan db:seed --force
    else
        echo "Database already contains data. Skipping seeders."
    fi
fi

# Run Laravel optimization commands
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Start Apache
apache2-foreground
