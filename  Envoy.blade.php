@servers(['web' => 'root@devserv.devswebdev.com'])


@task('deploy-staging', ['on' => 'SmallBizAPI'])
cd /var/www/html/SmallBizAPI/
git pull origin
composer install --no-dev
php artisan cache:clear
@endtask
