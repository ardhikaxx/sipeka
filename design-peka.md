# DESIGN-PEKA.md
# Panduan Desain UI/UX — SIPEKA
## Sistem Skrining Preeklampsia dan Kehamilan Aman

---

## 1. IDENTITAS VISUAL & FILOSOFI DESAIN

### 1.1 Konsep Desain
SIPEKA menggunakan pendekatan desain **"Clinical Warmth"** — perpaduan antara ketegasan antarmuka medis yang profesional dengan kehangatan yang menenangkan, mengingat pengguna utama adalah tenaga kesehatan ibu dan hamil yang membutuhkan kepercayaan, kejelasan, dan kenyamanan visual.

**Prinsip Utama:**
- **Clarity First** — Informasi kritis harus terlihat dalam 3 detik pertama
- **Contextual Color** — Warna digunakan bermakna (hijau = aman, merah = darurat)
- **Density yang Tepat** — Dasbor padat informasi, portal pasien ringan dan lapang
- **Konsistensi Komponen** — Elemen yang sama tampil identik di seluruh sistem

### 1.2 CDN Dependencies (wajib diinclude di semua halaman)
```html
<!-- Bootstrap 5 -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Font Awesome 6 -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
```

---

## 2. PALET WARNA

### 2.1 Warna Primer (Brand)
```css
:root {
  /* === BRAND COLORS === */
  --peka-primary:        #1A6B6B;   /* Teal gelap — kepercayaan medis */
  --peka-primary-light:  #2A8F8F;   /* Teal sedang */
  --peka-primary-pale:   #E8F5F5;   /* Teal sangat terang — background card */
  --peka-secondary:      #E84393;   /* Magenta rose — identitas maternal */
  --peka-secondary-light:#FDEEF6;   /* Pink pale — highlight pasien */
  --peka-accent:         #F6A623;   /* Amber — aksen & highlight */
  
  /* === SEMANTIC RISK COLORS === */
  --risk-green:          #1DB954;   /* Risiko rendah / Normal */
  --risk-green-bg:       #E8F8EE;
  --risk-green-border:   #A3E4B8;
  
  --risk-yellow:         #F59E0B;   /* Waspada */
  --risk-yellow-bg:      #FFFBEB;
  --risk-yellow-border:  #FDE68A;
  
  --risk-red:            #EF4444;   /* Preeklampsia */
  --risk-red-bg:         #FEF2F2;
  --risk-red-border:     #FECACA;
  
  --risk-critical:       #7C0000;   /* Eklampsia / Darurat */
  --risk-critical-bg:    #FFF0F0;
  --risk-critical-border:#FF9090;
  
  /* === NEUTRAL TONES === */
  --gray-50:   #F8FAFC;
  --gray-100:  #F1F5F9;
  --gray-200:  #E2E8F0;
  --gray-300:  #CBD5E1;
  --gray-400:  #94A3B8;
  --gray-500:  #64748B;
  --gray-600:  #475569;
  --gray-700:  #334155;
  --gray-800:  #1E293B;
  --gray-900:  #0F172A;
  
  /* === BACKGROUND === */
  --bg-app:    #F0F4F8;   /* Background halaman utama */
  --bg-card:   #FFFFFF;
  --bg-sidebar:#0F2B2B;   /* Sidebar gelap teal */
  
  /* === TEXT === */
  --text-primary:   #1E293B;
  --text-secondary: #64748B;
  --text-muted:     #94A3B8;
  --text-inverse:   #FFFFFF;
}
```

### 2.2 Warna Per Role (untuk aksen spesifik)
```css
:root {
  --role-bidan:    #2A8F8F;   /* Teal — Bidan Desa */
  --role-dokter:   #3B5BDB;   /* Biru royal — Dokter */
  --role-pasien:   #E84393;   /* Rose — Ibu Hamil */
  --role-admin:    #7048E8;   /* Ungu — Admin */
}
```

---

## 3. TIPOGRAFI

### 3.1 Font Stack
```css
:root {
  --font-heading: 'Plus Jakarta Sans', sans-serif;   /* Judul, angka besar, badge */
  --font-body:    'DM Sans', sans-serif;             /* Teks paragraf, label */
  --font-mono:    'Fira Code', 'Courier New', monospace; /* Nilai lab, kode */
}

body {
  font-family: var(--font-body);
  font-size: 14px;
  line-height: 1.6;
  color: var(--text-primary);
}
```

### 3.2 Skala Tipografi
```css
/* Heading Halaman */
.page-title {
  font-family: var(--font-heading);
  font-size: 1.5rem;      /* 24px */
  font-weight: 700;
  color: var(--gray-900);
  letter-spacing: -0.02em;
}

/* Sub-heading / Card Title */
.section-title {
  font-family: var(--font-heading);
  font-size: 1rem;        /* 16px */
  font-weight: 600;
  color: var(--gray-700);
}

/* Label form */
.form-label {
  font-size: 0.8125rem;   /* 13px */
  font-weight: 500;
  color: var(--gray-600);
  margin-bottom: 0.375rem;
}

/* Nilai statistik besar di dasbor */
.stat-number {
  font-family: var(--font-heading);
  font-size: 2rem;        /* 32px */
  font-weight: 800;
  line-height: 1;
}

/* Nilai kecil tekanan darah, dll */
.vital-value {
  font-family: var(--font-heading);
  font-size: 1.125rem;
  font-weight: 700;
}

/* Teks muted / helper */
.text-hint {
  font-size: 0.75rem;     /* 12px */
  color: var(--text-muted);
}
```

