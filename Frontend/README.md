# Mini IELTS Frontend

Frontend untuk aplikasi latihan **IELTS Speaking**. Pengguna dapat login, menjawab pertanyaan speaking, melihat hasil evaluasi dari Google Gemini AI, dan membuka riwayat percobaan.

Frontend ini dibangun menggunakan Vue 3, TypeScript, dan Vite, serta berkomunikasi dengan Backend Laravel melalui REST API.

## Fitur

- Login pengguna
- Menjawab pertanyaan IELTS Speaking
- Melihat estimasi IELTS Speaking Band
- Melihat feedback, strengths, dan areas to improve
- Melihat riwayat percobaan speaking
- Melihat detail hasil evaluasi
- Proteksi route berdasarkan status autentikasi

## Tech Stack

- Vue 3
- TypeScript
- Vite
- Vue Router
- Pinia
- Axios
- Tailwind CSS

## Requirements

- Node.js 20 atau lebih baru
- npm
- Backend Mini IELTS berjalan di `http://127.0.0.1:8000`

## Instalasi

```bash
cd Frontend
npm install
```

Pastikan Backend sudah dikonfigurasi dan dijalankan terlebih dahulu:

```bash
cd ../Backend
php artisan serve
```

## Menjalankan Development Server

Jalankan dari folder `Frontend`:

```bash
npm run dev
```

Vite akan menampilkan alamat lokal, biasanya:

```text
http://localhost:5173
```

Buka alamat tersebut di browser. API Frontend secara default menggunakan:

```text
http://127.0.0.1:8000/api
```

Alamat API dikonfigurasi di `src/api/axios.ts`.

## Build Production

Untuk melakukan type-check dan membuat build production:

```bash
npm run build
```

Hasil build tersedia di folder `dist/`.

Untuk menjalankan hasil build secara lokal:

```bash
npm run preview
```

## Struktur Folder

```text
Frontend/
├── public/             # Asset publik
├── src/
│   ├── api/            # Konfigurasi Axios dan pemanggilan API
│   ├── assets/         # Asset aplikasi
│   ├── components/     # Komponen Vue yang dapat digunakan ulang
│   ├── router/         # Konfigurasi route dan guard autentikasi
│   ├── stores/         # State management dengan Pinia
│   ├── views/          # Halaman aplikasi
│   ├── App.vue         # Root component
│   ├── main.ts         # Entry point aplikasi
│   └── style.css       # Style global
├── index.html
├── package.json
└── vite.config.ts
```

## Route Utama

| Route                | Keterangan             |
| -------------------- | ---------------------- |
| `/login`             | Halaman login          |
| `/speaking`          | Latihan IELTS Speaking |
| `/history`           | Riwayat percobaan      |
| `/result/:attemptId` | Detail hasil evaluasi  |

Route `/speaking`, `/history`, dan `/result/:attemptId` membutuhkan token autentikasi dari Backend.

## Perintah npm

| Perintah          | Keterangan                      |
| ----------------- | ------------------------------- |
| `npm run dev`     | Menjalankan development server  |
| `npm run build`   | Type-check dan build production |
| `npm run preview` | Preview hasil build production  |
