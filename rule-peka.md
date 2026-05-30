# RULE-PEKA.md
# Aturan Bisnis & Logika Sistem — SIPEKA
## Sistem Skrining Preeklampsia dan Kehamilan Aman

---

## 1. DESKRIPSI SISTEM

SIPEKA adalah sistem informasi berbasis web yang dibangun menggunakan **Laravel 12** untuk mendeteksi dini dan memantau risiko preeklampsia pada ibu hamil. Sistem ini beroperasi di fasilitas kesehatan tingkat pertama (Puskesmas, Polindes, Poskesdes) hingga fasilitas rujukan (RSUD, RSIA).

---

## 2. STACK TEKNOLOGI

| Komponen | Teknologi |
|---|---|
| Backend Framework | Laravel 12 |
| Frontend Styling | Bootstrap 5 (CDN) |
| Icons | Font Awesome 6 (CDN) |
| Alert / Dialog | SweetAlert2 (CDN) |
| Chart / Grafik | Chart.js (CDN) |
| Database | MySQL 8+ |
| Auth | Auth Custom |
| Export | DomPDF / Maatwebsite Excel |
| Notifikasi Real-time | Laravel Echo + Pusher (opsional) |

---

## 3. PERAN PENGGUNA (ROLES)

### 3.1 Bidan Desa (`role: bidan`)
- Pengguna garis depan, bertugas di desa/polindes
- Mendaftarkan dan mengelola data ibu hamil di wilayahnya
- Mencatat data kunjungan ANC (Antenatal Care)
- Melihat dasbor pemantauan wilayah
- Mencetak dan mengirim surat rujukan digital
- **Tidak dapat** mengubah diagnosis akhir dokter
- **Tidak dapat** mengakses data di luar wilayah kerjanya

### 3.2 Dokter / Dokter Spesialis (`role: dokter`)
- Pengguna di fasilitas rujukan atau Puskesmas
- Menerima dan memverifikasi pasien rujukan
- Meninjau tren tekanan darah dan riwayat lengkap pasien
- Memberikan diagnosis akhir dan resep
- Menjadwalkan tindakan lanjutan (SC, terminasi kehamilan)
- Mengirim balik catatan medis ke bidan perujuk
- **Dapat** mengakses semua pasien yang dirujuk ke fasilitas mereka

### 3.3 Ibu Hamil (`role: pasien`)
- Pengguna portal pasien dengan antarmuka sederhana
- **Hanya** dapat membaca data medis miliknya sendiri
- **Tidak dapat** mengubah data medis
- Menerima notifikasi jadwal kunjungan
- Mengakses modul edukasi preeklampsia
- Menggunakan tombol lapor darurat

### 3.4 Admin Sistem (`role: admin`)
- Mengelola akun pengguna (bidan, dokter, pasien)
- Mengatur konfigurasi fasilitas kesehatan
- Melihat laporan statistik nasional/regional
- Mengelola konten modul edukasi

---

## 4. MODUL DAN FITUR SISTEM

### 4.1 Modul Registrasi & Autentikasi
- Login multi-role dengan redirect berbeda sesuai role
- Registrasi pasien baru oleh bidan (bukan self-register)
- Reset password via email
- Sesi otomatis logout setelah 30 menit tidak aktif
- Log aktivitas login/logout untuk audit trail

### 4.2 Modul Rekam Medis Ibu Hamil
**Data Identitas Pasien:**
- NIK (Nomor Induk Kependudukan) — unik, wajib
- Nama lengkap
- Tanggal lahir & usia
- Alamat lengkap (provinsi, kabupaten, kecamatan, desa)
- Nomor telepon / WhatsApp
- Golongan darah
- Status pernikahan
- Nama suami / wali

**Data Obstetri:**
- Gravida (G), Para (P), Abortus (A)
- Hari Pertama Haid Terakhir (HPHT)
- Taksiran Persalinan (TP) — auto-hitung dari HPHT (+280 hari)
- Usia kehamilan (UK) — auto-hitung dalam minggu
- Trimester — auto-klasifikasi (I: 0–13 mgg, II: 14–27 mgg, III: 28+ mgg)

