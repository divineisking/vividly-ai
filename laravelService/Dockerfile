# Use PHP 8.2 FPM as base image
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    curl \
    zip \
    unzip \
    git \
    inotify-tools\
    nodejs\
    npm \
    && rm -rf /var/lib/apt/lists/*

# Now install PHP extensions separately using docker-php-ext-install
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel BEFORE setting WORKDIR
RUN composer create-project --prefer-dist laravel/laravel /var/www/html

# Set the working directory AFTER Laravel installation
WORKDIR /var/www/html/

# Ensure storage and cache directories exist
RUN mkdir -p storage bootstrap/cache && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Create a non-root user (optional but recommended)
RUN useradd -G www-data,root -u 1000 -d /home/laravel laravel && \
    mkdir -p /home/laravel/.composer

# Set up entrypoint
COPY ./entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

# Expose ports: 8000 for Laravel and 5173 for Vite's HMR
EXPOSE 8000 5173

# Start the Laravel application
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
