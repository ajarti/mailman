FROM php:7.2-fpm

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    mariadb-client \
    locales \
    vim \
    git \
    curl \
    supervisor \
    && apt-get clean && rm -rf /var/lib/apt/lists/* \
    && docker-php-ext-install pdo_mysql mbstring pcntl
# Clear cache
#RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install extensions
#RUN docker-php-ext-install pdo_mysql mbstring pcntl

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