**Riwayat Penyakit:**
- Riwayat preeklampsia sebelumnya (Ya/Tidak)
- Riwayat hipertensi kronis
- Riwayat diabetes mellitus
- Riwayat penyakit ginjal
- Riwayat melahirkan bayi dengan BBLR
- Riwayat keluarga preeklampsia (ibu/saudara kandung)
- Kehamilan kembar
- Kehamilan pertama (nullipara)
- Interval kehamilan > 10 tahun

### 4.3 Modul Kunjungan ANC (Antenatal Care)
Setiap kunjungan mencatat:

| Parameter | Satuan | Keterangan |
|---|---|---|
| Tanggal kunjungan | - | Wajib |
| Usia kehamilan saat kunjungan | Minggu | Auto-hitung |
| Berat badan | kg | Wajib |
| IMT (Indeks Massa Tubuh) | kg/m² | Auto-hitung |
| Penambahan BB sejak kunjungan terakhir | kg | Auto-hitung |
| Tekanan darah sistolik | mmHg | Wajib |
| Tekanan darah diastolik | mmHg | Wajib |
| Mean Arterial Pressure (MAP) | mmHg | Auto-hitung: (Sistolik + 2×Diastolik) / 3 |
| Nadi | x/menit | Wajib |
| Tinggi fundus uteri | cm | Wajib |
| Denyut jantung janin (DJJ) | x/menit | Wajib |
| Edema | Tidak / +1 / +2 / +3 | Wajib |
| Protein urine | Negatif / +1 / +2 / +3 / +4 | Wajib |
| Glukosa urine | Negatif / Positif | Opsional |
| Hemoglobin (Hb) | g/dL | Opsional |
| Trombosit | ribu/μL | Opsional |
| Kreatinin serum | mg/dL | Opsional |
| SGOT / SGPT | U/L | Opsional |
| Keluhan subjektif | Teks | Opsional |
| Catatan bidan | Teks | Opsional |

### 4.4 Modul Algoritma Skrining Risiko Preeklampsia

#### 4.4.1 Definisi Kriteria Diagnostik
Berdasarkan Pedoman Nasional POGI (Perkumpulan Obstetri dan Ginekologi Indonesia):

**Hipertensi dalam Kehamilan:**
- Sistolik ≥ 140 mmHg ATAU Diastolik ≥ 90 mmHg (pada dua kali pengukuran interval 4 jam)

**Preeklampsia:**
- Hipertensi (≥140/90 mmHg) + Proteinuria (≥+1) setelah usia kehamilan 20 minggu

**Preeklampsia Berat (PEB):**
- Sistolik ≥ 160 mmHg ATAU Diastolik ≥ 110 mmHg, PLUS salah satu:
  - Proteinuria ≥ +2
  - Trombosit < 100.000/μL
  - Kreatinin serum > 1,1 mg/dL
  - SGOT/SGPT > 2× batas normal
  - Edema paru
  - Nyeri kepala hebat / gangguan penglihatan

**Eklampsia:**
- Preeklampsia + kejang yang bukan disebabkan kondisi lain

#### 4.4.2 Sistem Skoring Risiko

**Faktor Risiko Tinggi (skor 3 per faktor):**
- Riwayat preeklampsia sebelumnya
- Kehamilan kembar
- Penyakit ginjal kronis
- Diabetes mellitus tipe 1 atau 2
- Hipertensi kronis

**Faktor Risiko Moderat (skor 1 per faktor):**
- Nullipara (kehamilan pertama)
- Obesitas (IMT > 30 kg/m²)
- Riwayat keluarga preeklampsia
- Usia ibu > 35 tahun
- Interval kehamilan > 10 tahun
- Kehamilan dengan ART (Assisted Reproductive Technology)

**Klasifikasi Risiko Awal:**
- Risiko Tinggi: ≥ 1 faktor tinggi ATAU ≥ 2 faktor moderat
- Risiko Rendah: selain kriteria di atas

#### 4.4.3 Algoritma Deteksi Otomatis Per Kunjungan

