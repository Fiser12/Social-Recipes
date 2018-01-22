DIR ?= App
ENV ?= dev
IMAGE ?= app
COMMAND ?= debug:container
.DEFAULT_GOAL := start

#COMPOSER COMMANDS
composer-install:
	@docker-compose -f docker-compose.$(ENV).yml exec $(IMAGE) bash -c "composer install -d=/app/$(DIR)"

composer-update:
	@docker-compose -f docker-compose.$(ENV).yml exec $(IMAGE) bash -c "composer update -d=/app/$(DIR)"

#SYMFONY COMMANDS
create-database:
	@docker-compose -f docker-compose.$(ENV).yml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console doctrine:database:create --if-not-exists"

migrations:
	@docker-compose -f docker-compose.$(ENV).yml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console do:mi:mi -v --no-interaction"

cache-clear:
	@docker-compose -f docker-compose.$(ENV).yml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console cache:clear -e $(ENV)"

symfony-console:
	@docker-compose -f docker-compose.$(ENV).yml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console $(COMMAND)"

#DOCKER COMMANDS
docker-compose-exec:
	@docker-compose -f docker-compose.$(ENV).yml exec $(IMAGE) bash -c "$(COMMAND)"

stop:
	@docker-compose -f docker-compose.$(ENV).yml down

start:
	@docker-compose down && \
        	docker-compose \
            		-f docker-compose.$(ENV).yml  \
        	up -d --remove-orphans

deploy:
	@rsync --ignore-existing .env.dist .env
	        docker-compose -f docker-compose.$(ENV).yml down && \
        	docker-compose -f docker-compose.$(ENV).yml build --pull --no-cache && \
        	docker-compose -f docker-compose.$(ENV).yml up -d --remove-orphans && \
            docker-compose -f docker-compose.$(ENV).yml exec $(IMAGE) bash -c "composer install -d=/app/App" && \
            docker-compose -f docker-compose.$(ENV).yml exec $(IMAGE) bash -c "php /app/App/etc/bin/symfony-console doctrine:database:create --if-not-exists" && \
            docker-compose -f docker-compose.$(ENV).yml exec $(IMAGE) bash -c "php /app/App/etc/bin/symfony-console do:mi:mi -v --no-interaction"

