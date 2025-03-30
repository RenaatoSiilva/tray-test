#!/bin/sh

echo "Aguardando o banco de dados..."

sleep 10

php artisan migrate --force
php artisan db:seed --force

php artisan test

php artisan schedule:work &
php artisan queue:work --queue=recovery_password,commissions_report,commissions_report_daily,sales_admin_report &

exec "$@"