---

## 4. KOMPONEN UI

### 4.1 Badge Risiko

```html
<!-- Penggunaan -->
<span class="badge-risk badge-risk--green">Risiko Rendah</span>
<span class="badge-risk badge-risk--yellow">Waspada</span>
<span class="badge-risk badge-risk--red">Preeklampsia</span>
<span class="badge-risk badge-risk--critical">Eklampsia</span>
```

```css
.badge-risk {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 0.75rem;
  font-weight: 600;
  font-family: var(--font-heading);
  border: 1px solid transparent;
}

.badge-risk::before {
  content: '';
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: currentColor;
}

.badge-risk--green   { color: #0D7A35; background: var(--risk-green-bg); border-color: var(--risk-green-border); }
.badge-risk--yellow  { color: #9A6202; background: var(--risk-yellow-bg); border-color: var(--risk-yellow-border); }
.badge-risk--red     { color: #C41212; background: var(--risk-red-bg); border-color: var(--risk-red-border); }
.badge-risk--critical {
  color: #7C0000;
  background: var(--risk-critical-bg);
  border-color: var(--risk-critical-border);
  animation: pulse-critical 1.5s ease-in-out infinite;
}

@keyframes pulse-critical {
  0%, 100% { box-shadow: 0 0 0 0 rgba(239, 68, 68, 0.4); }
  50%       { box-shadow: 0 0 0 6px rgba(239, 68, 68, 0); }
}
```

### 4.2 Card Statistik Dasbor

```html
<div class="stat-card">
  <div class="stat-card__icon" style="background: #E8F5F5; color: var(--peka-primary);">
    <i class="fas fa-users-line"></i>
  </div>
  <div class="stat-card__content">
    <div class="stat-card__number">142</div>
    <div class="stat-card__label">Total Ibu Hamil</div>
    <div class="stat-card__sub">
      <i class="fas fa-arrow-trend-up text-success"></i>
      <span class="text-success fw-semibold">+8</span>
      <span class="text-muted"> bulan ini</span>
    </div>
  </div>
</div>
```

```css
.stat-card {
  background: var(--bg-card);
  border-radius: 16px;
  padding: 20px 22px;
  display: flex;
  align-items: center;
  gap: 16px;
  border: 1px solid var(--gray-200);
  box-shadow: 0 1px 3px rgba(0,0,0,0.04), 0 4px 12px rgba(0,0,0,0.03);
  transition: transform 0.2s ease, box-shadow 0.2s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.stat-card__icon {
  width: 52px;
  height: 52px;
  border-radius: 14px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.375rem;
  flex-shrink: 0;
}

.stat-card__number {
  font-family: var(--font-heading);
  font-size: 1.875rem;
  font-weight: 800;
  color: var(--gray-900);
  line-height: 1;
  margin-bottom: 4px;
}

.stat-card__label {
  font-size: 0.8125rem;
  color: var(--text-secondary);
  font-weight: 500;
  margin-bottom: 6px;
}

.stat-card__sub {
  font-size: 0.75rem;
  display: flex;
  align-items: center;
  gap: 4px;
}
```

### 4.3 Card Pasien (List Item)

```html
<div class="patient-card">
  <div class="patient-card__avatar">
    <i class="fas fa-person-pregnant"></i>
  </div>
  <div class="patient-card__info">
    <div class="patient-card__name">Siti Rahayu</div>
    <div class="patient-card__meta">
      <span><i class="fas fa-calendar-days"></i> UK 32 Minggu</span>
      <span><i class="fas fa-map-marker-alt"></i> Ds. Kaliwates</span>
    </div>
    <div class="patient-card__vitals">
      <span class="vital-chip vital-chip--td">130/85 mmHg</span>
      <span class="vital-chip vital-chip--protein">Protein +1</span>
    </div>
  </div>
  <div class="patient-card__actions">
    <span class="badge-risk badge-risk--yellow">Waspada</span>
    <div class="d-flex gap-2 mt-2">
      <a href="#" class="btn btn-sm btn-peka-outline"><i class="fas fa-eye"></i></a>
      <a href="#" class="btn btn-sm btn-peka-primary"><i class="fas fa-plus"></i> Kunjungan</a>
    </div>
  </div>
</div>
```

