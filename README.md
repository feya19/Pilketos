<h1 align="center">Selamat datang di Aplikasi Voting Pemilihan Ketua Osis! 👋</h1>
<img src="https://user-images.githubusercontent.com/61069138/200459674-928d1bfc-a291-4c06-a343-0b964c04c64b.png" >


## Akun Default

- email: admin@gmail.com
- Password: admin123
- Login Admin 127.0.0.1:8000/login-admin
---

## Install

1. **Repository**

```bash
extract file
masuk folder dan masuk terminal
composer install
buat file bernama .env dalam folder
copy isi file dari .env.example ke .env
```

2. **Buka `.env` lalu ubah baris berikut sesuai dengan databasemu yang ingin dipakai**

```bash
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

3. **Instalasi Aplikasi**

```bash
terminal
php artisan key:generate
php artisan migrate --seed
```

5. **Jalankan Aplikasi**

```bash
php artisan serve
```

## Preview

![Screenshot 2022-11-08 091617](https://user-images.githubusercontent.com/61069138/200460242-f67d1e6c-f963-4239-ae6f-f4c43bcdd006.png)
![Screenshot 2022-11-08 091725](https://user-images.githubusercontent.com/61069138/200460249-771bdd9d-2441-4f1f-b942-5e5081b3c554.png)
![Screenshot 2022-11-08 091323](https://user-images.githubusercontent.com/61069138/200460252-5ad6418a-08f3-455b-add9-9f90bb9bae28.png)

