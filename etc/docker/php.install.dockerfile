FROM uniben/php

# Install Laravel
RUN composer create-project --prefer-dist laravel/laravel .
