# Quiz Expert API

## Installation & development
> `dcr` should be an alias to `docker-compose run --rm -u "$(id -u):$(id -g)"`

### 1. Create `.env` file based on `.env.example`:
```shell script
cp .env.example .env
```

### 2. Run containers:
```shell script
docker-compose up -d --build
```

### 3. Fetch dependencies:
```shell script
dcr php composer install
```

### 4. Generate application key:
```shell script
dcr php php artisan key:generate
```

### 5. Run migrations and seeders:
```shell script
dcr php php artisan migrate --seed
```

## Development commands
### PHP
Run PHP (with command instead of `*`):
```shell script
dcr php *
```

### Composer
Run Composer (with command instead of `*`):
```shell script
dcr php composer *
```

### ECS
Run ECS from Composer:
```shell script
dcr php composer ecs
```

Run ECS from vendor:
```shell script
dcr php ./vendor/bin/ecs check
```

### PHPUnit
Run PHPUnit from Composer:
```shell script
dcr php composer phpunit
```

Run PHPUnit from vendor:
```shell script
dcr php ./vendor/bin/phpunit
```
