# orlik-api

## Docker

#### Prerequisites:
You need to have installed:
* docker https://docs.docker.com/engine/install/
* docker-compose https://docs.docker.com/compose/install/

To setup project on docker simply run in terminal:

```shell script
cp docker-compose-dev.yaml docker-compose.yaml
docker-compose up
```

The app is now up and running, just type http://localhost in browser and have fun!

In case of permissions problem to var/log directory, simply run
```shell script
sudo chmod -R 777 var
```
It is perfectly safe to do that in dev environment ;)