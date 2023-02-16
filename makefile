start-dev:
	docker-compose -f docker-compose.dev.yaml up --build -d

composer-igonre-platform:
	composer install --ignore-platform-reqs

dump-autoload:
	composer dump-autoload


# пример
#load:
#	docker-compose -f docker-compose.dev.yaml up --env-file .env.local --build -d