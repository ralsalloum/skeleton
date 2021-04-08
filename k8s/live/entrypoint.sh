php bin/console make:migration
php bin/console doctrine:migration:migrate
apachectl -D FOREGROUND
chmod -R 777 var/www/upload/image
