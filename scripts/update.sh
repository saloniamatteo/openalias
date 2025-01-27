#!/bin/sh
# Run this script when (git) pulling from this repo

# Check where we are run and cd accordingly
dir=$(pwd)
[[ $(basename $dir) == "scripts" ]] && cd ..

# Install deps
composer install
npm i

# Clear cache & Regenerate key
php artisan optimize:clear
php artisan key:generate --force

# Build & cache assets
npm run build
composer cache