```css
.patient-card {
  background: white;
  border-radius: 12px;
  padding: 14px 16px;
  display: flex;
  align-items: flex-start;
  gap: 14px;
  border: 1px solid var(--gray-200);
  transition: border-color 0.2s, box-shadow 0.2s;
  margin-bottom: 10px;
}

.patient-card:hover {
  border-color: var(--peka-primary-light);
  box-shadow: 0 2px 12px rgba(26,107,107,0.08);
}

/* Variasi warna border kiri berdasarkan risiko */
.patient-card.risk-green    { border-left: 3px solid var(--risk-green); }
.patient-card.risk-yellow   { border-left: 3px solid var(--risk-yellow); }
.patient-card.risk-red      { border-left: 3px solid var(--risk-red); }
.patient-card.risk-critical { border-left: 3px solid var(--risk-critical); }

.patient-card__avatar {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: var(--peka-secondary-light);
  color: var(--peka-secondary);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  flex-shrink: 0;
}

.patient-card__name {
  font-weight: 600;
  font-size: 0.9375rem;
  color: var(--gray-900);
  margin-bottom: 4px;
}

.patient-card__meta {
  font-size: 0.75rem;
  color: var(--text-secondary);
  display: flex;
  gap: 12px;
  margin-bottom: 8px;
}

.patient-card__meta i { margin-right: 3px; }

.vital-chip {
  display: inline-flex;
  align-items: center;
  padding: 2px 8px;
  border-radius: 6px;
  font-size: 0.6875rem;
  font-weight: 600;
  font-family: var(--font-heading);
  margin-right: 4px;
}

.vital-chip--td      { background: #EEF2FF; color: #3B5BDB; }
.vital-chip--protein { background: #FFF0F6; color: #C2255C; }
.vital-chip--normal  { background: #EBFBEE; color: #2B8A3E; }
```

### 4.4 Card Informasi Vital (Detail Pasien)

```html
<div class="vital-card">
  <div class="vital-card__header">
    <i class="fas fa-heart-pulse vital-card__icon text-danger"></i>
    <span class="vital-card__title">Tekanan Darah</span>
  </div>
  <div class="vital-card__value">130<span class="vital-card__unit">/</span>85
    <span class="vital-card__unit">mmHg</span>
  </div>
  <div class="vital-card__trend">
    <i class="fas fa-arrow-up text-warning"></i>
    <span class="text-warning">Naik dari kunjungan lalu</span>
  </div>
</div>
```

```css
.vital-card {
  background: white;
  border-radius: 14px;
  padding: 16px 18px;
  border: 1px solid var(--gray-200);
  text-align: center;
}

.vital-card__header {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 6px;
  margin-bottom: 10px;
}

.vital-card__title {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.06em;
  font-weight: 600;
  color: var(--text-secondary);
}

.vital-card__value {
  font-family: var(--font-heading);
  font-size: 1.875rem;
  font-weight: 800;
  color: var(--gray-900);
  line-height: 1.1;
  margin-bottom: 6px;
}

.vital-card__unit {
  font-size: 1rem;
  font-weight: 400;
  color: var(--text-secondary);
}

.vital-card__trend {
  font-size: 0.75rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 4px;
}
```

### 4.5 Tombol (Buttons)

```css
/* Primary Button */
.btn-peka-primary {
  background: var(--peka-primary);
  color: white;
  border: none;
  border-radius: 10px;
  padding: 9px 18px;
  font-size: 0.875rem;
  font-weight: 600;
  font-family: var(--font-heading);
  display: inline-flex;
  align-items: center;
  gap: 7px;
  transition: background 0.15s, transform 0.15s, box-shadow 0.15s;
  cursor: pointer;
}

.btn-peka-primary:hover {
  background: #155A5A;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(26,107,107,0.3);
  color: white;
}

/* Outline Button */
.btn-peka-outline {
  background: transparent;
  color: var(--peka-primary);
  border: 1.5px solid var(--peka-primary);
  border-radius: 10px;
  padding: 9px 18px;
  font-size: 0.875rem;
  font-weight: 600;
  font-family: var(--font-heading);
  display: inline-flex;
  align-items: center;
  gap: 7px;
  transition: all 0.15s;
}

.btn-peka-outline:hover {
  background: var(--peka-primary-pale);
  color: var(--peka-primary);
}

/* Danger / Emergency Button */
.btn-emergency {
  background: linear-gradient(135deg, #DC2626, #B91C1C);
  color: white;
  border: none;
  border-radius: 12px;
  padding: 12px 24px;
  font-size: 1rem;
  font-weight: 700;
  font-family: var(--font-heading);
  letter-spacing: 0.02em;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  animation: pulse-emergency 2s ease-in-out infinite;
  cursor: pointer;
}

@keyframes pulse-emergency {
  0%, 100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.5); }
  50%       { box-shadow: 0 0 0 10px rgba(220, 38, 38, 0); }
}

/* Rujukan Button */
.btn-rujukan {
  background: linear-gradient(135deg, #F59E0B, #D97706);
  color: white;
  border: none;
  border-radius: 10px;
  padding: 9px 18px;
  font-weight: 700;
  font-family: var(--font-heading);
  display: inline-flex;
  align-items: center;
  gap: 7px;
  transition: all 0.15s;
}

.btn-rujukan:hover {
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(217,119,6,0.3);
  color: white;
}
```

