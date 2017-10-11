# Laravel Echo Server - Chat example

Just to build own simple laravel echo server example. Hosted on one server and "for free".

**NOTICE:** This was just a quick POC to test around and have a working sample.

## Setup

## Prerequisites

- Redis https://redis.io/
- Laravel Echo server https://github.com/tlaverdure/laravel-echo-server
- NGINX  https://www.nginx.com/resources/wiki/

### NGINX
You need to configure a proxy host for laravel-echo-server to run it on  the same server.

I've created a second host in laravel forge under `ws.live.mighty-code.com`, remove all php relevant directives.
Add proxy config to NGINX Host config:

```
# FORGE CONFIG (DOT NOT REMOVE!)
include forge-conf/youredomain/server/*;

server {
        // ...
        
        charset utf-8;

        # FORGE CONFIG (DOT NOT REMOVE!)
        include forge-conf/ws.live.mighty-code.com/server/*;

        location / {
        proxy_pass http://127.0.0.1:6001;
        proxy_http_version 1.1;
        proxy_set_header Upgrade $http_upgrade;
        proxy_set_header Connection "upgrade";
        proxy_set_header Host $host;
        proxy_cache_bypass $http_upgrade;
        }

        location = /favicon.ico { access_log off; log_not_found off; }
        location = /robots.txt  { access_log off; log_not_found off; }

        access_log off;
        error_log  /var/log/nginx/ws.live.mighty-code.com-error.log error;

        location ~ /\.(?!well-known).* {
        deny all;
}
```
Special thanks to [Manuel](https://twitter.com/strebel_manuel) for the support.

### App

Install as new Project
```
composer create-project --prefer-dist okaufmann/laravel-web-money-manager-ex .
```

Copy .env.example to .env
```
cp .env.example .env
```

Install composer dependencies

```
composer install
```

Install npm dependencies using yarn and compile assets

```
yarn && yarn run dev
```

Start laravel-echo-server as daemon with pm2:

```commandline
npm install -g pm2
pm2 start host.json
```

Setup values in .env file
```
PUSHER_HOST=localhost
PUSHER_PORT=6001
PUSHER_ENCRYPTED=false
```

Change values in `laravel-echo-server.json` to match your environment

```json
{
    // ...
    "authHost": "https://live.mighty-code.com"
    // ...
}
```

## Demo

See it in Action: https://live.mighty-code.com/. Data will be reset every 30 minutes.