```
FUNGSI hitungRisikoKunjungan(data_kunjungan):

  // Ambil parameter vital
  sistolik = data_kunjungan.tekanan_darah_sistolik
  diastolik = data_kunjungan.tekanan_darah_diastolik
  protein_urine = data_kunjungan.protein_urine  // 0,1,2,3,4
  uk = data_kunjungan.usia_kehamilan_minggu
  edema = data_kunjungan.edema  // 0,1,2,3
  trombosit = data_kunjungan.trombosit  // bisa null
  kreatinin = data_kunjungan.kreatinin  // bisa null

  // Inisialisasi status
  status = "NORMAL"
  peringatan = []

  // Cek Eklampsia (prioritas tertinggi)
  JIKA ada_riwayat_kejang DAN ada_hipertensi:
    status = "EKLAMPSIA"
    peringatan.tambah("⚠️ EKLAMPSIA - Tindakan segera diperlukan!")
    KEMBALIKAN { status, peringatan, level: "MERAH_KRITIS" }

  // Cek Preeklampsia Berat
  hipertensi_berat = (sistolik >= 160 ATAU diastolik >= 110)
  
  JIKA hipertensi_berat DAN uk >= 20:
    status = "PREEKLAMPSIA_BERAT"
    peringatan.tambah("Tekanan darah sangat tinggi (≥160/110 mmHg)")
    
    JIKA protein_urine >= 2:
      peringatan.tambah("Proteinuria berat (≥+2)")
    JIKA trombosit TIDAK NULL DAN trombosit < 100000:
      peringatan.tambah("Trombositopenia (<100.000/μL)")
    JIKA kreatinin TIDAK NULL DAN kreatinin > 1.1:
      peringatan.tambah("Gangguan fungsi ginjal")
    
    KEMBALIKAN { status, peringatan, level: "MERAH" }

  // Cek Preeklampsia
  hipertensi = (sistolik >= 140 ATAU diastolik >= 90)
  
  JIKA hipertensi DAN protein_urine >= 1 DAN uk >= 20:
    status = "PREEKLAMPSIA"
    peringatan.tambah("Hipertensi dengan proteinuria positif")
    KEMBALIKAN { status, peringatan, level: "MERAH" }

  // Cek Hipertensi Gestasional
  JIKA hipertensi DAN uk >= 20:
    status = "HIPERTENSI_GESTASIONAL"
    peringatan.tambah("Tekanan darah tinggi tanpa proteinuria")
    KEMBALIKAN { status, peringatan, level: "KUNING" }

  // Cek Hipertensi Ringan
  hipertensi_ringan = (sistolik >= 130 ATAU diastolik >= 80)
  
  JIKA hipertensi_ringan:
    status = "WASPADA_HIPERTENSI"
    peringatan.tambah("Tekanan darah mendekati batas hipertensi")
    KEMBALIKAN { status, peringatan, level: "KUNING" }

  // Cek Proteinuria Tanpa Hipertensi
  JIKA protein_urine >= 1:
    peringatan.tambah("Proteinuria terdeteksi, pantau tekanan darah")
    KEMBALIKAN { status: "WASPADA_PROTEIN", peringatan, level: "KUNING" }

  // Semua normal
  KEMBALIKAN { status: "NORMAL", peringatan: [], level: "HIJAU" }
```

#### 4.4.4 Level Indikator Warna

| Level | Warna | Kondisi | Tindakan |
|---|---|---|---|
| HIJAU | `#28a745` | Normal, risiko rendah | Pantau rutin sesuai jadwal |
| KUNING | `#ffc107` | Waspada, perlu perhatian | Kunjungan lebih sering, edukasi intensif |
| MERAH | `#dc3545` | Preeklampsia / Hipertensi Berat | Rujuk segera, buat surat rujukan |
| MERAH KRITIS | `#7b0000` | Eklampsia / kondisi mengancam jiwa | Evakuasi darurat, hubungi dokter segera |

### 4.5 Modul Peringatan Dini (Early Warning System)

**Trigger Peringatan Otomatis:**
- Sistem menampilkan modal peringatan SweetAlert2 saat level MERAH atau MERAH KRITIS terdeteksi
- Notifikasi badge muncul di dasbor bidan untuk pasien berisiko
- Notifikasi dikirim ke dokter penanggungjawab (jika fitur real-time aktif)

**Log Peringatan:**
- Setiap peringatan disimpan di tabel `screening_alerts`
- Field: id, pasien_id, kunjungan_id, level, deskripsi, status (baru/ditangani), created_at

### 4.6 Modul Rujukan Digital

**Alur Rujukan:**
1. Bidan menekan tombol "Buat Rujukan" pada pasien berisiko tinggi
2. Sistem auto-generate isi surat rujukan berdasarkan data terakhir
3. Bidan melengkapi: fasilitas tujuan, diagnosa sementara, alasan rujukan
4. Dokter di fasilitas tujuan menerima notifikasi rujukan masuk
5. Dokter menerima/memverifikasi rujukan
6. Setelah penanganan, dokter mengirim balik catatan medis
7. Status rujukan berubah: Dibuat → Dikirim → Diterima → Selesai

