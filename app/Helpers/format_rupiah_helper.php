<?php

if (!function_exists('format_rupiah')) {
    function format_rupiah($angka, $prefix = '')
    {
        if (!is_numeric($angka) || $angka === null) {
            return $prefix . '0';
        }

        return $prefix . number_format((float) $angka, 0, ',', '.');
    }
}
