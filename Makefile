current_directory := $(shell pwd)
include $(current_directory)/.env

DOCKER_COMPOSE = sudo docker-compose -f $(current_directory)/docker-compose.yml --env-file=$(current_directory)/.env

up:
	${DOCKER_COMPOSE} up -d --build --remove-orphans

network_up:
	sudo docker network create laravel-network

build:
	${DOCKER_COMPOSE} build

start:
	${DOCKER_COMPOSE} start

stop:
	${DOCKER_COMPOSE} stop

rm:
	${DOCKER_COMPOSE} rm

restart: stop start
