# Laravel Echo Server - Chat example

Just to build own simple laravel echo server example. Hosted on one server and "for free".

## Setup

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

Change values in `laravel-echo-server.json`

```json
{
    "authHost": "http://live.dev",
	"authEndpoint": "/broadcasting/auth"
}
```

## Demo

See it in Action: https://live.mighty-code.com/
