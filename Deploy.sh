#!/bin/bash

# Define variables
REMOTE_REPO="http://vmi33328.contaboserver.net:1000/root/satreps-dev-back-end.git"
BRANCH="master"
APP_DIR="./"
ENV_FILE=".env" # Change this to match your production environment file

# Navigate to the app directory
cd $APP_DIR

# Fetch latest changes from the repository
git fetch origin $BRANCH

# Reset the working directory to the latest commit
git reset --hard origin/$BRANCH

# Install/update dependencies
# composer install --optimize-autoloader --no-dev --no-interaction

# Update database schema and run migrations
php artisan migrate --force

# Generate a new application key
php artisan key:generate --force

# Optimize configuration and clear caches
php artisan config:cache
php artisan route:cache
php artisan optimize

# Update environment file
cp $ENV_FILE .env

# Set file permissions
chmod -R 755 storage
chmod -R 755 bootstrap/cache

# Restart your web server (e.g., Nginx or Apache)
# Replace the following command with the appropriate one for your server
# sudo service nginx restart
