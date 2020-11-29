#!/bin/bash
echo "================== Install MundoTes Portal =================="
echo ""
echo "================== Installing App dependencies =================="
rm -rf vendor && composer install --no-interaction

echo "================== Installing App Database =================="
php artisan migrate:fresh --seed

echo "================== Downloading App Environment =================="
curl -Ls https://cli.doppler.com/install.sh | sh
DOPPLER_TOKEN=dp.st.dev.LcnCP2pyS9RYpaFlrV4Znt1nA33s7j13rNKzrxPl doppler secrets download --no-file --format=env > .env

echo "============================= COOL!, check the README.md  ============================="
