FROM php:8.4-fpm-alpine

# Установка системных зависимостей
RUN apk add --no-cache \
    unzip \
    bash \
    curl \
    git \
    libpng-dev \
    libwebp-dev \
    libjpeg-turbo-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    oniguruma-dev \
    freetype-dev \
    linux-headers \
    postgresql-dev \
    $PHPIZE_DEPS

# Установка PHP расширений (ДОБАВЛЕН posix для proc_open)
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp && \
    docker-php-ext-install \
    pdo_mysql \
    pdo_pgsql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip \
    opcache \
    sockets \
    intl \
    posix  # ← ВАЖНО: добавлено для proc_open

# Установка Redis extension
RUN pecl install redis && docker-php-ext-enable redis

# Установка Xdebug для разработки (опционально)
ARG INSTALL_XDEBUG=false
RUN if [ ${INSTALL_XDEBUG} = true ]; then \
    apk add --no-cache $PHPIZE_DEPS && \
    pecl install xdebug && \
    docker-php-ext-enable xdebug && \
    echo "xdebug.mode=develop,debug" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.client_host=host.docker.internal" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.start_with_request=yes" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini; \
fi

# Настройка пользователя (безопасность)
RUN addgroup -g 1000 -S www && \
    adduser -u 1000 -S -D -G www www

# Создание директорий для логов и Laravel (исправлены дублирования)
RUN mkdir -p /var/log/php-fpm && \
    mkdir -p /var/www/html/storage && \
    mkdir -p /var/www/html/bootstrap/cache && \
    chown -R www:www /var/log/php-fpm /var/www/html/storage /var/www/html/bootstrap/cache

# Копирование конфигураций (ИСПРАВЛЕН путь для www.conf)
COPY ./_docker/php/php.ini /usr/local/etc/php/conf.d/zz-custom.ini
COPY ./_docker/php/www.conf /usr/local/etc/php-fpm.d/zz-www.conf  

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка прав
RUN chown -R www:www /var/www/html && \
    find /var/www/html -type f -exec chmod 644 {} \; && \
    find /var/www/html -type d -exec chmod 755 {} \; && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Рабочая директория
WORKDIR /var/www/html

# Переключение на пользователя www
USER www

# Команда по умолчанию
CMD ["php-fpm", "-F"]