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

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            $service = new SkriningRisikoService();

            $puskesmas = FasilitasKesehatan::updateOrCreate(
                ['nama' => 'Puskesmas Kaliwates'],
                ['tipe' => 'Puskesmas', 'kecamatan' => 'Kaliwates', 'kabupaten' => 'Jember', 'provinsi' => 'Jawa Timur']
            );

            $polindes = FasilitasKesehatan::updateOrCreate(
                ['nama' => 'Polindes Sumbersari'],
                ['tipe' => 'Polindes', 'kecamatan' => 'Sumbersari', 'kabupaten' => 'Jember', 'provinsi' => 'Jawa Timur']
            );

            $rsud = FasilitasKesehatan::updateOrCreate(
                ['nama' => 'RSUD dr. Soebandi Jember'],
                ['tipe' => 'RSUD', 'kecamatan' => 'Patrang', 'kabupaten' => 'Jember', 'provinsi' => 'Jawa Timur']
            );

            $rsia = FasilitasKesehatan::updateOrCreate(
                ['nama' => 'RSIA Bunda Sehat'],
                ['tipe' => 'RSIA', 'kecamatan' => 'Kaliwates', 'kabupaten' => 'Jember', 'provinsi' => 'Jawa Timur']
            );

            $admin = User::updateOrCreate(
                ['email' => 'admin@sipeka.test'],
                ['name' => 'Admin SIPEKA', 'password' => 'password', 'role' => 'admin', 'fasilitas_id' => $puskesmas->id]
            );

            $bidan = User::updateOrCreate(
                ['email' => 'bidan@sipeka.test'],
                ['name' => 'Bidan Kartini', 'password' => 'password', 'role' => 'bidan', 'fasilitas_id' => $polindes->id]
            );

            $dokter = User::updateOrCreate(
                ['email' => 'dokter@sipeka.test'],
                ['name' => 'dr. Maya Prameswari, Sp.OG', 'password' => 'password', 'role' => 'dokter', 'fasilitas_id' => $rsud->id]
            );

            $dokterRsia = User::updateOrCreate(
                ['email' => 'dokter.rsia@sipeka.test'],
                ['name' => 'dr. Raka Adhitama', 'password' => 'password', 'role' => 'dokter', 'fasilitas_id' => $rsia->id]
            );

            $seedPatients = [
                [
                    'nik' => '3509015601940001',
                    'nama' => 'Siti Rahayu',
                    'tgl_lahir' => '1994-01-16',
                    'alamat' => 'Desa Kaliwates, RT 02 RW 03',
                    'no_hp' => '081234567801',
                    'tinggi_badan' => 156,
                    'golongan_darah' => 'O',
                    'hpht' => now()->subWeeks(32)->toDateString(),
                    'gpa' => [2, 1, 0],
                    'risiko' => ['keluarga_preeklampsia' => true],
                    'visits' => [
                        ['weeks_ago' => 8, 'bb' => 61.5, 'td' => [122, 78], 'protein' => 'Negatif', 'edema' => 'Tidak'],
                        ['weeks_ago' => 2, 'bb' => 64.2, 'td' => [136, 86], 'protein' => '+1', 'edema' => '+1'],
                    ],
                    'jadwal' => [now()->addDays(7)->toDateString()],
                ],
                [
                    'nik' => '3509024306000002',
                    'nama' => 'Dewi Lestari',
                    'tgl_lahir' => '2000-06-03',
                    'alamat' => 'Desa Sumbersari, Gang Melati',
                    'no_hp' => '081234567802',
                    'tinggi_badan' => 160,
                    'golongan_darah' => 'A',
                    'hpht' => now()->subWeeks(24)->toDateString(),
                    'gpa' => [1, 0, 0],
                    'risiko' => [],
                    'visits' => [
                        ['weeks_ago' => 4, 'bb' => 54.0, 'td' => [112, 72], 'protein' => 'Negatif', 'edema' => 'Tidak'],
                        ['weeks_ago' => 1, 'bb' => 55.1, 'td' => [116, 74], 'protein' => 'Negatif', 'edema' => 'Tidak'],
                    ],
                    'jadwal' => [now()->addDays(14)->toDateString()],
                ],
                [
                    'nik' => '3509036202890003',
                    'nama' => 'Nurul Hidayah',
                    'tgl_lahir' => '1989-02-22',
                    'alamat' => 'Desa Patrang, Dusun Krajan',
                    'no_hp' => '081234567803',
                    'tinggi_badan' => 152,
                    'golongan_darah' => 'B',
                    'hpht' => now()->subWeeks(35)->toDateString(),
                    'gpa' => [3, 2, 0],
                    'risiko' => ['riwayat_preeklampsia' => true, 'riwayat_hipertensi' => true],
                    'visits' => [
                        ['weeks_ago' => 6, 'bb' => 70.0, 'td' => [142, 92], 'protein' => '+1', 'edema' => '+1'],
                        ['weeks_ago' => 1, 'bb' => 73.4, 'td' => [164, 112], 'protein' => '+3', 'edema' => '+2', 'trombosit' => 92000, 'kreatinin' => 1.3, 'nyeri_kepala_hebat' => true],
                    ],
                    'jadwal' => [now()->subDays(10)->toDateString()],
                    'rujukan' => true,
                ],
                [
                    'nik' => '3509044404920004',
                    'nama' => 'Aminah Putri',
                    'tgl_lahir' => '1992-04-04',
                    'alamat' => 'Desa Ajung, dekat Balai Desa',
                    'no_hp' => '081234567804',
                    'tinggi_badan' => 150,
                    'golongan_darah' => 'AB',
                    'hpht' => now()->subWeeks(38)->toDateString(),
                    'gpa' => [2, 1, 0],
                    'risiko' => ['kehamilan_kembar' => true],
                    'visits' => [
                        ['weeks_ago' => 3, 'bb' => 67.8, 'td' => [132, 84], 'protein' => 'Negatif', 'edema' => '+1'],
                    ],
                    'jadwal' => [now()->addDays(3)->toDateString()],
                ],
                [
                    'nik' => '3509055005930005',
                    'nama' => 'Rina Marlina',
                    'tgl_lahir' => '1993-05-10',
                    'alamat' => 'Desa Gebang, RT 05 RW 01',
                    'no_hp' => '081234567805',
                    'tinggi_badan' => 158,
                    'golongan_darah' => 'O',
                    'hpht' => now()->subWeeks(41)->toDateString(),
                    'gpa' => [2, 1, 0],
                    'risiko' => [],
                    'visits' => [
                        ['weeks_ago' => 7, 'bb' => 60.2, 'td' => [118, 78], 'protein' => 'Negatif', 'edema' => 'Tidak'],
                    ],
                    'selesai' => true,
                ],
            ];

            foreach ($seedPatients as $item) {
                $user = User::updateOrCreate(
                    ['email' => $item['nik'].'@sipeka.local'],
                    ['name' => $item['nama'], 'password' => 'password', 'role' => 'pasien', 'fasilitas_id' => null]
                );

                $pasien = Pasien::updateOrCreate(
                    ['nik' => $item['nik']],
                    [
                        'user_id' => $user->id,
                        'nama' => $item['nama'],
                        'tgl_lahir' => $item['tgl_lahir'],
                        'alamat' => $item['alamat'],
                        'no_hp' => $item['no_hp'],
                        'tinggi_badan' => $item['tinggi_badan'],
                        'golongan_darah' => $item['golongan_darah'],
                        'status_pernikahan' => 'Menikah',
                        'nama_suami' => 'Bapak '.$item['nama'],
                        'bidan_id' => $bidan->id,
                    ]
                );

                $hpht = Carbon::parse($item['hpht']);
                $kehamilan = Kehamilan::updateOrCreate(
                    ['pasien_id' => $pasien->id, 'hpht' => $hpht->toDateString()],
                    [
                        'tp' => $hpht->copy()->addDays(280)->toDateString(),
                        'gravida' => $item['gpa'][0],
                        'para' => $item['gpa'][1],
                        'abortus' => $item['gpa'][2],
                        'riwayat_preeklampsia' => $item['risiko']['riwayat_preeklampsia'] ?? false,
                        'riwayat_hipertensi' => $item['risiko']['riwayat_hipertensi'] ?? false,
                        'riwayat_diabetes' => $item['risiko']['riwayat_diabetes'] ?? false,
                        'riwayat_ginjal' => $item['risiko']['riwayat_ginjal'] ?? false,
                        'riwayat_bblr' => $item['risiko']['riwayat_bblr'] ?? false,
                        'keluarga_preeklampsia' => $item['risiko']['keluarga_preeklampsia'] ?? false,
                        'kehamilan_kembar' => $item['risiko']['kehamilan_kembar'] ?? false,
                        'nullipara' => $item['gpa'][0] === 1,
                        'interval_lebih_10' => $item['risiko']['interval_lebih_10'] ?? false,
                        'status' => $item['selesai'] ?? false ? 'selesai' : 'aktif',
                    ]
                );

                $previousBb = null;
                foreach ($item['visits'] as $visit) {
                    $tanggal = now()->subWeeks($visit['weeks_ago'])->toDateString();
                    $usiaKehamilan = Carbon::parse($kehamilan->hpht)->diffInWeeks(Carbon::parse($tanggal));
                    $tinggiMeter = $pasien->tinggi_badan / 100;
                    $data = [
                        'kehamilan_id' => $kehamilan->id,
                        'bidan_id' => $bidan->id,
                        'tanggal' => $tanggal,
                        'usia_kehamilan_minggu' => max(4, min(42, $usiaKehamilan)),
                        'berat_badan' => $visit['bb'],
                        'imt' => round($visit['bb'] / ($tinggiMeter * $tinggiMeter), 2),
                        'penambahan_bb' => $previousBb ? round($visit['bb'] - $previousBb, 2) : null,
                        'tekanan_darah_sistolik' => $visit['td'][0],
                        'tekanan_darah_diastolik' => $visit['td'][1],
                        'map' => round(($visit['td'][0] + (2 * $visit['td'][1])) / 3, 2),
                        'nadi' => $visit['nadi'] ?? 84,
                        'suhu' => 36.7,
                        'respirasi' => 20,
                        'tinggi_fundus_uteri' => min(40, max(10, $usiaKehamilan - 2)),
                        'djj' => 144,
                        'edema' => $visit['edema'],
                        'protein_urine' => $visit['protein'],
                        'glukosa_urine' => 'Negatif',
                        'hb' => 11.4,
                        'trombosit' => $visit['trombosit'] ?? 180000,
                        'kreatinin' => $visit['kreatinin'] ?? 0.8,
                        'sgot' => $visit['sgot'] ?? 32,
                        'sgpt' => $visit['sgpt'] ?? 28,
                        'nyeri_kepala_hebat' => $visit['nyeri_kepala_hebat'] ?? false,
                        'gangguan_penglihatan' => $visit['gangguan_penglihatan'] ?? false,
                        'nyeri_ulu_hati' => $visit['nyeri_ulu_hati'] ?? false,
                        'edema_paru' => $visit['edema_paru'] ?? false,
                        'ada_riwayat_kejang' => $visit['ada_riwayat_kejang'] ?? false,
                        'keluhan_subjektif' => $visit['keluhan'] ?? null,
                        'catatan_bidan' => 'Pemantauan ANC rutin dan edukasi tanda bahaya.',
                    ];

                    $kunjungan = KunjunganAnc::updateOrCreate(
                        ['kehamilan_id' => $kehamilan->id, 'tanggal' => $tanggal],
                        $data
                    );

                    $risiko = $service->hitungRisiko($data);
                    SkriningRisiko::updateOrCreate(
                        ['kunjungan_id' => $kunjungan->id],
                        ['status' => $risiko['status'], 'level_risiko' => $risiko['level'], 'detail_faktor' => $risiko['peringatan']]
                    );

                    if (in_array($risiko['level'], ['KUNING', 'MERAH', 'MERAH_KRITIS'], true)) {
                        Peringatan::updateOrCreate(
                            ['pasien_id' => $pasien->id, 'kunjungan_id' => $kunjungan->id],
                            ['level' => $risiko['level'], 'deskripsi' => implode('; ', $risiko['peringatan']), 'status' => 'baru']
                        );
                    }

                    $previousBb = $visit['bb'];
                }

                foreach ($item['jadwal'] ?? [] as $tanggalRencana) {
                    JadwalKunjungan::updateOrCreate(
                        ['kehamilan_id' => $kehamilan->id, 'tanggal_rencana' => $tanggalRencana],
                        ['status' => Carbon::parse($tanggalRencana)->isPast() ? 'Terlewat' : 'Terjadwal']
                    );
                }

                if ($item['rujukan'] ?? false) {
                    $rujukan = Rujukan::updateOrCreate(
                        ['kehamilan_id' => $kehamilan->id, 'fasilitas_tujuan_id' => $rsud->id],
                        [
                            'bidan_id' => $bidan->id,
                            'dokter_id' => $dokter->id,
                            'status' => 'diterima',
                            'diagnosa_sementara' => 'Preeklampsia berat',
                            'alasan_rujukan' => 'Tekanan darah 164/112 mmHg, protein urine +3, trombosit rendah, perlu penanganan spesialis.',
                        ]
                    );

                    CatatanDokter::updateOrCreate(
                        ['rujukan_id' => $rujukan->id],
                        [
                            'dokter_id' => $dokter->id,
                            'diagnosis' => 'Preeklampsia berat pada kehamilan 35 minggu',
                            'resep' => 'MgSO4 sesuai protokol, nifedipine, observasi ketat.',
                            'catatan' => 'Pasien diterima di IGD maternal. Lanjutkan monitoring tekanan darah dan proteinuria.',
                        ]
                    );
                }

                if ($item['selesai'] ?? false) {
                    HasilPersalinan::updateOrCreate(
                        ['kehamilan_id' => $kehamilan->id],
                        [
                            'tanggal' => now()->subDays(5)->toDateString(),
                            'jenis' => 'Normal',
                            'kondisi_ibu' => 'Stabil',
                            'bb_bayi' => 3100,
                            'panjang_bayi' => 49,
                            'apgar_score' => '8/9',
                            'kondisi_bayi' => 'Hidup',
                            'komplikasi' => 'Tidak ada',
                        ]
                    );
                }
            }

            $nurul = Pasien::where('nik', '3509036202890003')->first();
            LaporanDarurat::updateOrCreate(
                ['pasien_id' => $nurul->id],
                [
                    'gejala' => ['Sakit kepala hebat', 'Pandangan kabur / kilatan cahaya'],
                    'deskripsi' => 'Keluhan muncul sejak pagi dan tekanan darah terasa meningkat.',
                    'status' => 'Diproses',
                    'bidan_id' => $bidan->id,
                ]
            );

            foreach ([
                ['Apa itu Preeklampsia?', 'Artikel', 'Preeklampsia adalah komplikasi kehamilan yang ditandai tekanan darah tinggi dan dapat disertai protein urine setelah usia kehamilan 20 minggu.'],
                ['Tanda Bahaya pada Kehamilan', 'Artikel', 'Segera hubungi bidan atau fasilitas kesehatan jika muncul sakit kepala hebat, pandangan kabur, nyeri ulu hati, bengkak mendadak, sesak, perdarahan, atau gerakan janin berkurang.'],
                ['Pola Makan Sehat untuk Ibu Hamil Hipertensi', 'Artikel', 'Batasi garam berlebihan, cukupi protein, minum air cukup, dan ikuti anjuran tenaga kesehatan untuk pemantauan tekanan darah.'],
                ['Pentingnya Kunjungan ANC Rutin', 'FAQ', 'ANC membantu mendeteksi risiko preeklampsia lebih awal melalui pemantauan tekanan darah, protein urine, berat badan, dan keluhan ibu.'],
                ['Panduan Pengukuran Tekanan Darah Mandiri', 'Video', 'Duduk tenang lima menit, posisi lengan sejajar jantung, gunakan manset sesuai ukuran lengan, dan catat hasil pengukuran.'],
            ] as $content) {
                Edukasi::updateOrCreate(
                    ['judul' => $content[0]],
                    ['kategori' => $content[1], 'konten' => $content[2], 'thumbnail' => null, 'published_at' => now()->subDays(rand(1, 20))]
                );
            }

            foreach ([
                [$bidan->id, 'Pasien risiko tinggi', 'Nurul Hidayah membutuhkan pemantauan rujukan.'],
                [$dokter->id, 'Rujukan masuk', 'Rujukan preeklampsia berat sudah masuk ke RSUD dr. Soebandi.'],
                [$admin->id, 'Seed data SIPEKA', 'Data demo lengkap berhasil dibuat.'],
            ] as $notif) {
                Notifikasi::create(['user_id' => $notif[0], 'judul' => $notif[1], 'pesan' => $notif[2]]);
            }

            AuditLog::create([
                'user_id' => $admin->id,
                'aksi' => 'seed_database',
                'model' => 'DatabaseSeeder',
                'model_id' => null,
                'detail' => ['keterangan' => 'Seed data demo lengkap SIPEKA'],
            ]);
        });
    }
}
