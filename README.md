### Для завантаження проекту
git clone https://github.com/AntonKalochelitis/laravelTaskManager.git
cd laravelTaskManager


### Перед початком встановлюємо за допомогою composer
composer install

### Перед початком установки проекту необхідно налаштувати .env
cp ./.env.example .env

#### Налаштувати .env під власні потреби

### Якщо у Вас встановлений збірник make. Для запуску проекту необхідно запустити команду 

make 

### Або використовуйте послідовність команд
### Створити віртуальну установку для докера
sudo docker network create laravel-network

### Собрати проект docker
sudo docker-compose \
--env-file=.env \
-f docker-compose.yml \
up -d --build --remove-orphans

### Применяет міграції
php artisan migrate

### Для запуску проекту
php artisan serve --host=0.0.0.0
