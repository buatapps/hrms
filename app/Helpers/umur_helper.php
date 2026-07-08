<?php

use CodeIgniter\I18n\Time;

if (!function_exists('hitung_umur')) {
    function hitung_umur(string $tanggal_lahir): string
    {
        // Pastikan format: Y-m-d
        $lahir = Time::createFromFormat('Y-m-d', $tanggal_lahir, 'Asia/Jakarta');

        if (!$lahir) {
            return 'Tanggal lahir tidak valid';
        }

        $hari_ini = Time::now('Asia/Jakarta');

        // Dibalik: dari lahir ke sekarang
        $selisih = $lahir->difference($hari_ini);

        return "{$selisih->getYears()}";
    }
}
