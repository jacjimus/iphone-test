How to install the App

__Clone the repository to web root__

__cd name_of_repo__

__Copy .env.example to .env__

__composer install__ 

__php artisan key:generate__

__php artisan migrate --seed__ 

__php artisan db:seed --class=AchievementsSeeder BadgeSeeder__

