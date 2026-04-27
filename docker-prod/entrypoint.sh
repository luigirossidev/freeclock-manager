#!/bin/sh
set +e

ENV_FILE="/var/www/html/.env"
KEY_FILE="/var/www/html/database/data/.app_key"

# Generate APP_KEY if empty: store in persistent volume
if grep -qE '^APP_KEY=$' "$ENV_FILE" 2>/dev/null; then
    if [ -f "$KEY_FILE" ]; then
        echo "🔑 Loading APP_KEY from previous generation..."
    else
        echo "🔑 APP_KEY is empty, generating a new one..."
        php /var/www/html/artisan key:generate --show > "$KEY_FILE"
    fi
    export APP_KEY=$(cat "$KEY_FILE")
    echo "🔄 Rebuilding cache with new APP_KEY..."
    php /var/www/html/artisan optimize
fi

# Run seeders on first boot if FIRST_SEED=1
FIRST_SEED=$(sed -n 's/^FIRST_SEED=//p' "$ENV_FILE" 2>/dev/null)
SEED_MARKER="/var/www/html/database/data/.seeded"
if [ "$FIRST_SEED" = "1" ] && [ ! -f "$SEED_MARKER" ]; then
    echo "🌱 Running database seeders..."
    php /var/www/html/artisan db:seed --force
    touch "$SEED_MARKER"
    echo "✅ Seeding complete."
fi

exit 0
