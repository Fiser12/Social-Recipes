
dev-hard:
	@cp .env.dist .env
		docker-compose down && \
        	docker-compose build --pull --no-cache && \
        	docker-compose \
            		-f docker-compose.yml \
        	up -d --remove-orphans && \
            docker-compose exec app bash -c "composer install -d=/app/App" && \
            docker-compose exec app bash -c "php /app/App/etc/bin/symfony-console doctrine:database:create --if-not-exists" && \
            docker-compose exec app bash -c "php /app/App/etc/bin/symfony-console do:mi:mi -v --no-interaction"