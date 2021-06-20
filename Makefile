start:
	docker-compose up -d

stop:
	docker-compose stop

clean:
	docker-compose down --remove-orphans

ssh:
	docker-compose exec -u application app bash

phpunit:
	docker-compose exec -u application app bash -c "php /app/bin/phpunit /app/tests"