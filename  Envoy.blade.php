@servers(['web' => 'devin@devserv.devswebdev.com'])


@task('deploy-staging')
cd /var/www/html/SmallBizAPI/
git pull origin
composer install --no-dev
php artisan cache:clear
@endtask
