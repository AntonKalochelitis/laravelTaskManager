include .env

up:
	sudo docker network create laravel-network || sudo docker-compose \
		--env-file=.env \
		-f docker-compose.yml \
		up -d --build --remove-orphans
