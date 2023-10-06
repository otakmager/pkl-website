# Sistem Informasi Keuangan CV Berkah Makmur

![Laravel](https://img.shields.io/badge/laravel-%23FF2D20.svg?style=for-the-badge&logo=laravel&logoColor=white) ![PHP](https://img.shields.io/badge/php-%23777BB4.svg?style=for-the-badge&logo=php&logoColor=white) ![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E) ![HTML5](https://img.shields.io/badge/html5-%23E34F26.svg?style=for-the-badge&logo=html5&logoColor=white) ![Bootstrap](https://img.shields.io/badge/bootstrap-%238511FA.svg?style=for-the-badge&logo=bootstrap&logoColor=white) ![MariaDB](https://img.shields.io/badge/MariaDB-003545?style=for-the-badge&logo=mariadb&logoColor=white) ![Apache](https://img.shields.io/badge/apache-%23D42029.svg?style=for-the-badge&logo=apache&logoColor=white)

Sistem informasi yang digunakan dalam membantu mengelola dan memonitor transaksi keuangan di CV Berkah Makmur.

## Fitur

-   Mencatat, mengedit, menghapus sementara, memulihkan data, dan menghapus permanen data transaksi masuk.
-   Mencatat, mengedit, menghapus sementara, memulihkan data, dan menghapus permanen data transaksi keluar.
-   Mencatat, mengedit, menghapus sementara, memulihkan data, dan menghapus permanen data label transaksi.
-   Pemberian ikhtisar laporan keuangan dalam kurun waktu hari ini, seminggu, sebulan, setahun.
-   Pengunduhan laporan keuangan yang dapat dikustomisasi dalam bentuk PDF dan Excel.
-   Manajemen akun pengguna sistem.
-   Pengaturan akun.
-   Autentikasi

## Aktor Pengguna Sistem

-   Pimpinan - 1 akun
-   User - N akun untuk pegawai

## Tool

-   Virtual Studio Code
-   XAMPP
-   Composer

## Tech

-   HTML5
-   CSS
-   JavaScript
-   PHP versi 8
-   Laravel versi 9
-   Bootstrap
-   JQuery
-   MariaDB
-   [Stisla Template](https://demo.getstisla.com/)

## Laravel Libraries

```
    barryvdh/laravel-dompdf
    maatwebsite/excel
    phpoffice/phpspreadsheet
```

## Installation

Aplikasi ini memerlukan PHP versi 8 dan composer untuk bisa berjalan.

1. Clone project ke local storage di PC.

    ```
    git clone https://github.com/otakmager/pkl-website.git
    ```

2. Copy file .env.example dan rename jadi file .env
3. Buat database baru sesuai nama DB_DATABASE di file .env
4. Konfigurasi database di file .env (username, password, connection, host, port)
5. Buka terminal dan jalankan perintah ini untuk install library dari projek laravel:
    ```
    composer install
    ```
    Karena tidak menggunakan nodeJS maka tidak perlu `npm install`
6. Tutup file .env supaya tidak error waktu generate key projek laravel
7. Jalankan perintah di terimal ini untuk generate key:
    ```
    php artisan key:generate
    ```
8. Cek APP_KEY di file .env sudah ada value-nya
9. Jalankan perintah di terimal ini untuk generate tabel di database:
    ```
    php artisan migrate
    ```
    Jika ingin ada data dummy dari seeder bisa pakai perintah:
    ```
    php artisan db:seed
    ```
    Kalau mau refresh data sekaligus drop & re-create db pakai:
    ```
    php artisan migrate:fresh --seed
    ```
10. Jalankan file laravel dengan menjalankan perintah di terminal:
    ```
    php artisan serve
    ```
