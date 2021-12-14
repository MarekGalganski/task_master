# Prerequisities

Install latest docker engine along with docker-compose as described on the docker hub:
https://docs.docker.com/engine/install/
https://docs.docker.com/compose/install/

# Installation

In order to launch this project run the following commands:

```
cp application/.env.example application/.env
docker-compose up -d
docker-compose exec app composer i -o
```

Then you should be ready to start. This project is a basic Laravel project with docker-compose setup that allows you to immediately start working. The app works by itself at `http://localhost:8000` port.

Good luck!

