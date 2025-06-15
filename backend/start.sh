#!/bin/bash

# Wait for the database to be ready
echo "Waiting for PostgreSQL to be available..."
until php artisan migrate --force; do
  >&2 echo "Database is unavailable - sleeping"
  sleep 3
done

# Serve Laravel
php artisan serve --host=0.0.0.0 --port=8000
