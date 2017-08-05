@servers(['web' => 'devin@devserv.devswebdev.com'])


@task('deploy-staging', ['on' => 'web'])
cd /var/www/html/SmallBizAPI/
git pull origin
composer install --no-dev
php artisan cache:clear
@endtask
