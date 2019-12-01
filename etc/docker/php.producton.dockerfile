FROM uniben/php

# Install Laravel
COPY /laravel /src

# Composer install
RUN composer install
