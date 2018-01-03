
dev:
	@docker-compose down && \
        	docker-compose build --pull --no-cache && \
        	docker-compose \
            		-f docker-compose.yml \
        	up -d --remove-orphans && \
            composer install  && \
            php etc/bin/symfony-console doctrine:database:create --if-not-exists && \
            php etc/bin/symfony-console do:mi:mi -v
prod:
	@docker-compose down && \
        	docker-compose build --pull --no-cache && \
        	docker-compose \
            		-f docker-compose.yml \
        	up -d --remove-orphans && \
            composer install  && \
            php etc/bin/symfony-console do:mi:mi -v