**Isi Surat Rujukan (auto-generate):**
- Identitas pasien lengkap
- Usia kehamilan saat rujukan
- Diagnosa sementara
- Tanda vital terakhir (TD, nadi, suhu, RR)
- Hasil laboratorium terakhir
- Obat yang sudah diberikan
- Alasan rujukan
- Fasilitas asal dan tujuan
- Nama & tanda tangan digital bidan/dokter

**Export:** PDF menggunakan DomPDF, bisa dicetak atau dibagikan via WhatsApp

### 4.7 Modul Dasbor Pemantauan

**Dasbor Bidan:**
- Total ibu hamil terdaftar di wilayahnya
- Ringkasan berdasarkan trimester (I/II/III)
- Grafik distribusi risiko (Pie Chart - Chart.js)
- Tabel daftar ibu hamil dengan badge warna risiko
- Filter: by trimester, by tingkat risiko, by status rujukan
- Ibu hamil yang akan memasuki usia persalinan (UK > 36 minggu)
- Ibu hamil yang terlambat kunjungan (jadwal terlewat > 7 hari)

**Dasbor Dokter:**
- Antrian rujukan masuk (urgent pertama)
- Pasien dengan indikator MERAH/MERAH KRITIS
- Grafik tren preeklampsia bulanan (Line Chart - Chart.js)
- Statistik: total pasien ditangani, berhasil dirujuk, dll.

**Dasbor Admin:**
- Statistik nasional/regional
- Grafik kasus preeklampsia per wilayah (Bar Chart - Chart.js)
- Laporan kinerja fasilitas kesehatan

### 4.8 Modul Grafik Tren Tekanan Darah

- Menampilkan Line Chart Chart.js dengan dua garis: Sistolik (merah) & Diastolik (biru)
- Sumbu X: tanggal kunjungan
- Sumbu Y: nilai mmHg
- Garis batas hipertensi ditampilkan sebagai horizontal reference line (140/90)
- Tooltip menampilkan: tanggal, nilai TD, UK saat itu, protein urine
- Dapat difilter per trimester

### 4.9 Modul Jadwal & Pengingat

**Standar Jadwal Kunjungan ANC:**
- Trimester I: minimal 1 kali
- Trimester II: minimal 1 kali
- Trimester III: minimal 4 kali (UK 28, 32, 36, 38-40 minggu)
- Pasien risiko tinggi: setiap 1–2 minggu

**Sistem Pengingat:**
- H-3 sebelum jadwal: SMS/WhatsApp otomatis ke ibu hamil
- H-1: notifikasi push di portal pasien
- Jika terlewat 7 hari: bidan mendapat alert di dasbor
- Jika terlewat 14 hari: status pasien berubah menjadi "Perlu Follow-up"

### 4.10 Modul Lapor Darurat (Emergency Report)

**Gejala Darurat yang Dilaporkan:**
- Pandangan kabur / kilatan cahaya
- Sakit kepala hebat tidak biasa
- Nyeri ulu hati / perut kanan atas
- Pembengkakan mendadak pada wajah, tangan, kaki
- Sesak napas
- Penurunan gerakan janin
- Perdarahan pervaginam
- Kontraksi hebat sebelum waktunya

**Alur Laporan Darurat:**
1. Pasien menekan tombol "🆘 Lapor Darurat" di portal
2. Memilih gejala yang dirasakan (checkbox)
3. Menambahkan deskripsi singkat (opsional)
4. Sistem langsung mengirim notifikasi ke bidan yang mengelola
5. Bidan mendapat alert SweetAlert2 berkedip di dasbor
6. Status laporan: Dikirim → Diproses → Ditangani

### 4.11 Modul Edukasi

**Konten Edukasi (dikelola Admin):**
- Artikel: Apa itu Preeklampsia?
- Artikel: Tanda Bahaya pada Kehamilan
- Artikel: Pola Makan Sehat untuk Ibu Hamil Hipertensi
- Artikel: Pentingnya Kunjungan ANC Rutin
- Video edukasi (embed YouTube)
- Infografis tanda bahaya
- FAQ (Frequently Asked Questions)
- Panduan pengukuran tekanan darah mandiri

