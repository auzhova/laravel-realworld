.PHONY: all

.DEFAULT_GOAL := help

help: ## This help
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST)

env:  ## Create local .env
	@if [ ! -f ./.env ]; then \
		cp .env.example .env; \
	fi

build:  ## Сборка образов
	@docker-compose build

up:  ## Запуск контейнеров
	@docker-compose up -d --remove-orphans

down:  ## Остановка контейнеров
	@docker-compose down

first-run: build up  ## Начальная установка приложения
	@docker-compose exec app composer install
	@docker-compose exec app php artisan key:generate
	@docker-compose exec app php artisan jwt:secret
	@docker-compose exec app php artisan migrate
	@docker-compose exec app php artisan db:seed

fresh: ## Делает свежую базу
	@docker-compose exec app php artisan migrate:fresh
	@docker-compose exec app php artisan db:seed

test: ## Запуск тестов
	@docker-compose exec app php vendor/bin/phpunit

default: help
