@servers(['web' => 'root@devserv.devswebdev.com'])

@story('deploy-staging')
    git
    composer
@endstory

@task('deploy-staging', ['on' => 'web'])
cd /var/www/html/SmallBizAPI/
git pull origin
composer install --no-dev
php artisan cache:clear
@endtask