**Fitur Tambahan Edukasi:**
- Kalkulator Taksiran Persalinan
- Kalkulator IMT Kehamilan
- Kalkulator MAP (Mean Arterial Pressure)

### 4.12 Modul Laporan & Ekspor

**Jenis Laporan:**
- Laporan Kunjungan ANC per periode
- Laporan Kasus Preeklampsia per wilayah
- Laporan Rujukan (berhasil/ditolak/pending)
- Laporan Kinerja Bidan (jumlah pasien, kunjungan, rujukan)
- Rekap bulanan per Puskesmas (format untuk Dinkes)

**Format Ekspor:**
- PDF (DomPDF)
- Excel (Maatwebsite\Excel)
- Cetak langsung (print CSS)

### 4.13 Modul Riwayat Persalinan

**Pencatatan Hasil Akhir Kehamilan:**
- Tanggal persalinan
- Jenis persalinan: Normal / SC / Vakum / Forceps
- Indikasi SC (jika ada)
- Kondisi ibu pasca persalinan
- Berat lahir bayi (gram)
- Panjang lahir bayi (cm)
- Apgar score menit 1 dan 5
- Kondisi bayi: Hidup / Lahir mati
- Komplikasi: Tidak ada / Perdarahan / Eklampsia / Sepsis / dll.

---

## 5. ATURAN VALIDASI DATA

### 5.1 Validasi Input Kunjungan
```
tekanan_darah_sistolik: integer, 60–250 mmHg, wajib
tekanan_darah_diastolik: integer, 40–150 mmHg, wajib
diastolik HARUS < sistolik
nadi: integer, 40–200 x/menit, wajib
berat_badan: decimal(5,2), 30–200 kg, wajib
tinggi_fundus_uteri: integer, 0–50 cm, wajib
djj: integer, 80–200 x/menit, wajib
usia_kehamilan: integer, 4–42 minggu, auto-hitung, wajib
protein_urine: enum [negatif, +1, +2, +3, +4], wajib
edema: enum [tidak, +1, +2, +3], wajib
```

### 5.2 Aturan Bisnis Kritis
- Satu pasien hanya boleh memiliki SATU kunjungan per hari
- Kunjungan tidak bisa diinput untuk tanggal yang akan datang
- Data kunjungan yang sudah diverifikasi dokter tidak bisa diubah oleh bidan
- Nomor NIK harus unik di seluruh sistem
- Surat rujukan hanya bisa dibuat jika status risiko = KUNING atau lebih tinggi

### 5.3 Auto-Kalkulasi Sistem
```
Taksiran Persalinan = HPHT + 280 hari
Usia Kehamilan = (Tanggal Hari Ini - HPHT) / 7 (dalam minggu)
IMT = Berat Badan (kg) / (Tinggi Badan (m))²
MAP = (Sistolik + 2 × Diastolik) / 3
Penambahan BB = BB kunjungan ini - BB kunjungan sebelumnya
```

---

## 6. STRUKTUR DATABASE (Tabel Utama)

```
users                   → id, name, email, password, role, fasilitas_id
fasilitas_kesehatan     → id, nama, tipe, kecamatan, kabupaten, provinsi
pasien                  → id, nik, nama, tgl_lahir, alamat, no_hp, bidan_id
kehamilan               → id, pasien_id, hpht, tp, gravida, para, abortus, status
kunjungan_anc           → id, kehamilan_id, bidan_id, tanggal, td_sistolik, td_diastolik, ...
skrining_risiko         → id, kunjungan_id, level_risiko, detail_faktor, created_at
peringatan              → id, pasien_id, kunjungan_id, level, deskripsi, status
rujukan                 → id, kehamilan_id, bidan_id, dokter_id, fasilitas_tujuan_id, status, ...
catatan_dokter          → id, rujukan_id, dokter_id, diagnosis, resep, catatan, created_at
laporan_darurat         → id, pasien_id, gejala, deskripsi, status, bidan_id, created_at
hasil_persalinan        → id, kehamilan_id, tanggal, jenis, kondisi_ibu, bb_bayi, ...
edukasi                 → id, judul, konten, kategori, thumbnail, published_at
jadwal_kunjungan        → id, kehamilan_id, tanggal_rencana, tanggal_realisasi, status
notifikasi              → id, user_id, judul, pesan, is_read, created_at
audit_log               → id, user_id, aksi, model, model_id, detail, created_at
```

