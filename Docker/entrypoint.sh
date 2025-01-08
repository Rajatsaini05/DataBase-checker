#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    echo -e "\tRunning composer install..."
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo -e "\tCreating .env file..."
    cp .env.example .env
else
    echo -e "\t.env file already exists."
fi

if [ -d "vendor/laravel/octane" ]; then
    echo -e "\tInstalling Octane..."
    /usr/local/bin/php artisan octane:install --server=swoole  || { echo "Failed to install Octane"; exit 1; }
else
    composer require laravel/octane
fi

# php artisan SWOOLE_SERVER:octane
# php artisan migrate
# echo -e "\tMigration Applied Successfully..."
# php artisan cache:clear
# php artisan config:clear
# php artisan route:clear
# php artisan key:generate

#run queues.
php artisan queue:listen --queue=InsertRelatedCities &
php artisan queue:listen --queue=InvitationLogin &

php artisan octane:start --port="80" --host=0.0.0.0
