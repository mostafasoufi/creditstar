## Setup

Install Docker https://www.docker.com/get-started

Update your vendor packages

    docker-compose run --rm php composer update --prefer-dist
    
Run the installation triggers

    docker-compose run --rm php composer install    
    
Start the container

    docker-compose up -d
    
Run database migration (creating tables)

    docker-compose run --rm php yii migrate    
    docker-compose run --rm php tests/bin/yii migrate    
        
You can then access the application through the following URL:

    http://127.0.0.1:8000
    

## Importer Command

Import the json file into database which select file and model.

    yii import --loan=loans.json --user=users.json


## Compile SASS

If you want to compile the SASS, you should install the `sass` command in your running container.

    docker exec -it creditstar_php_1 bash

Then run the below commands for install the `node` and `npm`.
    
    curl -sL https://deb.nodesource.com/setup_12.x | bash -
    apt-get install nodejs
    npm install -g sass


## Running Tests

To run the unit tests, execute the following command:

    docker-compose run --rm php codecept run