### 4.6 Form Inputs

```css
.form-control-peka {
  border: 1.5px solid var(--gray-300);
  border-radius: 10px;
  padding: 9px 13px;
  font-size: 0.875rem;
  color: var(--text-primary);
  background: white;
  transition: border-color 0.15s, box-shadow 0.15s;
  width: 100%;
}

.form-control-peka:focus {
  outline: none;
  border-color: var(--peka-primary-light);
  box-shadow: 0 0 0 3px rgba(42,143,143,0.12);
}

.form-control-peka.is-valid   { border-color: var(--risk-green); }
.form-control-peka.is-invalid { border-color: var(--risk-red); }

/* Input Group dengan Icon */
.input-group-peka {
  position: relative;
}

.input-group-peka .input-icon {
  position: absolute;
  left: 12px;
  top: 50%;
  transform: translateY(-50%);
  color: var(--text-muted);
  font-size: 0.875rem;
  pointer-events: none;
}

.input-group-peka .form-control-peka {
  padding-left: 36px;
}

/* Label dengan wajib */
.form-label-required::after {
  content: ' *';
  color: var(--risk-red);
  font-weight: 700;
}

/* Satuan di kanan input */
.input-unit {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
  font-size: 0.75rem;
  color: var(--text-muted);
  font-weight: 500;
  pointer-events: none;
}
```

### 4.7 Alert / Peringatan Inline

```html
<!-- Alert risiko di halaman kunjungan -->
<div class="alert-peka alert-peka--warning">
  <div class="alert-peka__icon"><i class="fas fa-triangle-exclamation"></i></div>
  <div class="alert-peka__body">
    <div class="alert-peka__title">Perhatian: Tekanan Darah Meningkat</div>
    <div class="alert-peka__text">Tekanan darah sistolik mendekati batas hipertensi. Pantau lebih ketat dan jadwalkan kunjungan ulang lebih cepat.</div>
  </div>
</div>
```

```css
.alert-peka {
  border-radius: 12px;
  padding: 14px 16px;
  display: flex;
  align-items: flex-start;
  gap: 12px;
  border: 1px solid transparent;
  margin-bottom: 16px;
}

.alert-peka__icon {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1rem;
  flex-shrink: 0;
}

.alert-peka__title {
  font-weight: 600;
  font-size: 0.875rem;
  margin-bottom: 3px;
}

.alert-peka__text {
  font-size: 0.8125rem;
  line-height: 1.5;
}

.alert-peka--success {
  background: var(--risk-green-bg);
  border-color: var(--risk-green-border);
  color: #0D7A35;
}
.alert-peka--success .alert-peka__icon { background: #D3F9E0; }

.alert-peka--warning {
  background: var(--risk-yellow-bg);
  border-color: var(--risk-yellow-border);
  color: #92400E;
}
.alert-peka--warning .alert-peka__icon { background: #FEF3C7; }

.alert-peka--danger {
  background: var(--risk-red-bg);
  border-color: var(--risk-red-border);
  color: #991B1B;
}
.alert-peka--danger .alert-peka__icon { background: #FEE2E2; }

.alert-peka--critical {
  background: #FFF0F0;
  border-color: #FF9090;
  color: var(--risk-critical);
  animation: blink-border 1s ease-in-out infinite;
}

@keyframes blink-border {
  0%, 100% { border-color: #FF9090; }
  50%       { border-color: #FF2222; }
}
```

---

## 5. SWEETALERT2 — KONFIGURASI STANDAR

### 5.1 Alert Sukses
```javascript
// Setelah simpan data kunjungan berhasil
Swal.fire({
  icon: 'success',
  title: 'Data Tersimpan!',
  text: 'Data kunjungan ANC berhasil dicatat.',
  confirmButtonText: 'OK',
  confirmButtonColor: '#1A6B6B',
  timer: 3000,
  timerProgressBar: true,
  showClass: { popup: 'animate__animated animate__fadeInDown' }
});
```

### 5.2 Alert Gagal / Error
```javascript
Swal.fire({
  icon: 'error',
  title: 'Gagal Menyimpan',
  text: 'Terjadi kesalahan. Silakan periksa data yang dimasukkan.',
  confirmButtonText: 'Coba Lagi',
  confirmButtonColor: '#EF4444',
});
```

### 5.3 Konfirmasi Aksi (Hapus / Rujuk)
```javascript
// Konfirmasi hapus data
Swal.fire({
  title: 'Hapus Data Kunjungan?',
  text: 'Data yang dihapus tidak bisa dikembalikan.',
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#EF4444',
  cancelButtonColor: '#64748B',
  confirmButtonText: '<i class="fas fa-trash"></i> Ya, Hapus',
  cancelButtonText: 'Batal',
  reverseButtons: true
}).then((result) => {
  if (result.isConfirmed) {
    // Lakukan delete
  }
});
```

