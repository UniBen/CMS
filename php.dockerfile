FROM php:7.3-fpm-alpine

# Install dev dependencies
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    curl-dev \
    imagemagick-dev \
    libtool \
    libxml2-dev

# Install production dependencies
RUN apk add --no-cache \
    bash \
    curl \
    jq \
    g++ \
    gcc \
    git \
    imagemagick \
    libc-dev \
    libpng-dev \
    make \
    mysql-client \
    openssh-client \
    zlib-dev \
    libzip-dev

# Install PECL and PEAR extensions
RUN pecl install \
    imagick

# Install and enable php extensions
RUN docker-php-ext-enable \
    imagick

RUN docker-php-ext-configure zip --with-libzip

RUN docker-php-ext-install \
    curl \
    exif \
    iconv \
    mbstring \
    pdo \
    pdo_mysql \
    pcntl \
    tokenizer \
    xml \
    gd \
    zip \
    bcmath

# Composer
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Cleanup dev dependencies
RUN apk del -f .build-deps

# Setup working directory
WORKDIR /src

# Install hirak/prestissimo
RUN composer global require hirak/prestissimo

# Install Laravel
RUN composer create-project --prefer-dist laravel/laravel .

# Update composer.json
RUN echo $(cat '/src/composer.json' | jq '. + {repositories:[{"type":"path","url":"/package","options":{"symlink":true}}]}') > '/src/composer.json' && \
    echo $(cat '/src/composer.json' | jq '.require["uniben/cms"] = "@dev"') > '/src/composer.json' && \
    composer update uniben/cms --prefer-source

