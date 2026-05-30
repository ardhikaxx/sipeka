<?php

namespace Database\Seeders;

use App\Models\Edukasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class EdukasiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
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

        foreach ($data as $item) {
            Edukasi::create($item);
        }
    }
}
