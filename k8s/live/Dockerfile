FROM php:7.4-fpm AS vendor
WORKDIR /tmp/
COPY composer.json composer.json
COPY composer.lock composer.lock
RUN apt update -y && apt install zip -y && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install && composer update 
RUN composer require symfony/translation && composer require doctrine/annotations && composer require symfony/orm-pack && composer require nelmio/cors-bundle
FROM php:7.4-apache
RUN apt update -y && apt install zip -y && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN apt-get update && apt-get install -y build-essential libssl-dev zlib1g-dev libpng-dev libjpeg-dev libfreetype6-dev
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY . /var/www/html
COPY --from=gcr.io/pc-api-6479467557629758909-343/skelsec ./.env /var/www/html
COPY --from=gcr.io/pc-api-6479467557629758909-343/skelsec ./.htaccess /var/www/html/public
COPY --from=gcr.io/pc-api-6479467557629758909-343/skelsec ./jwt/ /var/www/html/config/jwt
RUN chown -R www-data:www-data /var && chmod -R g+rw /var
COPY --from=vendor /tmp/vendor/ /var/www/html/vendor/
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-configure gd && docker-php-ext-install gd
#RUN composer require symfony/orm-pack &&  composer require --dev symfony/maker-bundle
RUN php bin/console cach:clear
RUN chmod  +x ./entrypoint.sh 
CMD ["./entrypoint.sh"]
