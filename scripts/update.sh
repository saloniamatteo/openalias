#!/bin/sh
# Run this script when (git) pulling from this repo

# Check where we are run and cd accordingly
dir=$(pwd)
[[ $(basename $dir) == "scripts" ]] && cd ..

# Install deps
composer update
npm update

# Fix any security issues
npm audit fix

# Clear cache & Regenerate key
php artisan optimize:clear
php artisan key:generate --force

# Build & cache assets
npm run build
composer cache
