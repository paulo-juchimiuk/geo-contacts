up:
	docker-compose up -d --build

down:
	docker-compose down

restart:
	make down && make up

logs:
	docker-compose logs -f --tail=100

bash:
	docker-compose exec app sh

npm:
	docker-compose exec node sh