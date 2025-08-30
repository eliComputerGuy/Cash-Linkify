#!/bin/bash

# Laravel deployment script for Render

echo "Starting Laravel deployment..."

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate application key if not exists
php artisan key:generate --force

# Clear and cache configuration
php artisan config:clear
php artisan config:cache

# Clear and cache routes
php artisan route:clear
php artisan route:cache

# Clear and cache views
php artisan view:clear
php artisan view:cache

# Run database migrations
php artisan migrate --force

# Create storage link
php artisan storage:link

# Set proper permissions
chmod -R 775 storage bootstrap/cache

echo "Laravel deployment completed!"
