<?php

if (!function_exists('format_tanggal_indo')) {
    function format_tanggal_indo(string $tanggal): string
    {
        $bulanIndo = [
            'January'   => 'Januari',
            'February'  => 'Februari',
            'March'     => 'Maret',
            'April'     => 'April',
            'May'       => 'Mei',
            'June'      => 'Juni',
            'July'      => 'Juli',
            'August'    => 'Agustus',
            'September' => 'September',
            'October'   => 'Oktober',
            'November'  => 'November',
            'December'  => 'Desember',
        ];

        // Format: 01 June 2024 → ubah jadi: 01 Juni 2024
        $tanggal_en = date('d F Y', strtotime($tanggal));
        return strtr($tanggal_en, $bulanIndo);
    }
}
