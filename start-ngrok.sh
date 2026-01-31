#!/bin/bash

echo "🚀 Starting Laravel + Ngrok..."
echo ""

# Start Laravel in background
php artisan serve &
LARAVEL_PID=$!
echo "✅ Laravel started (PID: $LARAVEL_PID)"

# Wait for Laravel to start
sleep 3

# Start ngrok and capture URL
echo "🌐 Starting ngrok..."
ngrok http 8000 > /dev/null &
NGROK_PID=$!

# Wait for ngrok to start
sleep 3

# Get ngrok URL
NGROK_URL=$(curl -s http://localhost:4040/api/tunnels | grep -o '"public_url":"https://[^"]*' | grep -o 'https://[^"]*' | head -1)

echo "✅ Ngrok started (PID: $NGROK_PID)"
echo ""
echo "📋 Your ngrok URL: $NGROK_URL"
echo ""
echo "⚠️  UPDATE YOUR .env FILE:"
echo "   APP_URL=$NGROK_URL"
echo "   ASSET_URL=$NGROK_URL"
echo ""
echo "Then run: php artisan config:clear"
echo ""
echo "Press Ctrl+C to stop both services"

# Wait for Ctrl+C
trap "kill $LARAVEL_PID $NGROK_PID; exit" INT
wait