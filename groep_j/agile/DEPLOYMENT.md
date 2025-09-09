# Deployment script
## env
 - `APP_LOCALE=nl` zorgt ervoor dat de website in het Nederlands is
 - `APP_TIMEZONE=CET` zorgt ervoor dat de tijd correct wordt weergegeven en wordt opgeslagen
 - `APP_URL=https://svconcat.coloss.dev` zorgt ervoor dat de website op de juiste url draait
 - `DEBUGBAR_ENABLED=false` zorgt ervoor dat de debugbar niet zichtbaar is in de productie omgeving
 - `APP_NAME=SVConcat` zorgt ervoor dat de naam van de website correct is

## deployment commands
### Clear all cached data
php artisan optimize:clear
### Install production dependencies and optimize autoloader
composer install 
### Install and build frontend assets
npm ci
npm run build
### Generate caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
### Run database migrations (if any)
php artisan migrate --force

##### Seed the database (if any)
php artisan db:seed --force

### Clear and cache application data
php artisan optimize
