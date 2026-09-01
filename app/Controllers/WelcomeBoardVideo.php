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

    public function index()
    {
        $data = [
            'title'         => 'Welcome Board Video',
            'videos'        => $this->scanVideos(),
            'breakSchedule' => $this->breakSchedule,
            'showLogo'      => $this->showLogo,
            'logoPath'      => $this->logoPath,
            'footerBrand'   => $this->footerBrand,
            'footerCompany' => $this->footerCompany
        ];

        return view('welcome_board_video/view', $data);
    }

    private function scanVideos()
    {
        $allowed = ['mp4', 'webm', 'mov', 'mkv', 'ogg'];
        $folder  = FCPATH . 'assets/video/';
        $videos  = [];

        if (!is_dir($folder)) {
            return $videos;
        }

        $files = scandir($folder);
        foreach ($files as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (in_array($ext, $allowed)) {
                $videos[] = $file;
            }
        }

        sort($videos);
        return $videos;
    }
}
