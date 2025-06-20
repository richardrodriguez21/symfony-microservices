.PHONY: help start-all stop-all build-all restart-all ssh-register ssh-application ssh-mailer start-colima

help: ## Show this help message
	@echo 'usage: make [target]'
	@echo
	@echo 'targets:'
	@egrep '^(.+)\:\ ##\ (.+)' ${MAKEFILE_LIST} | column -t -c 2 -s ':#'

start-colima:
	@echo "Checking if Colima is running..."
	@if ! colima status 2>/dev/null | grep -q '^Status: Running'; then \
		echo "Colima is not running. Starting Colima..."; \
		colima start --cpu 1 --memory 2 --disk 10 --network-address && docker network create app-network || true; \
	else \
		echo "Colima is already running."; \
	fi

start-all: ## Runs all services: RabbitMQ, Register, Application and Mailer
	$(MAKE) start-colima
	make -C rabbitmq start
	make -C register start
	make -C application start
	make -C mailer start
	$(MAKE) prepare-all

prepare-all: ## Install dependencies and run migrations in all services
	make -C register prepare
	make -C application prepare
	make -C mailer prepare

stop-all: ## Stops all services: RabbitMQ, Register, Application and Mailer
	make -C rabbitmq stop
	make -C register stop
	make -C application stop
	make -C mailer stop

build-all: ## Build all services: RabbitMQ, Register, Application and Mailer
	make -C register build
	make -C application build
	make -C mailer build

restart-all: ## Restarts all services: RabbitMQ, Register, Application and Mailer
	make -C rabbitmq restart
	make -C register restart
	make -C application restart
	make -C mailer restart

ssh-register: ## bash into Register Service PHP container
	make -C register ssh-be

ssh-application: ## bash into Register Service PHP container
	make -C application ssh-be

ssh-mailer: ## bash into Register Service PHP container
	make -C mailer ssh-be

ssh-rabbitmq: ## bash into RabbitMQ container
	make -C rabbitmq ssh