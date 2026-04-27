FROM ghcr.io/serversideup/php:8.4-fpm-apache

# Switch to root so we can do root things
USER root

# Install the intl extension with root permissions
RUN install-php-extensions intl mbstring zip gd bcmath

# Node.js
RUN apt-get update \
    && apt-get install -y ca-certificates curl gnupg \
    && mkdir -p /etc/apt/keyrings \
    && curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg \
    && echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_20.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list \
    && echo "Package: nodejs" >> /etc/apt/preferences.d/preferences \
    && echo "Pin: origin deb.nodesource.com" >> /etc/apt/preferences.d/preferences \
    && echo "Pin-Priority: 1001" >> /etc/apt/preferences.d/preferences\
    && apt-get update \
    && apt-get install -y nodejs

COPY --chmod=755 docker-prod/entrypoint.sh /etc/entrypoint.d/generate-app-key.sh

USER www-data

COPY --chown=www-data:www-data . /var/www/html

RUN composer install --optimize-autoloader --no-dev --no-interaction --no-progress --ansi

# Vite stuff
RUN npm install
RUN npm run build



