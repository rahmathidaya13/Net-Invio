# Aplikasi Data Barang Berbasis Web

#image
<img width="758" height="524" alt="login page netinvio" src="https://github.com/user-attachments/assets/0734caee-15d0-41a7-9d88-9001ac536957" />
<img width="1366" height="644" alt="data barang net invio" src="https://github.com/user-attachments/assets/b3dd8c02-f950-4411-a7fd-53b15b9b560e" />
<img width="1366" height="641" alt="stok barang net invio" src="https://github.com/user-attachments/assets/2c16e96e-4624-4379-85be-e89a59c636fb" />
<img width="1366" height="635" alt="role netinvio" src="https://github.com/user-attachments/assets/240861a8-1668-419f-97fb-b66281882ff1" />

## Fitur

- Manajemen Pengguna (only Admin)
- Manajemen Daftar Barang
- Manajemen Stok Barang
- Manajemen Barang Masuk
- Manajemen Barang Keluar
- Manajemen Barang Kembali

## Persyaratan

- PHP >= 8.0
- Composer
- MySQL atau database lainnya yang didukung oleh Laravel
- Node.js dan npm (untuk mengelola asset front-end)

## Instalasi

Ikuti langkah-langkah di bawah ini untuk dapat menggunakan aplikasi ini

### 1. Clone repositori

```bash
git clone https://github.com/rahmathidaya13/Net-Invio.git
cd Net-Invio

```
### 2. Install Depedency

```bash
composer install
npm install
npm run dev

```
### 3. Konfigurasi lingkungan
Salin file .env.example menjadi .env dengan cara berikut ini.

```bash
cp .env.example .env

```
Setelah itu, buat kunci aplikasi Laravel:
```bash
php artisan key:generate

```
### 4. Migrasi dan Seed Database
Jalankan migrasi database dan seed data awal:
```bash
php artisan migrate
php artisan db:seed
```
### 5. Menjalankan Server
Jalankan server pengembangan Laravel:
```bash
npm run build 
php artisan serve


