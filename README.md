# Introduction
Le projet DNT4 est une Mise en Situation Professionnel Reconstitué. 
## Contexte 
La ville de Paris souhaite partager plus largement les données récolter par les anciennes solutions informatiques en exportant ces données sur la plateforme OpenData française. Les données en entrées sont sous format csv et l’export doit être compatible avec l’API d’OpenData.
# Installation
## Avec Docker
Prérequis : Docker et docker-compose

Dans un terminal à la racine du projet :
```
docker-compose up -d
```

## En local
Prérequis : php 7, mysql, Compose CLI ou Composer.phar

A la racine du projet, créer le fichier .env.local
```
echo "DATABASE_URL=mysql://epsi:epsimysql@127.0.0.1:3306/epsi?serverVersion=8.0" > .env.local
```
Sur mysql en localhost, il faut avoir :
- un utilisateur epsi avec comme mot de passe epsimysl
- une base de données portant le nom epsi

Installer les paquets avec Compose :
```
php composer install
```
Remplir la base de données avec la structure des tables :
```
php bin/console doctrine:schema:update -f
```
Enfin lancer le serveur :
```
symfony server:start
```