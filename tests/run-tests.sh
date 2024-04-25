#!/bin/bash
docker exec -i secret-friend-app chmod -R 777 storage storage/logs
docker exec -i secret-friend-app php artisan optimize --env=testing
docker exec -i secret-friend-app php artisan key:generate --env=testing
docker exec -i secret-friend-app chmod -R 777 storage bootstrap/cache
docker exec -i secret-friend-app composer dump
docker exec -i secret-friend-app php artisan migrate:fresh --seed --force --env=testing
if [ -z "$1" ]
then
    docker exec -i secret-friend-app php artisan test --env=testing
else
    docker exec -i secret-friend-app php artisan test --env=testing --filter=$1
fi