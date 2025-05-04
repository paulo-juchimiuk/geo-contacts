#!/bin/bash

set -e

echo "Iniciando backend (entrypoint.sh)..."

if [ ! -d "vendor" ]; then
    echo "Instalando dependências do Composer..."
    composer install
fi

if [ ! -f ".env" ]; then
    cp .env.example .env
fi

echo "Gerando APP KEY..."
php artisan key:generate

echo "Aguardando o banco de dados ficar pronto..."

until php artisan migrate --pretend --force > /dev/null 2>&1
do
  echo "Banco ainda não está pronto... aguardando 3 segundos..."
  sleep 3
done

echo "Migrando banco de dados..."
php artisan migrate --force

php artisan config:cache
php artisan route:cache

echo "Backend pronto, iniciando PHP-FPM..."
exec php-fpm
