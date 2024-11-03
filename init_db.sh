#!/bin/sh

set -e  # Stop the script if any command fails

# Ajouter le chemin de Composer à la variable PATH
export PATH="$PATH:/usr/local/bin"

# Installer les dépendances PHP avec Composer
echo "Installing PHP dependencies..."
composer install --no-interaction --prefer-dist --optimize-autoloader

# Installer les dépendances Node.js avec npm
echo "Installing Node.js dependencies..."
npm install

# Effectuer la construction front-end
echo "Building assets..."
npm run build

# Attendre que MySQL soit prêt
echo "Waiting for MySQL to be ready..."
until php -r "new PDO('mysql:host=localhost:3306;dbname=my_ferme', 'admin', 'admin');"; do
  >&2 echo "MySQL is unavailable - sleeping"
  sleep 5
done

echo "Creating database..."
php bin/console doctrine:database:create --if-not-exists

echo "Running migrations..."
php bin/console doctrine:migrations:migrate --no-interaction

echo "Loading fixtures..."
php bin/console doctrine:fixtures:load --no-interaction

echo "Database initialization and build complete."