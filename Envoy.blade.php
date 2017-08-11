@servers(['web' => 'root@devserv.devswebdev.com'])

@story('deploy')
    git
    composer
@endstory

@task('deploy-staging', ['on' => 'web'])
cd /var/www/html/SmallBizAPI/
git pull origin
php artisan cache:clear
rm -rf vendor/
composer install
composer dump-autoload
@endtask