---

## 7. ATURAN KEAMANAN & AKSES

### 7.1 Authorization Matrix

| Fitur | Admin | Dokter | Bidan | Pasien |
|---|---|---|---|---|
| Kelola akun pengguna | ✅ | ❌ | ❌ | ❌ |
| Daftar pasien baru | ✅ | ✅ | ✅ (wilayah) | ❌ |
| Input kunjungan ANC | ✅ | ✅ | ✅ (pasiennya) | ❌ |
| Lihat rekam medis lengkap | ✅ | ✅ | ✅ (wilayah) | Milik sendiri |
| Buat rujukan | ✅ | ✅ | ✅ | ❌ |
| Input diagnosis akhir | ✅ | ✅ | ❌ | ❌ |
| Input resep obat | ✅ | ✅ | ❌ | ❌ |
| Kelola konten edukasi | ✅ | ❌ | ❌ | ❌ |
| Laporan darurat | ❌ | ❌ | ❌ | ✅ |
| Lihat dasbor nasional | ✅ | ❌ | ❌ | ❌ |
| Export laporan | ✅ | ✅ | ✅ (wilayah) | ❌ |

### 7.2 Keamanan Teknis
- CSRF protection aktif pada semua form (Laravel default)
- Rate limiting pada endpoint login: 5 percobaan / 1 menit
- Password minimal 8 karakter, harus kombinasi huruf & angka
- Semua aksi sensitif diverifikasi ulang via re-authentication
- Audit trail untuk aksi: login, input kunjungan, buat rujukan, ubah data
- Data sensitif dienkripsi di database (NIK, nomor telepon)
- HTTPS wajib di production

---

## 8. ALUR KERJA SISTEM (Workflow)

### Alur Utama Pemantauan Kehamilan:
```
1. Bidan mendaftarkan ibu hamil baru
   └── Input data identitas + riwayat obstetri + faktor risiko

2. Sistem kalkulasi risiko awal
   └── Tampilkan badge risiko di profil pasien

3. Ibu hamil datang kunjungan ANC
   └── Bidan input data vital kunjungan

4. Sistem otomatis kalkulasi risiko kunjungan
   └── JIKA MERAH → tampilkan SweetAlert peringatan
   └── JIKA KUNING → tampilkan notifikasi waspada
   └── JIKA HIJAU → simpan normal

5. Jika MERAH: Bidan buat surat rujukan digital
   └── Auto-generate isi surat dari data sistem
   └── Kirim ke dokter di fasilitas tujuan

6. Dokter terima rujukan
   └── Verifikasi dan tangani pasien
   └── Input diagnosis + resep + catatan
   └── Kirim balik catatan ke bidan

7. Bidan update status pasien pasca rujukan
   └── Lanjutkan pemantauan rutin

8. Setelah persalinan
   └── Input hasil persalinan
   └── Tutup episode kehamilan
```

---

## 9. NOTIFIKASI & KOMUNIKASI

| Event | Penerima | Channel |
|---|---|---|
| Pasien baru terdaftar | Bidan | In-app |
| Kunjungan terlewat 7 hari | Bidan | In-app + badge dasbor |
| Risiko naik ke MERAH | Bidan + Dokter | In-app + SweetAlert |
| Rujukan masuk | Dokter tujuan | In-app |
| Catatan balik dari dokter | Bidan | In-app |
| Laporan darurat pasien | Bidan | In-app (berkedip) |
| Jadwal kunjungan H-3 | Pasien | In-app |
| Hasil pemeriksaan tersedia | Pasien | In-app |

---

## 10. KONFIGURASI SISTEM (Admin)

- Threshold tekanan darah yang bisa dikonfigurasi (default: 140/90)
- Jadwal pengiriman notifikasi otomatis
- Template surat rujukan (dapat dikustomisasi per fasilitas)
- Daftar fasilitas kesehatan dan wilayah kerjanya
- Mapping bidan ke wilayah/desa
- Mapping dokter ke fasilitas rujukan

---

*Dokumentasi ini adalah acuan pengembangan SIPEKA v1.0*
*Dibuat berdasarkan Pedoman Pelayanan Antenatal Kemenkes RI & Panduan POGI*
