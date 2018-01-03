
dev:
	@docker-compose down && \
        	docker-compose build --pull --no-cache && \
        	docker-compose \
            		-f docker-compose.yml \
        	up -d --remove-orphans && \
            $(MAKE) -C code dev
prod:
	@docker-compose down && \
        	docker-compose build --pull --no-cache && \
        	docker-compose \
            		-f docker-compose.yml \
        	up -d --remove-orphans && \
            cd code && composer install  && \
            php code/etc/bin/symfony-console do:mi:mi -v
