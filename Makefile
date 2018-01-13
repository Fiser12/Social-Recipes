
dev-hard:
	@cp .env.dist .env
		docker-compose down && \
        	docker-compose build --pull --no-cache && \
        	docker-compose \
            		-f docker-compose.yml \
        	up -d --remove-orphans && \
            $(MAKE) -C code/App dev

dev-light:
	@cp -n .env.dist .env
		docker-compose down && \
        	docker-compose \
            		-f docker-compose.yml \
        	up -d --remove-orphans && \
            $(MAKE) -C code/App dev
