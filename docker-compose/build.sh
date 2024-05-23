#!/bin/bash
docker compose up -d --build
docker exec -i secret-friend-app composer install
docker exec -i secret-friend-app php artisan key:generate
docker exec -i secret-friend-app php artisan optimize
docker exec -i secret-friend-app npm install
docker exec -i secret-friend-app npm run build
