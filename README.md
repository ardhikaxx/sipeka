<p align="center">
  <h1 align="center">SIPEKA</h1>
  <p align="center"><strong>Sistem Skrining Preeklampsia dan Kehamilan Aman</strong></p>
</p>

## 📌 Tentang SIPEKA

**SIPEKA** adalah sistem informasi berbasis web yang dibangun untuk mendeteksi dini dan memantau risiko preeklampsia pada ibu hamil. Sistem ini dirancang untuk beroperasi di fasilitas kesehatan tingkat pertama (Puskesmas, Polindes, Poskesdes) hingga fasilitas rujukan (RSUD, RSIA), memfasilitasi kolaborasi proaktif antara Bidan, Dokter, dan Pasien dalam menjaga keselamatan ibu dan janin.

## ✨ Fitur Utama

- **🩺 Modul Rekam Medis & Kunjungan ANC**: Pencatatan lengkap identitas, riwayat obstetri, faktor risiko, dan data vital setiap kunjungan (Antenatal Care).
- **🧠 Algoritma Skrining Otomatis**: Deteksi dini tingkat risiko preeklampsia secara otomatis (Risiko Rendah, Waspada, Preeklampsia, Eklampsia) berdasarkan kalkulasi parameter klinis (seperti Tekanan Darah, Protein Urine, Usia Kehamilan) yang merujuk pada pedoman POGI.
- **🚨 Early Warning System (EWS)**: Peringatan visual dengan indikator warna (Hijau, Kuning, Merah, Merah Kritis) serta notifikasi *pop-up* otomatis jika terdeteksi indikasi bahaya kritis pada pasien.
- **📄 Rujukan Digital Terintegrasi**: Pembuatan surat rujukan secara otomatis dari sistem berdasarkan data kunjungan terakhir dan pengiriman rujukan seketika ke dokter di fasilitas tujuan.
- **📊 Dasbor Analitik & Grafik Tren**: Visualisasi interaktif tren tekanan darah pasien menggunakan grafik, memantau daftar antrean, serta statistik kondisi ibu hamil di wilayah kerja.
- **📱 Portal Pasien & Edukasi**: Antarmuka khusus untuk ibu hamil agar dapat memantau jadwal kunjungan, membaca artikel edukasi seputar kehamilan, serta menggunakan fitur **Lapor Darurat** (Emergency Report) saat mengalami gejala berbahaya.

## 🚀 Teknologi yang Digunakan

Aplikasi ini dikembangkan dengan *tech stack* modern yang tangguh:
- **Backend**: Laravel 12 (PHP)
- **Frontend**: HTML/CSS, Vanilla JS, Bootstrap 5 (CDN)
- **Database**: MySQL 8+
- **Library Pendukung**: 
  - **Chart.js**: Untuk visualisasi grafik tren medis
  - **SweetAlert2**: Untuk notifikasi dan konfirmasi interaktif
  - **DomPDF / Maatwebsite Excel**: Untuk ekspor data dan cetak laporan/rujukan
  - **Font Awesome 6**: Untuk ikonografi antarmuka

## 👥 Hak Akses & Peran Pengguna (Role)

Sistem SIPEKA mendukung 4 peran pengguna dengan batasan hak akses (Authorization Matrix) yang disesuaikan dengan alur kerja medis:
1. **Bidan Desa**: Pengguna garis depan; bertugas mencatat rekam medis, input kunjungan ANC rutin, memantau risiko pasien di wilayahnya, serta memicu surat rujukan digital.
2. **Dokter / Spesialis**: Berada di fasilitas rujukan; bertugas menerima dan memverifikasi rujukan, melihat grafik tren klinis, serta memberikan diagnosis akhir dan instruksi medis.
3. **Ibu Hamil (Pasien)**: Mengakses portal pasien untuk melihat data kesehatannya sendiri secara *read-only*, jadwal periksa, modul edukasi, dan tombol lapor darurat.
4. **Admin Sistem**: Mengelola master data faskes, akun pengguna, modul edukasi, serta memantau laporan operasional dan statistik regional secara menyeluruh.

## 🎨 Filosofi Desain (UI/UX)

SIPEKA menggunakan pendekatan desain **"Clinical Warmth"** — perpaduan antara ketegasan antarmuka medis yang profesional namun tetap memberikan kehangatan yang menenangkan bagi penggunanya (terutama ibu hamil).
- **Clarity First**: Informasi krusial (seperti tekanan darah kritis atau peringatan EWS) dirancang agar terlihat dalam 3 detik pertama.
- **Contextual Color**: Warna UI digunakan secara semantik (contoh: Hijau = Aman, Kuning = Waspada, Merah = Rujuk/Darurat).

## 🛠️ Panduan Instalasi (Development)

Ikuti langkah-langkah berikut untuk menjalankan SIPEKA di lingkungan lokal (Localhost):

1. **Clone repositori ini:**
   ```bash
   git clone <url-repo-sipeka>
   cd sipeka
   ```

2. **Instal dependensi PHP (Composer):**
   ```bash
   composer install
   ```

3. **Instal dependensi Node.js (NPM):**
   *(Langkah ini diperlukan jika Anda menggunakan Vite untuk asset bundling)*
   ```bash
   npm install
   npm run build
   ```

4. **Konfigurasi Environment:**
   Salin file `.env.example` menjadi `.env` dan sesuaikan konfigurasi koneksi database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
   ```bash
   cp .env.example .env
   ```
   Generate application key:
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Seeding (Opsional):**
   Jalankan migrasi untuk membuat struktur tabel dan *seeder* untuk mengisi data awal (role, admin, dll).
   ```bash
   php artisan migrate --seed
   ```

6. **Jalankan Server Lokal:**
   ```bash
   php artisan serve
   ```
   Aplikasi dapat diakses melalui browser pada `http://localhost:8000`.

---
*Untuk rincian lebih dalam mengenai logika algoritma dan aturan bisnis, silakan merujuk pada file `rule-peka.md` dan `design-peka.md` di dalam repositori ini.*


## Donasi

Jika project ini bermanfaat, Anda dapat mendukung pengembangan selanjutnya melalui donasi:

<div align="center">

<img src="public/assets/qris.png" alt="QRIS" width="250" />

**Scan QRIS di atas untuk berdonasi**

Setiap donasi akan digunakan untuk:
- Pengembangan fitur baru
- Perbaikan bug & maintenance
- Infrastruktur server

</div>