### 5.4 Alert Peringatan Risiko Tinggi (MERAH)
```javascript
// Ditampilkan otomatis setelah sistem mendeteksi risiko tinggi
Swal.fire({
  icon: 'warning',
  title: '🚨 Terdeteksi Risiko Tinggi!',
  html: `
    <div style="text-align:left; font-size:14px;">
      <p style="font-weight:600; color:#991B1B; margin-bottom:12px;">Pasien: <strong>Siti Rahayu</strong></p>
      <ul style="padding-left:16px; color:#374151;">
        <li>Tekanan darah: <strong>155/100 mmHg</strong></li>
        <li>Protein urine: <strong>+2</strong></li>
        <li>Usia kehamilan: <strong>32 minggu</strong></li>
      </ul>
      <p style="margin-top:12px; font-weight:600; color:#92400E;">
        Pertimbangkan pembuatan surat rujukan segera.
      </p>
    </div>
  `,
  confirmButtonText: '<i class="fas fa-file-medical"></i> Buat Rujukan',
  showCancelButton: true,
  cancelButtonText: 'Pantau Dulu',
  confirmButtonColor: '#DC2626',
  cancelButtonColor: '#64748B',
  width: 480,
  customClass: {
    popup: 'swal-risk-high'
  }
});
```

### 5.5 Alert Darurat Kritis (MERAH KRITIS)
```javascript
Swal.fire({
  icon: 'error',
  title: '🆘 KONDISI DARURAT!',
  html: `
    <div style="text-align:center;">
      <p style="font-size:15px; font-weight:700; color:#7C0000;">PREEKLAMPSIA BERAT / EKLAMPSIA</p>
      <p style="color:#374151; font-size:13px;">Hubungi dokter <strong>SEGERA</strong> dan siapkan rujukan darurat.</p>
    </div>
  `,
  confirmButtonText: '📞 Hubungi Dokter & Buat Rujukan',
  confirmButtonColor: '#7C0000',
  allowOutsideClick: false,
  allowEscapeKey: false,
  customClass: { popup: 'swal-critical' }
});
```

```css
/* Custom SweetAlert styling */
.swal-risk-high { border-top: 4px solid #F59E0B !important; }
.swal-critical  { border-top: 4px solid #7C0000 !important; animation: shake 0.4s ease; }

@keyframes shake {
  0%, 100% { transform: translateX(0); }
  20%       { transform: translateX(-6px); }
  40%       { transform: translateX(6px); }
  60%       { transform: translateX(-4px); }
  80%       { transform: translateX(4px); }
}
```

### 5.6 Konfirmasi Kirim Rujukan
```javascript
Swal.fire({
  title: 'Kirim Rujukan?',
  html: `
    <p style="font-size:13px; color:#475569;">Surat rujukan untuk <strong>Siti Rahayu</strong> akan dikirim ke:</p>
    <div style="background:#F0F4F8; border-radius:8px; padding:10px; margin-top:8px; font-size:13px;">
      <strong>RSUD Dr. Soebandi Jember</strong><br>
      Poli Kandungan & Kebidanan
    </div>
  `,
  icon: 'question',
  showCancelButton: true,
  confirmButtonText: '<i class="fas fa-paper-plane"></i> Kirim Rujukan',
  cancelButtonText: 'Batal',
  confirmButtonColor: '#F59E0B',
  cancelButtonColor: '#64748B',
});
```

---

## 6. LAYOUT SIDEBAR & NAVIGASI

### 6.1 Struktur Layout Utama
```html
<div class="sipeka-layout">
  <!-- Sidebar -->
  <aside class="sipeka-sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-brand__logo">
        <i class="fas fa-heart-circle-plus"></i>
      </div>
      <div class="sidebar-brand__text">
        <span class="sidebar-brand__name">SIPEKA</span>
        <span class="sidebar-brand__sub">v1.0</span>
      </div>
    </div>
    
    <nav class="sidebar-nav">
      <div class="sidebar-nav__section">UTAMA</div>
      <a href="#" class="sidebar-nav__item active">
        <i class="fas fa-grid-2"></i>
        <span>Dasbor</span>
      </a>
      <!-- ... item lainnya -->
    </nav>
    
    <div class="sidebar-user">
      <div class="sidebar-user__avatar">BK</div>
      <div class="sidebar-user__info">
        <div class="sidebar-user__name">Bidan Kartini</div>
        <div class="sidebar-user__role">Bidan Desa</div>
      </div>
    </div>
  </aside>
  
  <!-- Main Content -->
  <main class="sipeka-main">
    <!-- Topbar -->
    <header class="sipeka-topbar"> ... </header>
    <!-- Content -->
    <div class="sipeka-content"> ... </div>
  </main>
</div>
```

