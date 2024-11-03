#!/bin/sh

set -e  # Stop the script if any command fails

# Installer les dépendances Node.js avec npm
echo "Installing Node.js dependencies..."
npm install

# Effectuer la construction front-end
echo "Building assets..."
npm run build

# Ajouter le chemin de Composer à la variable PATH
export PATH="$PATH:/usr/local/bin"

# Installer les dépendances PHP avec Composer
echo "Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

echo "Creating database..."
php bin/console doctrine:database:create --if-not-exists

echo "Running migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "Loading fixtures..."
php bin/console doctrine:fixtures:load --no-interaction

echo "Database initialization and build complete."