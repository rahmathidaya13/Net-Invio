# Aplikasi Data Barang Berbasis Web


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


