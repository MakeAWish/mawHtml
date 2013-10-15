php app/console doctrine:database:drop --force;
php app/console doctrine:database:create;
php app/console doctrine:schema:update --force;
php app/console wl:fixtures:load;
php app/console wl:fakers:load;

php app/console fos:user:promote boris SUPER_ADMIN
php app/console fos:user:promote helene SUPER_ADMIN