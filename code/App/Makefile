
dev:
	@composer install  && \
	    php etc/bin/symfony-console doctrine:database:create --if-not-exists && \
            php etc/bin/symfony-console do:mi:mi -v --no-interaction

prod:
	@composer install  && \
	    php etc/bin/symfony-console doctrine:database:create --if-not-exists && \
            php etc/bin/symfony-console do:mi:mi -v --no-interaction
