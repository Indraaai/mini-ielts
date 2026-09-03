# Mini IELTS Application

Aplikasi latihan **IELTS Speaking** yang memungkinkan pengguna menjawab pertanyaan speaking dan mendapatkan evaluasi otomatis menggunakan **Google Gemini AI**.

Proyek ini terdiri dari Backend API berbasis Laravel dan Frontend berbasis Vue.

## Fitur

- Registrasi dan login pengguna
- Autentikasi menggunakan Laravel Sanctum
- Daftar pertanyaan IELTS Speaking
- Pengiriman jawaban speaking
- Evaluasi jawaban menggunakan Google Gemini AI
- Estimasi IELTS Speaking Band
- Feedback, strengths, dan areas to improve
- Riwayat percobaan speaking
- Detail hasil evaluasi
- Dokumentasi API menggunakan Swagger / OpenAPI

## Tech Stack

### Backend

- Laravel 12
- PHP
- Laravel Sanctum
- SQLite
- Google Gemini API
- L5-Swagger dan OpenAPI

### Frontend

- Vue 3
- TypeScript
- Vite
- Vue Router
- Pinia
- Axios
- Tailwind CSS

## Struktur Project

```text
Mini-IELTS/
├── Backend/
│   ├── app/
│   │   ├── Http/
│   │   ├── Models/
│   │   ├── Repositories/
│   │   ├── Services/
│   │   └── OpenApi.php
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   ├── routes/
│   │   └── api.php
│   ├── .env.example
│   └── composer.json
│
└── Frontend/
    ├── public/
    ├── src/
    │   ├── api/
    │   ├── assets/
    │   ├── components/
    │   ├── router/
    │   ├── stores/
    │   └── views/
    ├── package.json
    └── vite.config.ts
```

## Requirements

- PHP 8.2 atau lebih baru
- Composer
- Node.js 20 atau lebih baru
- npm
- Git
- API key Google Gemini

## Setup Backend

Jalankan perintah berikut dari root project:

```bash
cd Backend
composer install
cp .env.example .env
php artisan key:generate
```

Pada Windows PowerShell, gunakan perintah berikut untuk menyalin file environment:

```powershell
Copy-Item .env.example .env
```

Atur nilai berikut di file `Backend/.env`:

```env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=sqlite

GEMINI_API_KEY=your_gemini_api_key
GEMINI_MODEL=gemini-3.7-flash
```

Siapkan database dan jalankan server:

```bash
php artisan migrate --seed
php artisan serve
```

Backend tersedia di `http://127.0.0.1:8000`.

## Setup Frontend

Buka terminal baru, lalu jalankan dari root project:

```bash
cd Frontend
npm install
npm run dev
```

Frontend biasanya tersedia di `http://localhost:5173`.

Frontend menggunakan API Backend berikut secara default:

```text
http://127.0.0.1:8000/api
```

Konfigurasi API tersebut berada di `Frontend/src/api/axios.ts`. Backend harus aktif agar login, latihan, dan evaluasi dapat digunakan.

## Build Frontend

Untuk melakukan type-check dan membuat build production:

```bash
cd Frontend
npm run build
```

Untuk melihat hasil build secara lokal:

```bash
npm run preview
```

## Route Frontend

| Route                | Keterangan             |
| -------------------- | ---------------------- |
| `/login`             | Halaman login          |
| `/speaking`          | Latihan IELTS Speaking |
| `/history`           | Riwayat percobaan      |
| `/result/:attemptId` | Detail hasil evaluasi  |

Route selain `/login` membutuhkan autentikasi pengguna.

## Dokumentasi Detail

- [Dokumentasi Backend](Backend/README.md)
- [Dokumentasi Frontend](Frontend/README.md)

## Pengalaman Deploy

- Saya memiliki pengaaman deploy menggunakan layanan Cpanel Shared Hosting dan juga layanan Cloud Vercel, di intern sebelumnya saya mendeploy aplikasi web presesensi dan penilaian untk kebutuhan internal perusahaan, di proses deploy ini saya mulai dengan membuat database mysql , setup git di terminal Cpanel supaya update bisa langsung pull dari terminal dan tidak via upload file, setup cronjobs untuk melakukan generate pencatatan alfa otomatis, serta membuat subdomain aplikasinya, alur deploy project ini adalah perubahan di lokaldi push ke branch main github, lalu di terminal Cpanel tinggal pull branch main github dan perubahan langsung terjadi di production.

- untuk deploy via vercel biasanya project yang saya deploy berbasis node js, bun, react vue next js dsb. karena sangat cepat dan efisien untuk adtaabse biasanay saya mengguaakn neon atau supabase.
