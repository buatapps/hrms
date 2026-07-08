<?php

if (!function_exists('jumlah_hari_kerja')) {
    /**
     * Hitung jumlah hari kerja (Senin–Jumat) dalam rentang tanggal
     *
     * @param string $startDate Format Y-m-d
     * @param string $endDate Format Y-m-d
     * @param array $liburTanggal (opsional) array list tanggal libur tambahan ['2025-06-17', ...]
     * @return int
     */
    function jumlah_hari_kerja($start, $end, $hanya_hari_kerja = true)
    {
        $start = new DateTime($start);
        $end = new DateTime($end);
        $end->modify('+1 day');

        $interval = new DateInterval('P1D');
        $period = new DatePeriod($start, $interval, $end);

        $count = 0;
        foreach ($period as $date) {
            if ($hanya_hari_kerja) {
                if ($date->format('N') < 6) {
                    $count++;
                }
            } else {
                $count++;
            }
        }

        return $count;
    }
}
