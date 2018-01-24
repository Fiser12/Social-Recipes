DIR ?= App
ENV ?= dev
IMAGE ?= app
COMMAND ?= debug:container
.DEFAULT_GOAL := start
THIS_FILE := $(lastword $(MAKEFILE_LIST))

ENV_COMPOSER = dev

ifeq ($(ENV),prod)
 ENV_COMPOSER = no-dev
endif

#COMPOSER COMMANDS
composer-install:
	docker-compose -f docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "composer install -d=/app/$(DIR) --$(ENV_COMPOSER)"

composer-update:
	@docker-compose -f docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "composer update -d=/app/$(DIR) --$(ENV_COMPOSER)"

#SYMFONY COMMANDS
create-database:
	@docker-compose -f docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console doctrine:database:create --if-not-exists"

migrations:
	@docker-compose -f docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console do:mi:mi -v --no-interaction"

cache-clear:
	@docker-compose -f docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console cache:clear -e $(ENV)"

vendor-clear:
	@rm -rf code/$(DIR)/vendor

symfony-console:
	@docker-compose -f docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console $(COMMAND)"

#DOCKER COMMANDS
docker-compose-exec:
	@docker-compose -f docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "$(COMMAND)"

stop:
	@docker-compose -f docker-compose.$(ENV).yaml down

start:
	@docker-compose -f docker-compose.$(ENV).yaml down && \
        	docker-compose -f docker-compose.$(ENV).yaml up -d --remove-orphans

deploy:
	@rsync --ignore-existing .env.dist .env
	        docker-compose -f docker-compose.$(ENV).yaml down && \
        	$(MAKE) -f $(THIS_FILE) vendor-clear && \
        	docker-compose -f docker-compose.$(ENV).yaml build --pull --no-cache && \
        	docker-compose -f docker-compose.$(ENV).yaml up -d --remove-orphans && \
        	$(MAKE) -f $(THIS_FILE) composer-install ENV=$(ENV) && \
        	$(MAKE) -f $(THIS_FILE) create-database ENV=$(ENV) && \
        	$(MAKE) -f $(THIS_FILE) migrations ENV=$(ENV)
