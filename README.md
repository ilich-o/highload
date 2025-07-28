# ДЗ к курсу Highload Architect

Используется ORM Doctrine, но дальнейшие запросы будут сделаны чистым SQL

### Установка

#### 1. Запустить docker

```
docker compose up -d
```

#### 2. Установить зависимости

```
docker exec php composer install
```

#### 3. Выполнить миграцию

```
docker exec php bin/console d:m:m
```

#### 3. Импортировать postman коллекцию и запустить запросы последовательно