### 6.2 CSS Sidebar
```css
.sipeka-layout {
  display: flex;
  min-height: 100vh;
  background: var(--bg-app);
}

.sipeka-sidebar {
  width: 256px;
  background: var(--bg-sidebar);
  display: flex;
  flex-direction: column;
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
  z-index: 100;
  overflow-y: auto;
  padding-bottom: 20px;
}

.sidebar-brand {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 22px 20px;
  border-bottom: 1px solid rgba(255,255,255,0.07);
}

.sidebar-brand__logo {
  width: 40px;
  height: 40px;
  background: var(--peka-primary);
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  color: white;
  font-size: 1.125rem;
}

.sidebar-brand__name {
  font-family: var(--font-heading);
  font-size: 1rem;
  font-weight: 800;
  color: white;
  letter-spacing: 0.04em;
  display: block;
}

.sidebar-brand__sub {
  font-size: 0.6875rem;
  color: rgba(255,255,255,0.4);
}

.sidebar-nav {
  padding: 16px 12px;
  flex: 1;
}

.sidebar-nav__section {
  font-size: 0.625rem;
  font-weight: 700;
  letter-spacing: 0.12em;
  color: rgba(255,255,255,0.3);
  text-transform: uppercase;
  padding: 12px 8px 6px;
  margin-top: 8px;
}

.sidebar-nav__item {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 12px;
  border-radius: 10px;
  text-decoration: none;
  color: rgba(255,255,255,0.6);
  font-size: 0.875rem;
  font-weight: 500;
  margin-bottom: 2px;
  transition: background 0.15s, color 0.15s;
}

.sidebar-nav__item i {
  width: 18px;
  text-align: center;
  font-size: 0.9375rem;
}

.sidebar-nav__item:hover {
  background: rgba(255,255,255,0.07);
  color: white;
}

.sidebar-nav__item.active {
  background: var(--peka-primary);
  color: white;
}

/* Badge notifikasi pada item sidebar */
.sidebar-nav__item .nav-badge {
  margin-left: auto;
  background: var(--risk-red);
  color: white;
  border-radius: 10px;
  font-size: 0.625rem;
  font-weight: 700;
  padding: 1px 6px;
  min-width: 20px;
  text-align: center;
}

.sipeka-main {
  margin-left: 256px;
  flex: 1;
  display: flex;
  flex-direction: column;
  min-width: 0;
}

.sipeka-topbar {
  background: white;
  padding: 0 24px;
  height: 64px;
  border-bottom: 1px solid var(--gray-200);
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky;
  top: 0;
  z-index: 50;
}

.sipeka-content {
  padding: 24px;
  flex: 1;
}

/* Notifikasi Bell di topbar */
.topbar-notif {
  position: relative;
  cursor: pointer;
}

.topbar-notif__dot {
  position: absolute;
  top: -2px;
  right: -2px;
  width: 8px;
  height: 8px;
  background: var(--risk-red);
  border-radius: 50%;
  border: 2px solid white;
}
```

---

## 7. CHART.JS — KONFIGURASI STANDAR

### 7.1 Grafik Tren Tekanan Darah (Line Chart)
```javascript
const ctxTD = document.getElementById('chartTekananDarah').getContext('2d');
new Chart(ctxTD, {
  type: 'line',
  data: {
    labels: ['01 Jan', '15 Jan', '01 Feb', '15 Feb', '01 Mar'],
    datasets: [
      {
        label: 'Sistolik',
        data: [118, 122, 130, 138, 155],
        borderColor: '#EF4444',
        backgroundColor: 'rgba(239,68,68,0.08)',
        borderWidth: 2.5,
        pointBackgroundColor: '#EF4444',
        pointRadius: 5,
        pointHoverRadius: 7,
        tension: 0.3,
        fill: true,
      },
      {
        label: 'Diastolik',
        data: [78, 80, 84, 88, 100],
        borderColor: '#3B5BDB',
        backgroundColor: 'rgba(59,91,219,0.06)',
        borderWidth: 2.5,
        pointBackgroundColor: '#3B5BDB',
        pointRadius: 5,
        pointHoverRadius: 7,
        tension: 0.3,
        fill: true,
      }
    ]
  },
  options: {
    responsive: true,
    interaction: { mode: 'index', intersect: false },
    plugins: {
      legend: {
        position: 'top',
        labels: { font: { family: 'Plus Jakarta Sans', size: 12 }, usePointStyle: true }
      },
      annotation: {
        annotations: {
          lineSistolik: {
            type: 'line',
            yMin: 140, yMax: 140,
            borderColor: 'rgba(239,68,68,0.4)',
            borderWidth: 1.5,
            borderDash: [6, 3],
            label: { content: 'Batas Sistolik (140)', enabled: true, position: 'end', font: { size: 10 } }
          },
          lineDiastolik: {
            type: 'line',
            yMin: 90, yMax: 90,
            borderColor: 'rgba(59,91,219,0.4)',
            borderWidth: 1.5,
            borderDash: [6, 3],
            label: { content: 'Batas Diastolik (90)', enabled: true, position: 'start', font: { size: 10 } }
          }
        }
      }
    },
    scales: {
      y: {
        beginAtZero: false,
        min: 50,
        max: 200,
        grid: { color: 'rgba(0,0,0,0.04)' },
        ticks: {
          font: { family: 'DM Sans', size: 11 },
          callback: v => v + ' mmHg'
        }
      },
      x: {
        grid: { display: false },
        ticks: { font: { family: 'DM Sans', size: 11 } }
      }
    }
  }
});
```

