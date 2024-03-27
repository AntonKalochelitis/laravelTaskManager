### Для завантаження проекту
git clone https://github.com/AntonKalochelitis/laravelTaskManager.git
cd laravelTaskManager

### Перед початком установки проекту необхідно налаштувати .env
```shell
cp ./.env.example .env
```

#### Налаштувати .env під власні потреби

### Встановлюємо за допомогою composer
```shell
composer install
```

### За допомогою docker-compose встановлюемо mysql 5.7
### Якщо у Вас встановлений збірник make. Для запуску проекту необхідно запустити команду
```shell
make network_up
make up
```

### Або використовуйте послідовність команд
### Створити віртуальну установку для докера
```shell
sudo docker network create laravel-network
```

### Собрати проект docker
```shell
sudo docker-compose \
--env-file=.env \
-f docker-compose.yml \
up -d --build --remove-orphans
```

### Генеруемо захисний ключ
```shell
php artisan key:generate
```

### Применяет міграції
```shell
php artisan migrate
```

### Для запуску проекту потрібно встановити та запустити
```shell
npm install
npx vite build
```

### Для запуску проекту, потрібно запустити дві служби 
```shell
npm run dev -- --host=0.0.0.0
php artisan serve --host=0.0.0.0
```
