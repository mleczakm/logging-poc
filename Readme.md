# POC logging with Filebeats and ELK Stack
### Using autodiscovery and Traefik v2 for routing

## Setting up

You will need working docker and docker-compose/docker compose V2 (https://docs.docker.com/compose/cli-command/).
All you need to do is:
```shell
docker compose run php composer install
docker compose --profile debug up -d
```
## Application visibility

App is available under address http://poc.localhost/, routed by traefik.
Traefik dashboard is available under http://localhost:8080 


## Load testing

Set up proper index on http://kibana-poc.localhost (`*` or `logstash-fileabeat`) and run load tests:
```shell
docker compose up taurus
```

You should be later able to discover logs under http://kibana-poc.localhost/app/discover.