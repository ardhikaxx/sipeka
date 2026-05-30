<?php

namespace App\Services;

class SkriningRisikoService
{
    public function hitungRisiko(array $data): array
    {
        $sistolik = (int) $data['tekanan_darah_sistolik'];
        $diastolik = (int) $data['tekanan_darah_diastolik'];
        $uk = (int) $data['usia_kehamilan_minggu'];
        $protein = $this->parseProteinUrine($data['protein_urine']);
        $trombosit = $data['trombosit'] ?? null;
        $kreatinin = $data['kreatinin'] ?? null;
        $sgot = $data['sgot'] ?? null;
        $sgpt = $data['sgpt'] ?? null;
        $adaKejang = (bool) ($data['ada_riwayat_kejang'] ?? false);
        $edemaParu = (bool) ($data['edema_paru'] ?? false);
        $gejalaBerat = (bool) ($data['nyeri_kepala_hebat'] ?? false)
            || (bool) ($data['gangguan_penglihatan'] ?? false)
            || (bool) ($data['nyeri_ulu_hati'] ?? false);

        $hipertensi = $sistolik >= 140 || $diastolik >= 90;

        if ($adaKejang && $hipertensi) {
            return $this->formatResult('EKLAMPSIA', 'MERAH_KRITIS', [
                'Kejang dengan hipertensi. Tindakan darurat dan rujukan segera diperlukan.',
            ]);
        }

        $hipertensiBerat = $sistolik >= 160 || $diastolik >= 110;
        if ($hipertensiBerat && $uk >= 20) {
            $peringatan = ['Tekanan darah sangat tinggi (>=160/110 mmHg)'];

            if ($protein >= 2) {
                $peringatan[] = 'Proteinuria berat (>=+2)';
            }

            if (! is_null($trombosit) && $trombosit < 100000) {
                $peringatan[] = 'Trombositopenia (<100.000/uL)';
            }

            if (! is_null($kreatinin) && $kreatinin > 1.1) {
                $peringatan[] = 'Gangguan fungsi ginjal';
            }

            if ((! is_null($sgot) && $sgot > 80) || (! is_null($sgpt) && $sgpt > 80)) {
                $peringatan[] = 'Enzim hati meningkat (>2x batas normal)';
            }

            if ($edemaParu) {
                $peringatan[] = 'Terdapat tanda edema paru';
            }

            if ($gejalaBerat) {
                $peringatan[] = 'Gejala berat: nyeri kepala/gangguan penglihatan/nyeri ulu hati';
            }

            return $this->formatResult('PREEKLAMPSIA_BERAT', 'MERAH', $peringatan);
        }

        if ($hipertensi && $protein >= 1 && $uk >= 20) {
            return $this->formatResult('PREEKLAMPSIA', 'MERAH', [
                'Hipertensi dengan proteinuria positif',
            ]);
        }

        if ($hipertensi && $uk >= 20) {
            return $this->formatResult('HIPERTENSI_GESTASIONAL', 'KUNING', [
                'Tekanan darah tinggi tanpa proteinuria',
            ]);
        }

        if ($sistolik >= 130 || $diastolik >= 80) {
            return $this->formatResult('WASPADA_HIPERTENSI', 'KUNING', [
                'Tekanan darah mendekati batas hipertensi',
            ]);
        }

        if ($protein >= 1) {
            return $this->formatResult('WASPADA_PROTEIN', 'KUNING', [
                'Proteinuria terdeteksi, pantau tekanan darah',
            ]);
        }

        return $this->formatResult('NORMAL', 'HIJAU', []);
    }

    public function hitungRisikoAwal($kehamilan, ?int $usiaTahun = null, ?float $imt = null): array
    {
        $faktorTinggi = [
            'Riwayat preeklampsia' => (bool) $kehamilan->riwayat_preeklampsia,
            'Kehamilan kembar' => (bool) $kehamilan->kehamilan_kembar,
            'Penyakit ginjal kronis' => (bool) $kehamilan->riwayat_ginjal,
            'Diabetes mellitus' => (bool) $kehamilan->riwayat_diabetes,
            'Hipertensi kronis' => (bool) $kehamilan->riwayat_hipertensi,
        ];

        $faktorModerat = [
            'Nullipara' => (bool) $kehamilan->nullipara,
            'Obesitas (IMT > 30)' => ! is_null($imt) && $imt > 30,
            'Riwayat keluarga preeklampsia' => (bool) $kehamilan->keluarga_preeklampsia,
            'Usia ibu > 35 tahun' => ! is_null($usiaTahun) && $usiaTahun > 35,
            'Interval kehamilan > 10 tahun' => (bool) $kehamilan->interval_lebih_10,
        ];

        $tinggi = array_keys(array_filter($faktorTinggi));
        $moderat = array_keys(array_filter($faktorModerat));

        return [
            'level' => count($tinggi) >= 1 || count($moderat) >= 2 ? 'TINGGI' : 'RENDAH',
            'faktor_tinggi' => $tinggi,
            'faktor_moderat' => $moderat,
            'skor' => (count($tinggi) * 3) + count($moderat),
        ];
    }

    private function parseProteinUrine(string $value): int
    {
        return match ($value) {
            '+1' => 1,
            '+2' => 2,
            '+3' => 3,
            '+4' => 4,
            default => 0,
        };
    }

    private function formatResult(string $status, string $level, array $peringatan): array
    {
        return [
            'status' => $status,
            'level' => $level,
            'peringatan' => $peringatan,
        ];
    }
}
