composer install
cp ./.env.example ./.env
mysql -hdb -uroot -padmin -e "CREATE DATABASE laravel_blog COLLATE 'utf8_unicode_ci';"
mysql -hdb -uroot -padmin -e "CREATE DATABASE laravel_blog_testing COLLATE 'utf8_unicode_ci';"
php artisan migrate
composer dump-autoload
php artisan db:seed
php artisan db:seed --class=UsersTableSeeder