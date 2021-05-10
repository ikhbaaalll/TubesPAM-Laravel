## Tutorial instalasi

1. git bash 'git clone https://github.com/ikhbaaalll/TubesPAM-Laravel.git'
2. git bash 'cd TubesPAM-Laravel'
3. git bash 'composer install'
4. git bash 'cp .env.example .env'
5. buka file .env ubah DB_DATABASE=laravel jadi DB_DATABASE=tubes-pam
6. buat database di xampp dengan nama tubes-pam
7. git bash 'php artisan key:generate'
8. git bash 'php artisan migrate --seed'
9. git bash 'php artisan serve --host 0.0.0.0 --port=1010'
