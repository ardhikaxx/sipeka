<?php

namespace Database\Seeders;

use App\Models\AuditLog;
use App\Models\CatatanDokter;
use App\Models\Edukasi;
use App\Models\FasilitasKesehatan;
use App\Models\HasilPersalinan;
use App\Models\JadwalKunjungan;
use App\Models\Kehamilan;
use App\Models\KunjunganAnc;
use App\Models\LaporanDarurat;
use App\Models\Notifikasi;
use App\Models\Pasien;
use App\Models\Peringatan;
use App\Models\Rujukan;
use App\Models\SkriningRisiko;
use App\Models\User;
use App\Services\SkriningRisikoService;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $service = new SkriningRisikoService();

            // --- 1. EXPANDED FACILITIES (15 Units) ---
            $faskesList = [
                ['nama' => 'Puskesmas Kaliwates', 'tipe' => 'Puskesmas', 'kecamatan' => 'Kaliwates'],
                ['nama' => 'Puskesmas Patrang', 'tipe' => 'Puskesmas', 'kecamatan' => 'Patrang'],
                ['nama' => 'Puskesmas Sumbersari', 'tipe' => 'Puskesmas', 'kecamatan' => 'Sumbersari'],
                ['nama' => 'Puskesmas Ajung', 'tipe' => 'Puskesmas', 'kecamatan' => 'Ajung'],
                ['nama' => 'Puskesmas Mangli', 'tipe' => 'Puskesmas', 'kecamatan' => 'Kaliwates'],
                ['nama' => 'Puskesmas Gebang', 'tipe' => 'Puskesmas', 'kecamatan' => 'Patrang'],
                ['nama' => 'RSUD dr. Soebandi', 'tipe' => 'RSUD', 'kecamatan' => 'Patrang'],
                ['nama' => 'RSUD Balung', 'tipe' => 'RSUD', 'kecamatan' => 'Balung'],
                ['nama' => 'RSIA Bunda Sehat', 'tipe' => 'RSIA', 'kecamatan' => 'Kaliwates'],
                ['nama' => 'RSIA Srikandi', 'tipe' => 'RSIA', 'kecamatan' => 'Sumbersari'],
                ['nama' => 'Polindes Antirogo', 'tipe' => 'Polindes', 'kecamatan' => 'Sumbersari'],
                ['nama' => 'Polindes Karangrejo', 'tipe' => 'Polindes', 'kecamatan' => 'Sumbersari'],
                ['nama' => 'Polindes Tegal Besar', 'tipe' => 'Polindes', 'kecamatan' => 'Kaliwates'],
                ['nama' => 'Polindes Jember Lor', 'tipe' => 'Polindes', 'kecamatan' => 'Patrang'],
                ['nama' => 'Klinik Medika Utama', 'tipe' => 'Klinik', 'kecamatan' => 'Sumbersari'],
            ];

            $facilities = [];
            foreach ($faskesList as $f) {
                $facilities[] = FasilitasKesehatan::updateOrCreate(
                    ['nama' => $f['nama']],
                    array_merge($f, ['kabupaten' => 'Jember', 'provinsi' => 'Jawa Timur'])
                );
            }

            // --- 2. EXPANDED USERS (Staff) ---
            $admin = User::updateOrCreate(
                ['email' => 'admin@gmail.com'],
                ['name' => 'Administrator Utama', 'password' => 'password', 'role' => 'admin']
            );

            $bidans = [];
            $bidanNames = ['Bidan Kartini', 'Bidan Sari', 'Bidan Ani', 'Bidan Lestari', 'Bidan Wulan', 'Bidan Fitri', 'Bidan Ayu', 'Bidan Maya', 'Bidan Linda', 'Bidan Dewi'];
            foreach ($bidanNames as $index => $name) {
                $bidans[] = User::updateOrCreate(
                    ['email' => 'bidan'.($index+1).'@gmail.com'],
                    ['name' => $name, 'password' => 'password', 'role' => 'bidan', 'fasilitas_id' => $facilities[$index % 10]->id]
                );
            }

            $dokters = [];
            $dokterNames = ['dr. Maya Prameswari, Sp.OG', 'dr. Raka Adhitama', 'dr. Hendra Wijaya, Sp.OG', 'dr. Siska Putri, Sp.OG', 'dr. Budi Santoso'];
            foreach ($dokterNames as $index => $name) {
                $dokters[] = User::updateOrCreate(
                    ['email' => 'dokter'.($index+1).'@gmail.com'],
                    ['name' => $name, 'password' => 'password', 'role' => 'dokter', 'fasilitas_id' => $facilities[6 + $index]->id]
                );
            }

            // --- 3. MASSIVE PATIENT SEEDING (150 Patients) ---
            $firstNames = ['Siti', 'Dewi', 'Nurul', 'Aminah', 'Rina', 'Indah', 'Lani', 'Eka', 'Siska', 'Mega', 'Putri', 'Rahayu', 'Lestari', 'Hidayah', 'Marlina', 'Utami', 'Wulan', 'Fitri', 'Ayu', 'Kartika', 'Bunga', 'Cahaya', 'Dian', 'Endah', 'Gita', 'Hana', 'Intan', 'Juwita', 'Kania', 'Laras'];
            $lastNames = ['Rahayu', 'Lestari', 'Hidayah', 'Putri', 'Marlina', 'Sari', 'Wijaya', 'Kusuma', 'Pratiwi', 'Anggraini', 'Sulistyo', 'Wulandari', 'Permata', 'Shalihah', 'Aulia'];
            $villages = ['Kaliwates', 'Sumbersari', 'Patrang', 'Ajung', 'Gebang', 'Antirogo', 'Jember Lor', 'Tegal Besar', 'Mangli', 'Karangrejo', 'Wirolegi', 'Kranjingan'];

            for ($i = 1; $i <= 150; $i++) {
                $nik = '3509' . str_pad($i + rand(100000000000, 900000000000), 12, '0', STR_PAD_LEFT);
                $nama = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
                $email = Str::slug($nama) . $i . '@sipeka.local';

                $user = User::create([
                    'name' => $nama,
                    'email' => $email,
                    'password' => 'password',
                    'role' => 'pasien'
                ]);

                $pasien = Pasien::create([
                    'user_id' => $user->id,
                    'nik' => $nik,
                    'nama' => $nama,
                    'tgl_lahir' => Carbon::now()->subYears(rand(19, 42))->subDays(rand(1, 365))->toDateString(),
                    'alamat' => 'Desa ' . $villages[array_rand($villages)] . ', RT ' . rand(1, 10) . ' RW ' . rand(1, 15),
                    'no_hp' => '08' . rand(11, 19) . rand(10000000, 99999999),
                    'tinggi_badan' => rand(142, 175),
                    'golongan_darah' => ['A', 'B', 'AB', 'O'][rand(0, 3)],
                    'status_pernikahan' => 'Menikah',
                    'nama_suami' => 'Bapak ' . $lastNames[array_rand($lastNames)],
                    'bidan_id' => $bidans[array_rand($bidans)]->id,
                ]);

                // --- 4. VARIATIVE PREGNANCY STATUS ---
                $roll = rand(1, 100);
                if ($roll <= 20) {
                    $status = 'selesai'; // 20% finished
                    $hpht = Carbon::now()->subWeeks(rand(42, 60));
                } elseif ($roll <= 30) {
                    $status = 'aktif'; // 10% very early
                    $hpht = Carbon::now()->subWeeks(rand(4, 12));
                } else {
                    $status = 'aktif'; // 70% middle to late
                    $hpht = Carbon::now()->subWeeks(rand(13, 40));
                }

                $kehamilan = Kehamilan::create([
                    'pasien_id' => $pasien->id,
                    'hpht' => $hpht->toDateString(),
                    'tp' => $hpht->copy()->addDays(280)->toDateString(),
                    'gravida' => rand(1, 5),
                    'para' => rand(0, 4),
                    'abortus' => rand(0, 2),
                    'riwayat_preeklampsia' => rand(1, 10) > 8,
                    'riwayat_hipertensi' => rand(1, 10) > 9,
                    'riwayat_diabetes' => rand(1, 10) > 9,
                    'riwayat_ginjal' => rand(1, 100) > 97,
                    'keluarga_preeklampsia' => rand(1, 10) > 8,
                    'kehamilan_kembar' => rand(1, 10) > 9,
                    'nullipara' => false,
                    'interval_lebih_10' => rand(1, 10) > 9,
                    'status' => $status,
                ]);

                // --- 5. ANC JOURNEY SEEDING ---
                $visitInterval = 4; // weeks
                $maxPossibleVisits = floor($hpht->diffInWeeks(now()) / $visitInterval);
                $visitCount = min(rand(1, 8), $maxPossibleVisits);
                
                $previousBb = $pasien->tinggi_badan - 100 + rand(-5, 10);
                
                for ($v = 1; $v <= $visitCount; $v++) {
                    $visitDate = $hpht->copy()->addWeeks($v * $visitInterval)->addDays(rand(-3, 3));
                    if ($visitDate->gt(now())) continue;

                    $uk_minggu = $hpht->diffInWeeks($visitDate);
                    
                    // Clinical Logic Variation
                    $isComplicated = rand(1, 100) > 75; // 25% chance of health issues appearing
                    $sistolik = $isComplicated ? rand(140, 190) : rand(105, 125);
                    $diastolik = $isComplicated ? rand(90, 120) : rand(65, 85);
                    $protein = $isComplicated ? (['+1', '+2', '+3', '+4'][rand(0, 3)]) : 'Negatif';
                    
                    $bb = $previousBb + rand(1, 2);
                    $tinggiMeter = $pasien->tinggi_badan / 100;
                    
                    $ancData = [
                        'kehamilan_id' => $kehamilan->id,
                        'bidan_id' => $pasien->bidan_id,
                        'tanggal' => $visitDate->toDateString(),
                        'usia_kehamilan_minggu' => $uk_minggu,
                        'berat_badan' => $bb,
                        'imt' => round($bb / ($tinggiMeter * $tinggiMeter), 2),
                        'penambahan_bb' => $v > 1 ? round($bb - $previousBb, 2) : null,
                        'tekanan_darah_sistolik' => $sistolik,
                        'tekanan_darah_diastolik' => $diastolik,
                        'map' => round(($sistolik + (2 * $diastolik)) / 3, 2),
                        'nadi' => rand(78, 105),
                        'suhu' => 36.4 + (rand(0, 12) / 10),
                        'respirasi' => rand(18, 26),
                        'tinggi_fundus_uteri' => max(12, $uk_minggu - rand(1, 3)),
                        'djj' => rand(125, 160),
                        'edema' => $isComplicated ? (['+1', '+2'][rand(0, 1)]) : 'Tidak',
                        'protein_urine' => $protein,
                        'glukosa_urine' => rand(1, 10) > 9 ? 'Positif' : 'Negatif',
                        'hb' => 10.5 + (rand(0, 30) / 10),
                        'trombosit' => $isComplicated ? rand(60000, 130000) : rand(160000, 400000),
                        'kreatinin' => $isComplicated ? rand(10, 16)/10 : 0.7,
                        'nyeri_kepala_hebat' => $isComplicated && rand(1, 2) == 1,
                        'gangguan_penglihatan' => $isComplicated && rand(1, 3) == 1,
                        'nyeri_ulu_hati' => $isComplicated && rand(1, 3) == 1,
                        'catatan_bidan' => 'Pemeriksaan rutin. ' . ($isComplicated ? 'Waspada gejala PE.' : 'Kondisi ibu baik.'),
                    ];

                    $kunjungan = KunjunganAnc::create($ancData);
                    $risiko = $service->hitungRisiko($ancData);
                    
                    SkriningRisiko::create([
                        'kunjungan_id' => $kunjungan->id,
                        'status' => $risiko['status'],
                        'level_risiko' => $risiko['level'],
                        'detail_faktor' => $risiko['peringatan']
                    ]);

                    if ($risiko['level'] !== 'HIJAU') {
                        Peringatan::create([
                            'pasien_id' => $pasien->id,
                            'kunjungan_id' => $kunjungan->id,
                            'level' => $risiko['level'],
                            'deskripsi' => implode(', ', $risiko['peringatan']),
                            'status' => rand(1, 10) > 4 ? 'selesai' : 'baru'
                        ]);

                        // --- 6. REFERRAL LOGIC ---
                        if (in_array($risiko['level'], ['MERAH', 'MERAH_KRITIS']) && rand(1, 10) > 3) {
                            $rujukan = Rujukan::create([
                                'kehamilan_id' => $kehamilan->id,
                                'bidan_id' => $pasien->bidan_id,
                                'fasilitas_tujuan_id' => $facilities[rand(6, 9)]->id,
                                'dokter_id' => $dokters[array_rand($dokters)]->id,
                                'status' => ['dikirim', 'diterima', 'selesai'][rand(0, 2)],
                                'diagnosa_sementara' => $risiko['status'],
                                'alasan_rujukan' => 'Ditemukan komplikasi ' . $risiko['level'] . '. TD ' . $sistolik . '/' . $diastolik . ', Prot: ' . $protein,
                            ]);

                            if ($rujukan->status === 'selesai') {
                                CatatanDokter::create([
                                    'rujukan_id' => $rujukan->id,
                                    'dokter_id' => $rujukan->dokter_id,
                                    'diagnosis' => 'Preeklampsia Akut',
                                    'resep' => 'Protokol MgSO4, Anti-hipertensi, Bedrest.',
                                    'catatan' => 'Observasi 24 jam ketat. Jika stabil boleh kontrol ke Puskesmas.'
                                ]);
                            }
                        }
                    }
                    $previousBb = $bb;
                }

                // --- 7. PERSALINAN ---
                if ($status === 'selesai') {
                    HasilPersalinan::create([
                        'kehamilan_id' => $kehamilan->id,
                        'tanggal' => $hpht->copy()->addWeeks(rand(37, 41))->toDateString(),
                        'jenis' => ['Normal', 'SC', 'Vakum', 'Forceps'][rand(0, 3)],
                        'kondisi_ibu' => 'Stabil',
                        'bb_bayi' => rand(2400, 4100),
                        'panjang_bayi' => rand(46, 54),
                        'apgar_score' => '8/9',
                        'kondisi_bayi' => 'Hidup',
                        'komplikasi' => rand(1, 10) > 8 ? 'Perdarahan Ringan' : 'Tidak ada'
                    ]);
                }

                // --- 8. EMERGENCY & SCHEDULES ---
                if (rand(1, 100) > 92) {
                    LaporanDarurat::create([
                        'pasien_id' => $pasien->id,
                        'bidan_id' => $pasien->bidan_id,
                        'gejala' => [['Sakit kepala hebat'], ['Kejang-kejang'], ['Sesak napas']][rand(0, 2)],
                        'deskripsi' => 'Pasien tiba-tiba merasa tidak enak badan dan pandangan kabur.',
                        'status' => ['Dikirim', 'Diproses', 'Ditangani'][rand(0, 2)]
                    ]);
                }

                if ($status === 'aktif') {
                    JadwalKunjungan::create([
                        'kehamilan_id' => $kehamilan->id,
                        'tanggal_rencana' => Carbon::now()->addDays(rand(-5, 25))->toDateString(),
                        'status' => 'Terjadwal'
                    ]);
                }
            }

            // --- 9. RICH AUDIT LOGS ---
            foreach ($bidans as $b) {
                AuditLog::create(['user_id' => $b->id, 'aksi' => 'login', 'model' => 'User', 'detail' => ['ip' => '127.0.0.1']]);
                AuditLog::create(['user_id' => $b->id, 'aksi' => 'create', 'model' => 'KunjunganAnc', 'detail' => ['keterangan' => 'Pencatatan rutin']]);
            }

            AuditLog::create([
                'user_id' => $admin->id,
                'aksi' => 'ULTRA_SEEDING',
                'model' => 'System',
                'detail' => ['patients' => 150, 'facilities' => 15, 'visits' => 'Hundreds']
            ]);

            // --- 10. EDUKASI DATA ---
            $edukasiData = [
                [
                    'judul' => 'Pentingnya Asam Folat Bagi Ibu Hamil',
                    'konten' => 'Asam folat sangat penting untuk perkembangan saraf janin...',
                    'kategori' => 'Artikel',
                    'thumbnail' => 'edukasi/asam-folat.jpg',
                    'published_at' => Carbon::now(),
                ],
                [
                    'judul' => 'Tips Mengatasi Mual di Trimester Pertama',
                    'konten' => 'Mual di pagi hari atau morning sickness adalah hal yang wajar...',
                    'kategori' => 'Artikel',
                    'thumbnail' => 'edukasi/mual-tips.jpg',
                    'published_at' => Carbon::now(),
                ],
                [
                    'judul' => 'Senam Hamil: Gerakan Aman di Rumah',
                    'konten' => 'Menjaga kebugaran selama kehamilan sangat penting untuk persalinan...',
                    'kategori' => 'Video',
                    'thumbnail' => 'edukasi/senam-hamil.jpg',
                    'published_at' => Carbon::now(),
                ],
                [
                    'judul' => 'Gizi Seimbang untuk Pertumbuhan Janin',
                    'konten' => 'Pola makan bergizi seimbang mendukung kesehatan ibu dan bayi...',
                    'kategori' => 'Infografis',
                    'thumbnail' => 'edukasi/gizi-bumil.jpg',
                    'published_at' => Carbon::now(),
                ],
                [
                    'judul' => 'Tanda-tanda Bahaya dalam Kehamilan',
                    'konten' => 'Segera hubungi fasilitas kesehatan jika Anda mengalami gejala berikut...',
                    'kategori' => 'Artikel',
                    'thumbnail' => 'edukasi/bahaya-kehamilan.jpg',
                    'published_at' => Carbon::now(),
                ],
                [
                    'judul' => 'Persiapan Psikologis Menjelang Persalinan',
                    'konten' => 'Kesehatan mental ibu sama pentingnya dengan kesehatan fisik...',
                    'kategori' => 'Artikel',
                    'thumbnail' => 'edukasi/psikologi-ibu.jpg',
                    'published_at' => Carbon::now(),
                ],
                [
                    'judul' => 'Manfaat Inisiasi Menyusu Dini (IMD)',
                    'konten' => 'IMD membantu membangun ikatan antara ibu dan bayi segera setelah lahir...',
                    'kategori' => 'Video',
                    'thumbnail' => 'edukasi/imd-manfaat.jpg',
                    'published_at' => Carbon::now(),
                ],
                [
                    'judul' => 'Jadwal Pemeriksaan Kehamilan (ANC)',
                    'konten' => 'Minimal dilakukan 6 kali pemeriksaan selama masa kehamilan...',
                    'kategori' => 'Infografis',
                    'thumbnail' => 'edukasi/jadwal-anc.jpg',
                    'published_at' => Carbon::now(),
                ],
                [
                    'judul' => 'Mitos vs Fakta Kehamilan',
                    'konten' => 'Banyak beredar informasi yang kurang tepat mengenai pantangan ibu hamil...',
                    'kategori' => 'Artikel',
                    'thumbnail' => 'edukasi/mitos-kehamilan.jpg',
                    'published_at' => Carbon::now(),
                ],
                [
                    'judul' => 'Cara Merawat Bayi Baru Lahir',
                    'konten' => 'Panduan lengkap merawat tali pusat dan memandikan bayi dengan aman...',
                    'kategori' => 'Video',
                    'thumbnail' => 'edukasi/rawat-bayi.jpg',
                    'published_at' => Carbon::now(),
                ],
            ];

            foreach ($edukasiData as $item) {
                Edukasi::create($item);
            }
        });
    }
}
