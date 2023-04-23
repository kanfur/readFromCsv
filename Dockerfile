FROM php:8.0-fpm

# Set upload_max_filesize and post_max_size
RUN echo 'upload_max_filesize = 20M' >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo 'post_max_size = 20M' >> /usr/local/etc/php/conf.d/uploads.ini

# Install necessary PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    && docker-php-ext-install pdo_mysql pdo_pgsql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set the working directory
WORKDIR /var/www/html

# Copy the application files to the working directory
COPY . .
# Create the SQLite database file
RUN touch database/database.sqlite

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Install the PHP dependencies
RUN composer install

# Set the appropriate permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache \
    && chown -R www-data:www-data /var/www/html/database/database.sqlite \
    && chmod 664 /var/www/html/database/database.sqlite

# Copy start.sh script
COPY start.sh /usr/local/bin/start.sh
RUN chmod +x /usr/local/bin/start.sh

# cron jobs
RUN apt-get update && apt-get install -y cron

COPY laravel-worker.conf /etc/supervisor/conf.d/

RUN touch /var/log/cron.log
CMD cron && tail -f /var/log/cron.log

COPY crontab /etc/cron.d/crontab
RUN chmod 0644 /etc/cron.d/crontab

# Run crontab
RUN crontab /etc/cron.d/crontab

