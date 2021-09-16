# SquareCheck-backend
Square Check adalah aplikasi absensi online

How To Install This Project
===

Use PHP Composer + Artisan
---

1. Install this Project Dependencies
```bash
> composer install
```

2. Copy .env.example to .env

3. Generate JWT Secret Key
```bash
> php artisan jwt:secret
```

4. Change database settings in .env  
   - (Optional) Change database to database.sqlite
```bash
# Change to sqlite or other database
DB_CONNECTION=sqlite
```

5. (Optional) Create database.sqlite file
```bash
# Linux
$ touch database/database.sqlite
# Windows
> type nul > database\database.sqlite
```

6. Laravel Migrate and Seed
```cmd
> php artisan migrate --seed
```

7. Laravel Artisan Serve
```bash
> php artisan serve
```
