<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class WelcomeBoardVideo extends BaseController
{
    /**
     * Daftar jam istirahat (statis di code).
     */
    public $breakSchedule = ['12:00', '15:10', '18:00', '21:10', '01:00', '05:10'];

    /**
     * Tampilkan logo perusahaan di layar atau tidak.
     */
    public $showLogo = true;

    /**
     * Lokasi logo perusahaan.
     */
    public $logoPath = 'assets/images/logo.png';

    /**
     * Brand / judul di footer.
     */
    public $footerBrand = 'DiGiMaN';

    /**
     * Nama perusahaan di footer.
     */
    public $footerCompany = 'PT.Namicoh Indonesia Component';

    /**
     * Pemetaan nama hari PHP (date('l')) ke nama hari Indonesia.
     */
    private $dayMap = [
        'Sunday'    => 'Minggu',
        'Monday'    => 'Senin',
        'Tuesday'   => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday'  => 'Kamis',
        'Friday'    => 'Jumat',
        'Saturday'  => 'Sabtu'
    ];

    public function index()
    {
        $data = [
            'title'         => 'Welcome Board Video',
            'videos'        => $this->activeVideos(),
            'breakSchedule' => $this->todayBreakSchedule(),
            'showLogo'      => $this->showLogo,
            'logoPath'      => $this->logoPath,
            'footerBrand'   => $this->footerBrand,
            'footerCompany' => $this->footerCompany
        ];

        return view('welcome_board_video/view', $data);
    }

    /**
     * Ambil daftar video berstatus aktif dari database.
     */
    private function activeVideos()
    {
        $rows   = $this->DigimanVideoModel->where('status', 'aktif')->findAll();
        $videos = [];
        foreach ($rows as $row) {
            $videos[] = $row->video;
        }
        return $videos;
    }

    /**
     * Ambil jadwal istirahat untuk hari ini (hari aktual).
     */
    private function todayBreakSchedule()
    {
        $phpDay  = date('l');
        $hari    = isset($this->dayMap[$phpDay]) ? $this->dayMap[$phpDay] : $phpDay;

        $rows = $this->JamIstirahatModel->where('hari_istirahat', $hari)->orderBy('jam_istirahat', 'ASC')->findAll();

        $schedule = [];
        foreach ($rows as $row) {
            $schedule[] = date('H:i', strtotime($row->jam_istirahat));
        }

        return $schedule;
    }
}
