#!/bin/bash
echo "================== Install Portal =================="
echo ""
echo "================== Installing App dependencies =================="
rm -rf vendor && composer install --no-interaction

echo "================== Installing App Database =================="
php artisan migrate:fresh --seed

echo "============================= COOL!, check the README.md  ============================="
