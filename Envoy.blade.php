@servers(['web' => 'root@devserv.devswebdev.com'])

@story('deploy')
    git
    composer
@endstory

@task('deploy-staging', ['on' => 'web'])
cd /var/www/html/SmallBizAPI/
git pull origin
php artisan cache:clear
composer clear-cache
composer dump-autoload
rm -rf vendor/
composer install
composer update
rm -rf node_modules/
npm install
php artisan migrate
@endtask
