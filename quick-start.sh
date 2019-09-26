#!/bin/sh

docker-compose run --rm php composer update --prefer-dist

docker-compose run --rm php composer install

docker-compose up -d

docker-compose run --rm php yii migrate
docker-compose run --rm php tests/bin/yii migrate

open http://127.0.0.1:8000