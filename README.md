# Ambiente Laravel 12 + Livewire 4 com Docker para o Mini Curso PHP Conference BR

## 1. Na raiz do projeto, executar a build dos containers
``` bash
docker-compose up -d
```

## 2. Acessando o container do Apache (PHP) e rodando as migrations
``` bash
docker exec -it laravel-apache bash
php artisan migrate --seed
```

## 3. Acessando o container Node (Vite + NPM) e rodando a build
``` bash
docker exec -it laravel-node bash
npm i && npm run dev
npm run build
```

## 4. Acessando o container MySQL e conectando no banco de dados
``` bash
docker exec -it laravel-mysql bash
mysql -u laravel -plaravel phpconf
show tables from phpconf
```

SINGLE PAGE APPLICATION

php artisan tinker

User::factory(100)->create();
User::get();


php artisan livewire:layout
php artisan make:livewire users