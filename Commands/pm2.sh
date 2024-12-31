pm2 start dist/index.js --name "socket-server-notify" --log log/socket-server-notify.log --time

pm2 start ecosystem.config.json

pm2 start dist/main.js --name "websocket-server-terminals"
