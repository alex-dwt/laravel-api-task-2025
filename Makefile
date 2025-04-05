DOCKER_COMPOSE = docker compose -p alex-dwt-stake-test-task
CONTAINER_NAME := server-svc
APP = $(DOCKER_COMPOSE) exec -T $(CONTAINER_NAME)

EXEC_PHP = ${APP} php
ARTISAN_CLI = $(EXEC_PHP) artisan

DB_CONTAINER_NAME := database-svc
DB_APP = $(DOCKER_COMPOSE) exec --user postgres -T $(DB_CONTAINER_NAME)



.PHONY: composer-install
composer-install:
	$(DOCKER_COMPOSE) up setup-vendor

.PHONY: generate-app-key
generate-app-key:
	${ARTISAN_CLI} key:generate



.PHONY: start
start:
	$(DOCKER_COMPOSE) up -d database-svc server-svc

.PHONY: stop
stop:
	@$(DOCKER_COMPOSE) stop -t 1

.PHONY: down
down:
	$(DOCKER_COMPOSE) down -t 1 --remove-orphans -v



.PHONY: shell
shell:
	@$(DOCKER_COMPOSE) exec ${CONTAINER_NAME} bash || true



.PHONY: recreate-db
recreate-db:
	${DB_APP} bash -c "dropdb --if-exists stakeproject && createdb stakeproject"

.PHONY: run-db-migrations-with-seed
run-db-migrations-with-seed:
	${ARTISAN_CLI} migrate --seed



.PHONY: run-tests
run-tests:
	${ARTISAN_CLI} test
