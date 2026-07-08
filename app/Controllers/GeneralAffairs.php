<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class GeneralAffairs extends BaseController
{
    public function index() {}

    public function sim()
    {
        $data = [
            'title'     => 'Data SIM',
            'list_data' => $this->SimModel->dataSim()

        ];

        return view('general_affairs/sim', $data);
    }

    public function sim_add()
    {
        $data = [
            'title'     => 'Add SIM',
            'employee'  => $this->EmployeeModel->where('employee_status_id !=', 3)->findAll()
        ];

        return view('general_affairs/sim_add', $data);
    }

    public function sim_save()
    {
        $employee_id = $this->request->getVar('employee_id');
        $tipe_sim = $this->request->getVar('tipe_sim');
        $masa_berlaku = $this->request->getVar('masa_berlaku');
        $file_sim = $this->request->getFile('file_sim');

        if ($file_sim->isValid()) {
            $simName = $file_sim->getRandomName();
            $file_sim->move('kendaraan', $simName);
        } else {
            $simName = null;
        }

        $this->SimModel->save([
            'employee_id'   => $employee_id,
            'tipe_sim'      => $tipe_sim,
            'masa_berlaku'  => $masa_berlaku,
            'file_sim'      => $simName
        ]);

        return redirect()->to(base_url('general_affairs/sim'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function sim_edit($id)
    {
        $data = [
            'title'     => 'Edit SIM',
            'employee'  => $this->EmployeeModel->where('employee_status_id !=', 3)->findAll(),
            'list_data' => $this->SimModel->where(['id' => $id])->first()
        ];

        return view('general_affairs/sim_edit', $data);
    }

    public function sim_update($id)
    {
        $employee_id = $this->request->getVar('employee_id');
        $tipe_sim = $this->request->getVar('tipe_sim');
        $masa_berlaku = $this->request->getVar('masa_berlaku');
        $file_sim = $this->request->getFile('file_sim');
        $old_file_sim = $this->request->getVar('old_file_sim');

        if (! $file_sim->isValid()) {
            $simName = $old_file_sim;
        } else {
            $simName = $file_sim->getRandomName();
            $file_sim->move('kendaraan', $simName);
        }

        $this->SimModel->save([
            'id'            => $id,
            'employee_id'   => $employee_id,
            'tipe_sim'      => $tipe_sim,
            'masa_berlaku'  => $masa_berlaku,
            'file_sim'      => $simName
        ]);

        return redirect()->to(base_url('general_affairs/sim'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function stnk()
    {
        $data = [
            'title'     => 'Data STNK',
            'list_data' => $this->StnkModel->dataStnk()
        ];

        return view('general_affairs/stnk', $data);
    }

    public function stnk_add()
    {
        $data = [
            'title'     => 'Add STNK',
            'employee'  => $this->EmployeeModel->where('employee_status_id !=', 3)->findAll()
        ];

        return view('general_affairs/stnk_add', $data);
    }

    public function stnk_save()
    {
        $employee_id = $this->request->getVar('employee_id');
        $nama_stnk = $this->request->getVar('nama_stnk');
        $kendaraan = $this->request->getVar('kendaraan');
        $nomor_plat = $this->request->getVar('nomor_plat');
        $brand = $this->request->getVar('brand');
        $tipe_kendaraan = $this->request->getVar('tipe_kendaraan');
        $masa_berlaku_pajak = $this->request->getVar('masa_berlaku_pajak');
        $masa_berlaku_plat = $this->request->getVar('masa_berlaku_plat');
        $file_stnk = $this->request->getFile('file_stnk');
        $file_stnk_pajak = $this->request->getFile('file_stnk_pajak');
        $foto_tampak_depan = $this->request->getFile('foto_tampak_depan');
        $foto_tampak_samping = $this->request->getFile('foto_tampak_samping');
        $foto_tampak_belakang = $this->request->getFile('foto_tampak_belakang');

        if ($file_stnk->isValid()) {
            $stnkName = $file_stnk->getRandomName();
            $file_stnk->move('kendaraan', $stnkName);
        } else {
            $stnkName = null;
        }

        if ($file_stnk_pajak->isValid()) {
            $stnkpajakName = $file_stnk_pajak->getRandomName();
            $file_stnk_pajak->move('kendaraan', $stnkpajakName);
        } else {
            $stnkpajakName = null;
        }

        if ($foto_tampak_depan->isValid()) {
            $fotodepanName = $foto_tampak_depan->getRandomName();
            $foto_tampak_depan->move('kendaraan', $fotodepanName);
        } else {
            $fotodepanName = null;
        }

        if ($foto_tampak_samping->isValid()) {
            $fotosampingName = $foto_tampak_samping->getRandomName();
            $foto_tampak_samping->move('kendaraan', $fotosampingName);
        } else {
            $fotosampingName = null;
        }

        if ($foto_tampak_belakang->isValid()) {
            $fotobelakangName = $foto_tampak_belakang->getRandomName();
            $foto_tampak_belakang->move('kendaraan', $fotobelakangName);
        } else {
            $fotobelakangName = null;
        }

        $this->StnkModel->save([
            'employee_id'       => $employee_id,
            'nama_stnk'         => $nama_stnk,
            'kendaraan'         => $kendaraan,
            'nomor_plat'        => $nomor_plat,
            'brand'             => $brand,
            'tipe_kendaraan'    => $tipe_kendaraan,
            'masa_berlaku_pajak' => $masa_berlaku_pajak,
            'masa_berlaku_plat' => $masa_berlaku_plat,
            'file_stnk'         => $stnkName,
            'file_stnk_pajak'   => $stnkpajakName,
            'foto_tampak_depan' => $fotodepanName,
            'foto_tampak_samping' => $fotosampingName,
            'foto_tampak_belakang' => $fotobelakangName
        ]);

        return redirect()->to(base_url('general_affairs/stnk'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function stnk_edit($id)
    {
        $data = [
            'title'     => 'Edit STNK',
            'employee'  => $this->EmployeeModel->where('employee_status_id !=', 3)->findAll(),
            'list_data' => $this->StnkModel->where(['id' => $id])->first()
        ];

        return view('general_affairs/stnk_edit', $data);
    }

    public function stnk_update($id)
    {
        $employee_id = $this->request->getVar('employee_id');
        $nama_stnk = $this->request->getVar('nama_stnk');
        $kendaraan = $this->request->getVar('kendaraan');
        $nomor_plat = $this->request->getVar('nomor_plat');
        $brand = $this->request->getVar('brand');
        $tipe_kendaraan = $this->request->getVar('tipe_kendaraan');
        $masa_berlaku_pajak = $this->request->getVar('masa_berlaku_pajak');
        $masa_berlaku_plat = $this->request->getVar('masa_berlaku_plat');
        $file_stnk = $this->request->getFile('file_stnk');
        $file_stnk_pajak = $this->request->getFile('file_stnk_pajak');
        $foto_tampak_depan = $this->request->getFile('foto_tampak_depan');
        $foto_tampak_samping = $this->request->getFile('foto_tampak_samping');
        $foto_tampak_belakang = $this->request->getFile('foto_tampak_belakang');
        $old_file_stnk = $this->request->getVar('old_file_stnk');
        $old_file_stnk_pajak = $this->request->getVar('old_file_stnk_pajak');
        $old_foto_tampak_depan = $this->request->getVar('old_foto_tampak_depan');
        $old_foto_tampak_samping = $this->request->getVar('old_foto_tampak_samping');
        $old_foto_tampak_belakang = $this->request->getVar('old_foto_tampak_belakang');

        if (! $file_stnk->isValid()) {
            $stnkName = $old_file_stnk;
        } else {
            $stnkName = $file_stnk->getRandomName();
            $file_stnk->move('kendaraan', $stnkName);
        }

        if (! $file_stnk_pajak->isValid()) {
            $stnkpajakName = $old_file_stnk_pajak;
        } else {
            $stnkpajakName = $file_stnk_pajak->getRandomName();
            $file_stnk_pajak->move('kendaraan', $stnkpajakName);
        }

        if (! $foto_tampak_depan->isValid()) {
            $fotodepanName = $old_foto_tampak_depan;
        } else {
            $fotodepanName = $foto_tampak_depan->getRandomName();
            $foto_tampak_depan->move('kendaraan', $fotodepanName);
        }

        if (! $foto_tampak_samping->isValid()) {
            $fotosampingName = $old_foto_tampak_samping;
        } else {
            $fotosampingName = $foto_tampak_samping->getRandomName();
            $foto_tampak_samping->move('kendaraan', $fotosampingName);
        }

        if (! $foto_tampak_belakang->isValid()) {
            $fotobelakangName = $old_foto_tampak_belakang;
        } else {
            $fotobelakangName = $foto_tampak_belakang->getRandomName();
            $foto_tampak_belakang->move('kendaraan', $fotobelakangName);
        }

        $this->StnkModel->save([
            'id'                => $id,
            'employee_id'       => $employee_id,
            'nama_stnk'         => $nama_stnk,
            'kendaraan'         => $kendaraan,
            'nomor_plat'        => $nomor_plat,
            'brand'             => $brand,
            'tipe_kendaraan'    => $tipe_kendaraan,
            'masa_berlaku_pajak' => $masa_berlaku_pajak,
            'masa_berlaku_plat' => $masa_berlaku_plat,
            'file_stnk'         => $stnkName,
            'file_stnk_pajak'   => $stnkpajakName,
            'foto_tampak_depan' => $fotodepanName,
            'foto_tampak_samping' => $fotosampingName,
            'foto_tampak_belakang' => $fotobelakangName
        ]);

        return redirect()->to(base_url('general_affairs/stnk'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function stnk_delete($id)
    {
        $this->StnkModel->delete($id);
        return redirect()->to(base_url('general_affairs/stnk'))->with('success', 'data <strong>deleted</strong> successfully');
    }

    public function stiker_kendaraan()
    {
        $data = [
            'title'     => 'Data Stiker Kendaraan',
            'list_data' => $this->StnkModel->dataStikerKendaraan(0),
            'division'  => $this->DivisionModel->findAll(),
            'division_id' => 0
        ];

        return view('general_affairs/stiker_kendaraan', $data);
    }

    public function search_stiker()
    {
        $division_id = $this->request->getVar('division_id');
        $data = [
            'title'     => 'Data Stiker Kendaraan',
            'list_data' => $this->StnkModel->dataStikerKendaraan($division_id),
            'division'  => $this->DivisionModel->findAll(),
            'division_id' => $division_id
        ];

        return view('general_affairs/stiker_kendaraan', $data);
    }

    public function print($id)
    {
        $employees = $this->StnkModel->dataStnkwhere($id);
        return view('general_affairs/print', ['employees' => $employees]);
    }

    public function stikerPrintAll($division_id)
    {
        $employees = $this->StnkModel->dataStnkArray($division_id);
        return view('general_affairs/print', ['employees' => $employees]);
    }

    public function print_checked()
    {
        $ids = $this->request->getPost('checked_ids');

        if (!$ids || !is_array($ids)) {
            return redirect()->back()->with('error', 'Tidak ada data yang dipilih untuk dicetak.');
        }

        // Ambil data sebagai OBJECT
        $employees = $this->StnkModel->dataStnkwherein($ids);

        return view('general_affairs/print', ['employees' => $employees]);
    }
}
