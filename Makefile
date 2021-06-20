start:
	docker-compose --env-file .env up -d

stop:
	docker-compose --env-file .env stop

clean:
	docker-compose --env-file .env down --remove-orphans