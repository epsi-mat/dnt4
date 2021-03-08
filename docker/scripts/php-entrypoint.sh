#!/bin/sh
composer install
php bin/console doctrine:schema:create