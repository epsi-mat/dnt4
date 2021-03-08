# Introduction
Le projet DNT4 est une Mise en Situation Professionnel Reconstitué. 
## Contexte 
La ville de Paris souhaite partager plus largement les données récolter par les anciennes solutions informatiques en exportant ces données sur la plateforme OpenData française. Les données en entrées sont sous format csv et l’export doit être compatible avec l’API d’OpenData.
# Installation
## Avec Docker
Prérequis : Docker et docker-compose

Dans un terminal à la racine du projet (utiliser winpty avec git bash) :
```
cp .env.example .env

docker-compose up -d

docker-compose exec php composer install

docker-compose exec php php bin/console doctrine:schema:create
```

## En local
Prérequis : php 7, mysql, Compose CLI ou Composer.phar

A la racine du projet, créer le fichier .env
```
cp .env.example .env
```
Sur mysql en localhost, il faut avoir :
- un utilisateur epsi avec comme mot de passe epsimysl
- une base de données portant le nom epsi

Installer les paquets avec Compose :
```
php composer install
composer require migrations
```
Remplir la base de données :
```
php bin/console doctrine:schema:create
```