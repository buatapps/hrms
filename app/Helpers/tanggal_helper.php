<?php

use CodeIgniter\I18n\Time;

if (!function_exists('angka_terbilang')) {
    function angka_terbilang($angka)
    {
        $huruf = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];
        if ($angka < 12) {
            return $huruf[$angka];
        } elseif ($angka < 20) {
            return $huruf[$angka - 10] . " Belas";
        } elseif ($angka < 100) {
            return $huruf[intval($angka / 10)] . " Puluh " . $huruf[$angka % 10];
        } elseif ($angka < 200) {
            return "Seratus " . angka_terbilang($angka - 100);
        } elseif ($angka < 1000) {
            return $huruf[intval($angka / 100)] . " Ratus " . angka_terbilang($angka % 100);
        } elseif ($angka < 2000) {
            return "Seribu " . angka_terbilang($angka - 1000);
        } elseif ($angka < 1000000) {
            return angka_terbilang(intval($angka / 1000)) . " Ribu " . angka_terbilang($angka % 1000);
        } elseif ($angka < 1000000000) {
            return angka_terbilang(intval($angka / 1000000)) . " Juta " . angka_terbilang($angka % 1000000);
        } else {
            return "Angka terlalu besar";
        }
    }
}

if (!function_exists('tanggal_terbilang')) {
    function tanggal_terbilang(string $tanggal): string
    {
        // Parsing tanggal
        $date = Time::createFromFormat('Y-m-d', $tanggal, 'Asia/Jakarta');
        if (!$date) return 'Format tanggal tidak valid';

        $hari = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        $bulan = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $hariNama = $hari[$date->format('l')];
        $tanggalTeks = ucfirst(strtolower(angka_terbilang((int)$date->getDay())));
        $bulanNama = $bulan[(int)$date->getMonth()];
        $tahunTeks = ucfirst(strtolower(angka_terbilang((int)$date->getYear())));

        return "{$hariNama} tanggal {$tanggalTeks} bulan {$bulanNama} tahun {$tahunTeks}";
    }
}