### 7.2 Distribusi Risiko (Doughnut Chart)
```javascript
const ctxRisiko = document.getElementById('chartDistribusiRisiko').getContext('2d');
new Chart(ctxRisiko, {
  type: 'doughnut',
  data: {
    labels: ['Risiko Rendah', 'Waspada', 'Preeklampsia', 'Kritis'],
    datasets: [{
      data: [98, 28, 12, 4],
      backgroundColor: ['#1DB954', '#F59E0B', '#EF4444', '#7C0000'],
      borderWidth: 0,
      hoverOffset: 8,
    }]
  },
  options: {
    responsive: true,
    cutout: '72%',
    plugins: {
      legend: {
        position: 'bottom',
        labels: { font: { family: 'Plus Jakarta Sans', size: 12 }, padding: 16, usePointStyle: true }
      }
    }
  }
});
```

### 7.3 Kasus Preeklampsia per Bulan (Bar Chart)
```javascript
const ctxBulanan = document.getElementById('chartKasusBulanan').getContext('2d');
new Chart(ctxBulanan, {
  type: 'bar',
  data: {
    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun'],
    datasets: [
      {
        label: 'Waspada',
        data: [5, 7, 6, 9, 8, 12],
        backgroundColor: '#FDE68A',
        borderColor: '#F59E0B',
        borderWidth: 1.5,
        borderRadius: 6,
      },
      {
        label: 'Preeklampsia',
        data: [2, 3, 2, 4, 3, 5],
        backgroundColor: '#FECACA',
        borderColor: '#EF4444',
        borderWidth: 1.5,
        borderRadius: 6,
      }
    ]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
        labels: { font: { family: 'Plus Jakarta Sans', size: 12 }, usePointStyle: true }
      }
    },
    scales: {
      x: { grid: { display: false } },
      y: {
        grid: { color: 'rgba(0,0,0,0.04)' },
        ticks: { font: { family: 'DM Sans', size: 11 } }
      }
    }
  }
});
```

---

## 8. HALAMAN-HALAMAN KHUSUS

### 8.1 Halaman Login
- Background: gradient lembut dari `#E8F5F5` ke `#FDEEF6`
- Card login centered, border-radius 20px, shadow halus
- Logo SIPEKA dengan ikon `fa-heart-circle-plus` warna teal
- Subtitle: "Sistem Skrining Preeklampsia dan Kehamilan Aman"
- Tab pilihan login: Tenaga Kesehatan | Ibu Hamil (berbeda endpoint)
- Tampilkan versi role dengan warna aksen berbeda
- Animasi fade-in dari bawah saat halaman muat

### 8.2 Dasbor Bidan
**Baris 1 — Kartu Statistik (4 kolom):**
- Total Pasien (ikon: `fa-users-line`, warna: teal)
- Kunjungan Hari Ini (ikon: `fa-calendar-check`, warna: biru)
- Pasien Risiko Tinggi (ikon: `fa-circle-exclamation`, warna: merah)
- Akan Bersalin (UK>36) (ikon: `fa-baby`, warna: rose)

**Baris 2 — Grafik:**
- Kolom kiri (8): Grafik tren TD populasi / grafik kasus bulanan
- Kolom kanan (4): Donut distribusi risiko + ringkasan angka

**Baris 3 — Tabel:**
- Daftar pasien terbaru dengan badge risiko
- Filter chip: Semua | Risiko Tinggi | Jadwal Terlewat | Akan Bersalin
- Tombol aksi per baris: Lihat, Input Kunjungan, Rujuk

### 8.3 Halaman Input Kunjungan ANC
- Dibagi dalam card/section: Identitas Pasien (readonly), Tanda Vital, Pemeriksaan Laboratorium, Catatan
- Auto-kalkulasi MAP dan status risiko secara real-time (JavaScript listener)
- Panel preview hasil skrining di sebelah kanan (sticky) yang berubah warna sesuai hasil kalkulasi
- Saat level berubah ke KUNING/MERAH, panel bergetar halus dan warna berubah
- Tombol simpan memunculkan SweetAlert konfirmasi lalu sukses/error

### 8.4 Portal Pasien (Ibu Hamil)
- Desain lebih lapang, clean, font lebih besar
- Header dengan foto profil, nama, UK saat ini, TP
- Kartu ringkasan kesehatan: TD terakhir, BB, UK, status risiko
- Timeline kunjungan (vertikal) dengan ikon dan warna
- Tombol 🆘 Lapor Darurat di posisi fixed bottom-right, merah menyala
- Modul edukasi dengan kartu gambar ilustrasi

### 8.5 Halaman Detail Pasien (Dokter/Bidan)
- Header kartu: foto/avatar, nama lengkap, NIK, usia, badge risiko saat ini
- Tab navigasi: Ringkasan | Riwayat Kunjungan | Grafik Tren | Laboratorium | Rujukan | Persalinan
- Tab Grafik: Line chart TD full-width dengan anotasi batas normal
- Tab Rujukan: Timeline status rujukan (dibuat → dikirim → diterima → selesai)

