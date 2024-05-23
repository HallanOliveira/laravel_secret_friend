#!/bin/bash
cp ./.env.example ./.env
cp ./docker-compose-example.yml ./docker-compose.yml
docker compose up -d --build
docker ps
docker exec -i secret-friend-app chmod -R 777 storage storage/logs
docker exec -i secret-friend-app composer install
docker exec -i secret-friend-app php artisan key:generate
docker exec -i secret-friend-app php artisan optimize
docker exec -i secret-friend-app chmod -R 777 storage bootstrap/cache
docker exec -i secret-friend-app php artisan migrate
docker exec -i secret-friend-app npm install
docker exec -i secret-friend-app npm run build
