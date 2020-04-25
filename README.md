# Laravel Starter
Laravel Starter merupakan admin panel sederhana dengan menggunakan laravel dan juga terintegrasi dengan template [Stisla](https://getstisla.com/).

## Fitur
- *Auth* (*register, verify, reset password, confirm password*)
- *Roles* dan *permission* dengan `spatie/laravel-permission`

## *Requirements*
- PHP >= 7.2.5
- Git
- Composer

## *Installing*
- *Clone* repo:
```
git clone https://github.com/rmalan/laravel-starter.git
```
- Jalankan:
```
$ composer install
```
- *Setup* file `.env` (db dan mail). Kemudian jalankan:
```
$ php artisan key:generate
$ php artisan migrate
$ php artisan db:seed
$ php artisan serve
```

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