---

## 9. RESPONSIVITAS & MOBILE

```css
/* Breakpoints */
@media (max-width: 992px) {
  .sipeka-sidebar {
    transform: translateX(-100%);
    transition: transform 0.3s ease;
  }
  
  .sipeka-sidebar.is-open {
    transform: translateX(0);
  }
  
  .sipeka-main {
    margin-left: 0;
  }
}

@media (max-width: 768px) {
  .sipeka-content {
    padding: 16px;
  }
  
  .stat-card {
    flex-direction: column;
    text-align: center;
  }
  
  .page-title {
    font-size: 1.25rem;
  }
}
```

---

## 10. IKON REFERENSI (Font Awesome 6)

| Fungsi | Ikon FA |
|---|---|
| Ibu Hamil | `fa-person-pregnant` |
| Jantung / Vital | `fa-heart-pulse` |
| Tekanan Darah | `fa-gauge-high` |
| Laboratorium | `fa-flask` |
| Kalender Kunjungan | `fa-calendar-days` |
| Kunjungan ANC | `fa-stethoscope` |
| Rujukan | `fa-ambulance` |
| Darurat | `fa-triangle-exclamation` |
| Dokter | `fa-user-doctor` |
| Bidan | `fa-user-nurse` |
| Obat / Resep | `fa-pills` |
| Grafik Tren | `fa-chart-line` |
| Laporan | `fa-file-medical` |
| Edukasi | `fa-book-medical` |
| Notifikasi | `fa-bell` |
| Wilayah | `fa-map-location-dot` |
| Pengaturan | `fa-gear` |
| Logout | `fa-arrow-right-from-bracket` |
| Dasbor | `fa-grid-2` |
| Bayi | `fa-baby` |
| Surat Rujukan | `fa-paper-plane` |
| Logo Sistem | `fa-heart-circle-plus` |

---

## 11. UTILITIES & HELPER CLASSES

```css
/* Spacing tambahan */
.gap-3  { gap: 12px; }
.gap-4  { gap: 16px; }
.rounded-xl { border-radius: 16px; }
.rounded-2xl { border-radius: 20px; }

/* Shadow */
.shadow-card { box-shadow: 0 1px 3px rgba(0,0,0,0.05), 0 4px 14px rgba(0,0,0,0.05); }
.shadow-soft { box-shadow: 0 2px 20px rgba(0,0,0,0.06); }

/* Divider */
.divider-h {
  height: 1px;
  background: var(--gray-200);
  margin: 16px 0;
}

/* Empty State */
.empty-state {
  text-align: center;
  padding: 48px 24px;
  color: var(--text-muted);
}

.empty-state i {
  font-size: 2.5rem;
  margin-bottom: 12px;
  display: block;
  color: var(--gray-300);
}

/* Loading spinner bertema */
.spinner-peka {
  width: 32px;
  height: 32px;
  border: 3px solid var(--peka-primary-pale);
  border-top-color: var(--peka-primary);
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin { to { transform: rotate(360deg); } }

/* Skeleton loading */
.skeleton {
  background: linear-gradient(90deg, var(--gray-100) 25%, var(--gray-200) 50%, var(--gray-100) 75%);
  background-size: 200% 100%;
  animation: skeleton-shimmer 1.5s infinite;
  border-radius: 6px;
}

@keyframes skeleton-shimmer {
  0%   { background-position: 200% 0; }
  100% { background-position: -200% 0; }
}
```

---

## 12. BLADE LAYOUT TEMPLATE (Laravel)

### `resources/views/layouts/app.blade.php`
```html
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'SIPEKA') - Sistem Skrining Preeklampsia</title>
  
  <!-- Bootstrap 5 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <!-- Font Awesome 6 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet">
  <!-- SIPEKA Custom CSS -->
  <link rel="stylesheet" href="{{ asset('css/sipeka.css') }}">
  @stack('styles')
</head>
<body>
<div class="sipeka-layout">
  @include('layouts.partials.sidebar')
  
  <main class="sipeka-main">
    @include('layouts.partials.topbar')
    
    <div class="sipeka-content">
      @if(session('success'))
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'success',
              title: 'Berhasil!',
              text: '{{ session('success') }}',
              confirmButtonColor: '#1A6B6B',
              timer: 3000,
              timerProgressBar: true
            });
          });
        </script>
      @endif
      
      @if(session('error'))
        <script>
          document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
              icon: 'error',
              title: 'Gagal!',
              text: '{{ session('error') }}',
              confirmButtonColor: '#EF4444'
            });
          });
        </script>
      @endif
      
      @yield('content')
    </div>
  </main>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.2/dist/chart.umd.min.js"></script>
<!-- SIPEKA Custom JS -->
<script src="{{ asset('js/sipeka.js') }}"></script>
@stack('scripts')
</body>
</html>
```

---

*Dokumentasi SIPEKA Design System v1.0*  
*Gunakan panduan ini sebagai acuan tunggal untuk konsistensi UI di seluruh sistem.*
