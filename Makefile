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
	docker-compose -f Docker/docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "composer install -d=/app/$(DIR) --$(ENV_COMPOSER)"

composer-update:
	@docker-compose -f Docker/docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "composer update -d=/app/$(DIR) --$(ENV_COMPOSER)"

#SYMFONY COMMANDS
create-database:
	@docker-compose -f Docker/docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console doctrine:database:create --if-not-exists"

migrations:
	@docker-compose -f Docker/docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console do:mi:mi -v --no-interaction"

cache-clear:
	@docker-compose -f Docker/docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console cache:clear -e $(ENV)"

yarn-install:
	@docker-compose -f Docker/docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "cd /app/CompositeUi/src/Infrastructure/Ui/Assets && yarn install && yarn build"


vendor-clear:
	@rm -rf $(DIR)/vendor

symfony-console:
	@docker-compose -f Docker/docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "php /app/$(DIR)/etc/bin/symfony-console $(COMMAND)"

#DOCKER COMMANDS
docker-compose-exec:
	@docker-compose -f Docker/docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "$(COMMAND)"

stop:
	@docker-compose -f Docker/docker-compose.$(ENV).yaml down

start:
	@docker-compose -f Docker/docker-compose.$(ENV).yaml down && \
        	docker-compose -f Docker/docker-compose.$(ENV).yaml up -d --remove-orphans

start-hard:
	@rsync --ignore-existing Docker/.env.dist Docker/.env
	        docker-compose -f Docker/docker-compose.$(ENV).yaml down && \
            docker-compose -f Docker/docker-compose.$(ENV).yaml up -d --remove-orphans && \
            $(MAKE) -f $(THIS_FILE) composer-install-all ENV=$(ENV) && \
            $(MAKE) -f $(THIS_FILE) create-database ENV=$(ENV) && \
            $(MAKE) -f $(THIS_FILE) migrations ENV=$(ENV)

deploy:
	@rsync --ignore-existing Docker/.env.dist Docker/.env
	        docker-compose -f Docker/docker-compose.$(ENV).yaml down && \
            $(MAKE) -f $(THIS_FILE) clear-all ENV=$(ENV) && \
        	docker-compose -f Docker/docker-compose.$(ENV).yaml build --pull --no-cache && \
            docker-compose -f Docker/docker-compose.$(ENV).yaml up -d --remove-orphans && \
            $(MAKE) -f $(THIS_FILE) composer-install-all ENV=$(ENV) && \
            $(MAKE) -f $(THIS_FILE) create-database ENV=$(ENV) && \
            $(MAKE) -f $(THIS_FILE) migrations ENV=$(ENV)

composer-install-all:
	@docker-compose -f Docker/docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "composer install -d=/app/App --$(ENV_COMPOSER)" && \
        docker-compose -f Docker/docker-compose.$(ENV).yaml exec $(IMAGE) bash -c "composer install -d=/app/CompositeUi --$(ENV_COMPOSER)"

clear-all:
	rm -rf App/vendor
	rm -rf CompositeUi/vendor
	rm -rf CompositeUi/src/Infrastructure/Ui/Assets/node_modules
