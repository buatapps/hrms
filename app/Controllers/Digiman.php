<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Digiman extends BaseController
{
    public $showLogo = true;
    public $logoPath = 'assets/images/logo.png';
    public $footerBrand = 'DiGiMaN';
    public $footerCompany = 'PT.Namicoh Indonesia Component';

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
            'title'              => 'Digiman',
            'istirahat'          => $this->JamIstirahatModel->orderBy('hari_istirahat', 'ASC')->findAll(),
            'videos'             => $this->DigimanVideoModel->orderBy('id', 'DESC')->findAll(),
            'maxUploadSize'      => $this->maxUploadSize('human'),
            'maxUploadSizeBytes' => $this->maxUploadSize('bytes')
        ];

        return view('digiman/index', $data);
    }

    private function maxUploadSize($mode)
    {
        $toBytes = function ($value) {
            $value = trim($value);
            $unit  = strtolower($value[strlen($value) - 1]);
            $size  = (int) $value;
            switch ($unit) {
                case 'g': $size *= 1024 * 1024 * 1024; break;
                case 'm': $size *= 1024 * 1024; break;
                case 'k': $size *= 1024; break;
            }
            return $size;
        };

        $bytes = min(
            $toBytes(ini_get('upload_max_filesize') ?: '2M'),
            $toBytes(ini_get('post_max_size') ?: '8M')
        );

        if ($mode === 'human') {
            if ($bytes >= 1024 * 1024 * 1024) return round($bytes / (1024 * 1024 * 1024), 1) . ' GB';
            return round($bytes / (1024 * 1024), 0) . ' MB';
        }

        return $bytes;
    }

    public function board()
    {
        $data = [
            'title'         => 'Digiman',
            'videos'        => $this->activeVideos(),
            'breakSchedule' => $this->todayBreakSchedule(),
            'showLogo'      => $this->showLogo,
            'logoPath'      => $this->logoPath,
            'footerBrand'   => $this->footerBrand,
            'footerCompany' => $this->footerCompany
        ];

        return view('digiman/board', $data);
    }

    private function activeVideos()
    {
        $rows   = $this->DigimanVideoModel->where('status', 'aktif')->findAll();
        $videos = [];
        foreach ($rows as $row) {
            $videos[] = $row->video;
        }
        return $videos;
    }

    private function todayBreakSchedule()
    {
        $phpDay = date('l');
        $hari   = isset($this->dayMap[$phpDay]) ? $this->dayMap[$phpDay] : $phpDay;

        $rows = $this->JamIstirahatModel->where('hari_istirahat', $hari)->orderBy('jam_istirahat', 'ASC')->findAll();

        $schedule = [];
        foreach ($rows as $row) {
            $schedule[] = date('H:i', strtotime($row->jam_istirahat));
        }

        return $schedule;
    }

    public function save_istirahat()
    {
        if (!$this->validate([
            'jam_istirahat'  => 'required',
            'hari_istirahat' => 'required'
        ])) {
            return redirect()->to(base_url('digiman'))->withInput()->with('tab', 'istirahat');
        }

        $id = $this->request->getPost('id');

        if ($id) {
            $this->JamIstirahatModel->update($id, [
                'jam_istirahat'  => $this->request->getPost('jam_istirahat'),
                'hari_istirahat' => $this->request->getPost('hari_istirahat')
            ]);
            return redirect()->to(base_url('digiman'))->with('success', 'Jadwal istirahat <strong>updated</strong>')->with('tab', 'istirahat');
        }

        $this->JamIstirahatModel->save([
            'jam_istirahat'  => $this->request->getPost('jam_istirahat'),
            'hari_istirahat' => $this->request->getPost('hari_istirahat')
        ]);
        return redirect()->to(base_url('digiman'))->with('success', 'Jadwal istirahat <strong>saved</strong>')->with('tab', 'istirahat');
    }

    public function delete_istirahat($id)
    {
        $this->JamIstirahatModel->delete($id);
        return redirect()->to(base_url('digiman'))->with('success', 'Jadwal istirahat <strong>deleted</strong>')->with('tab', 'istirahat');
    }

    public function save_video()
    {
        $id     = $this->request->getPost('id');
        $status = $this->request->getPost('status');
        $file   = $this->request->getFile('video_file');

        $newUploaded = false;
        $videoName   = $this->request->getPost('video_name');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $dir = FCPATH . 'assets/video/';
            if (!is_dir($dir)) {
                mkdir($dir, 0777, true);
            }
            $file->move($dir, $newName);
            $videoName   = $newName;
            $newUploaded = true;
        }

        // saat edit tanpa file baru, pertahankan nama video lama
        if (!$newUploaded && $id) {
            $old = $this->DigimanVideoModel->find($id);
            $videoName = $old ? $old->video : null;
        }

        // hapus file lama hanya jika diganti file baru
        if ($newUploaded && $id) {
            $old = $this->DigimanVideoModel->find($id);
            if ($old && $old->video && file_exists(FCPATH . 'assets/video/' . $old->video)) {
                @unlink(FCPATH . 'assets/video/' . $old->video);
            }
        }

        if (!$videoName || !$status) {
            return redirect()->to(base_url('digiman'))->withInput()->with('error', 'Video dan status wajib diisi')->with('tab', 'video');
        }

        if ($id) {
            $this->DigimanVideoModel->update($id, [
                'video'  => $videoName,
                'status' => $status
            ]);
            return redirect()->to(base_url('digiman'))->with('success', 'Video <strong>updated</strong>')->with('tab', 'video');
        }

        $this->DigimanVideoModel->save([
            'video'  => $videoName,
            'status' => $status
        ]);
        return redirect()->to(base_url('digiman'))->with('success', 'Video <strong>saved</strong>')->with('tab', 'video');
    }

    public function delete_video($id)
    {
        $row = $this->DigimanVideoModel->find($id);
        if ($row) {
            $file = FCPATH . 'assets/video/' . $row->video;
            if (file_exists($file)) {
                @unlink($file);
            }
            $this->DigimanVideoModel->delete($id);
        }
        return redirect()->to(base_url('digiman'))->with('success', 'Video <strong>deleted</strong>')->with('tab', 'video');
    }
}
