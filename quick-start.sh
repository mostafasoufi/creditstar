#!/bin/sh

docker-compose run --rm php composer update --prefer-dist

docker-compose run --rm php composer install

docker-compose up -d

docker-compose run --rm php yii migrate
docker-compose run --rm php tests/bin/yii migrate

curl -sL https://deb.nodesource.com/setup_12.x | bash -
apt-get install nodejs
npm install -g sass

open http://127.0.0.1:8000