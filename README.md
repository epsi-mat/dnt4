# Introduction
Le projet DNT4 est une Mise en Situation Professionnel Reconstitué.
# Installation
## Avec Docker
Prérequis : Docker et docker-compose

Dans un terminal à la racine du projet :
```
echo -e "DATABASE_URL=mysql://epsi:epsimysql@mysql:3306/epsi" > .env.local

docker-compose up

docker-compose exec php composer install

docker-compose exec php php bin/console doctrine:schema:create
```

## En local
Prérequis : php 7, mysql, Compose CLI ou Composer.phar