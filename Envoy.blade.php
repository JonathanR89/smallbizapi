@servers(['web' => 'root@devserv.devswebdev.com' , 'production' => 'smallbiz@smallbizcrm.com'])

@story('deploy')
    git
    composer
@endstory

@task('deploy-staging', ['on' => 'web'])
  cd /var/www/html/SmallBizAPI/
  git stash
  git pull origin
  {{-- git sta --}}
  php artisan cache:clear
  composer clear-cache
  composer dump-autoload
  {{-- rm -rf vendor/ --}}
  composer install
  composer update
  {{-- rm -rf node_modules/ --}}
  npm install
  php artisan migrate
  php artisan queue:restart
@endtask

@task('deploy-production', ['on' => 'production'])
  cd /home/smallbiz/public_html/packagemanager
  ls
  {{-- git stash --}}
  git pull origin master
  php composer.phar self-update
  {{-- php composer.phar update --}}
  {{-- php artisan cache:clear
  php composer.phar clear-cache --}}
  php composer.phar dump-autoload
  {{-- rm -rf vendor/ --}}
  php composer.phar install
  {{-- php composer.phar update --}}
  php artisan migrate --force
  php artisan queue:restart
  php artisan queue:work --daemon
@endtask
