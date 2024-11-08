# Choisir une image de base avec PHP 8.1
FROM php:8.1-cli

# Installer les dépendances nécessaires, Supervisor et Node.js
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    supervisor \
    libicu-dev \
    curl \
    && docker-php-ext-install pdo pdo_mysql intl \
    && docker-php-ext-enable intl \
    && curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest  # Installer la dernière version de npm

# Augmenter la limite de mémoire PHP
RUN echo "memory_limit = 512M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Installer Composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php -r "if (hash_file('sha384', 'composer-setup.php') === 'dac665fdc30fdd8ec78b38b9800061b4150413ff2e3b6f88543c636f7cd84f6db9189d43a81e5503cda447da73c7e5b6') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && php -r "unlink('composer-setup.php');"

# Définir le dossier de travail
WORKDIR /app
RUN git config --global --add safe.directory /app

# Copier le contenu de votre application dans le conteneur
COPY . .

# Installer les dépendances npm et construire le projet

# Copier le script d'initialisation
COPY init_db.sh /usr/local/bin/init_db.sh
RUN chmod +x /usr/local/bin/init_db.sh

# Configuration Supervisor
COPY supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Exposer le port 8000
EXPOSE 8000

# Lancer Supervisor comme processus principal
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

RUN npm install
RUN npm run build