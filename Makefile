build:
	docker build -t crypto .
up:
	docker-compose --project-name crypto up -d
	docker-compose --project-name crypto exec php composer install
down:
	docker-compose --project-name crypto down
