#!/bin/bash
# ============================================================
# DEPLOY GESTIONALE FOOD&TECH - da eseguire via SSH
# Presuppone: Composer installato, progetto Laravel creato in
# ~/gestionale_app  e questo file copiato nella sua root
# ============================================================

set -e
APP_DIR=~/gestionale_app
SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"

echo "=== 1. Copia Models ==="
cp -r $SCRIPT_DIR/app/Models/* $APP_DIR/app/Models/

echo "=== 2. Copia Controllers ==="
cp -r $SCRIPT_DIR/app/Http/Controllers/* $APP_DIR/app/Http/Controllers/

echo "=== 3. Copia Views ==="
cp -r $SCRIPT_DIR/resources/views/* $APP_DIR/resources/views/

echo "=== 4. Copia Routes ==="
cp $SCRIPT_DIR/routes/web.php $APP_DIR/routes/web.php

echo "=== 5. Copia Migrations ==="
cp -r $SCRIPT_DIR/database/migrations/* $APP_DIR/database/migrations/

echo "=== 6. Copia Seeders ==="
cp -r $SCRIPT_DIR/database/seeders/* $APP_DIR/database/seeders/

echo "=== 7. Configura .env ==="
cd $APP_DIR
if [ ! -f .env ]; then
    cp .env.example .env
    echo ""
    echo ">>> Edita $APP_DIR/.env con:"
    echo "    APP_NAME='Gestionale Food&Tech'"
    echo "    APP_URL=https://gestionale.foodandtech.company"
    echo "    DB_DATABASE=..., DB_USERNAME=..., DB_PASSWORD=..."
    echo "    Premi INVIO quando hai finito..."
    read
fi

echo "=== 8. Genera chiave app ==="
sp-php artisan key:generate

echo "=== 9. Esegui migrations ==="
sp-php artisan migrate

echo "=== 10. Esegui seeders ==="
cp ~/domini_attivi.csv $APP_DIR/../domains_import.csv 2>/dev/null || true
sp-php artisan db:seed

echo "=== 11. Crea utente admin ==="
sp-php artisan tinker --execute="
\App\Models\User::create([
    'nome'     => 'Renato',
    'email'    => 'info@foodandtech.company',
    'password' => bcrypt('cambia_questa_password'),
    'ruolo'    => 'admin',
    'attivo'   => true,
]);
echo 'Utente creato.';
"

echo "=== 12. Permessi storage ==="
chmod -R 775 storage bootstrap/cache

echo "=== 13. Ottimizza per produzione ==="
sp-php artisan config:cache
sp-php artisan route:cache
sp-php artisan view:cache

echo ""
echo "✅ Deploy completato!"
echo "   URL: https://gestionale.foodandtech.company"
echo "   Login: info@foodandtech.company"
echo "   Password: cambia_questa_password  ← CAMBIA SUBITO!"
