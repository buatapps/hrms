<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Inventory extends BaseController
{
    public function index() {}

    public function hardware()
    {
        $hardware_category_id = 0;
        $data = [
            'title'     => 'Hardware',
            'list_data' => $this->HardwareModel->dataHardware($hardware_category_id),
            'category'  => $this->HardwareCategoryModel->findAll(),
            'hardware_category_id' => $hardware_category_id
        ];

        return view('inventory/hardware', $data);
    }

    public function hardware_search()
    {
        $hardware_category_id = $this->request->getPost('hardware_category_id');
        $data = [
            'title'     => 'Hardware',
            'list_data' => $this->HardwareModel->dataHardware($hardware_category_id),
            'category'  => $this->HardwareCategoryModel->findAll(),
            'hardware_category_id' => $hardware_category_id
        ];

        return view('inventory/hardware', $data);
    }

    public function hardware_add()
    {
        $data = [
            'title'     => 'Hardware Add',
            'category'  => $this->HardwareCategoryModel->findAll(),
            'brand'     => $this->HardwareBrandModel->findAll()
        ];

        return view('inventory/hardware_add', $data);
    }

    public function getBrandByCategory($categoryId)
    {
        $brands = $this->HardwareBrandModel
            ->where('hardware_category_id', $categoryId)
            ->findAll();

        return $this->response->setJSON($brands);
    }

    public function hardware_save()
    {
        // Upload foto jika ada
        $foto = $this->request->getFile('foto');
        $fotoName = '';

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move('inventory', $fotoName); // Pastikan foldernya ada dan writable
        }

        // Ambil prefix dari kategori
        $kategori = $this->HardwareCategoryModel->find($this->request->getPost('hardware_category_id'));
        $prefix = strtoupper($kategori->prefix ?? 'XX');

        // Cari nomor urut terakhir dengan prefix yang sama
        $last = $this->HardwareModel
            ->like('kode_asset', 'HW-' . $prefix . '-', 'after')
            ->orderBy('kode_asset', 'DESC')
            ->first();

        $lastNumber = 0;
        if ($last) {
            $parts = explode('-', $last->kode_asset);
            $lastNumber = isset($parts[2]) ? (int) $parts[2] : 0;
        }
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Generate kode asset
        $kodeAsset = 'HW-' . $prefix . '-' . $newNumber;
        // Simpan ke DB
        $this->HardwareModel->save([
            'kode_asset'            => $kodeAsset,
            'name'                  => $this->request->getPost('name'),
            'hardware_category_id'  => $this->request->getPost('hardware_category_id'),
            'hardware_brand_id'     => $this->request->getPost('hardware_brand_id'),
            'tipe'                  => $this->request->getPost('tipe'),
            'serial_number'         => $this->request->getPost('serial_number'),
            'spesifikasi'           => $this->request->getPost('spesifikasi'),
            'lokasi'                => $this->request->getPost('lokasi'),
            'pengguna'              => $this->request->getPost('pengguna'),
            'tgl_perolehan'         => $this->request->getPost('tgl_perolehan'),
            'status'                => $this->request->getPost('status'),
            'keterangan'            => $this->request->getPost('keterangan'),
            'foto'                  => $fotoName,
        ]);

        return redirect()->to(base_url('inventory/hardware'))->with('success', 'data <strong>saved</strong> successfully');
    }

    public function hardware_edit($id)
    {
        $list_data = $this->HardwareModel->where(['id' => $id])->first();
        $brand = $this->HardwareBrandModel
            ->where('hardware_category_id', $list_data->hardware_category_id)
            ->findAll();
        $data = [
            'title'     => 'Hardware Edit',
            'category'  => $this->HardwareCategoryModel->findAll(),
            'brand'     => $brand,
            'list_data' => $list_data,
        ];

        return view('inventory/hardware_edit', $data);
    }

    public function hardware_update()
    {
        $id = $this->request->getPost('id');
        // Upload foto jika ada
        $foto = $this->request->getFile('foto');
        $fotoName = '';

        if ($foto && $foto->isValid() && !$foto->hasMoved()) {
            $fotoName = $foto->getRandomName();
            $foto->move('inventory', $fotoName); // Pastikan foldernya ada dan writable
        }

        // Simpan ke DB
        $this->HardwareModel->save([
            'id'                    => $id,
            'name'                  => $this->request->getPost('name'),
            'hardware_category_id'  => $this->request->getPost('hardware_category_id'),
            'hardware_brand_id'     => $this->request->getPost('hardware_brand_id'),
            'tipe'                  => $this->request->getPost('tipe'),
            'serial_number'         => $this->request->getPost('serial_number'),
            'spesifikasi'           => $this->request->getPost('spesifikasi'),
            'lokasi'                => $this->request->getPost('lokasi'),
            'pengguna'              => $this->request->getPost('pengguna'),
            'tgl_perolehan'         => $this->request->getPost('tgl_perolehan'),
            'status'                => $this->request->getPost('status'),
            'keterangan'            => $this->request->getPost('keterangan'),
            'foto'                  => $fotoName,
        ]);

        return redirect()->to(base_url('inventory/hardware'))->with('success', 'data <strong>updated</strong> successfully');
    }

    public function hardware_delete($id)
    {
        $this->HardwareModel->delete($id);
        return redirect()->to(base_url('inventory/hardware'))->with('success', 'data <strong>deleted</strong> successfully');
    }

    public function software()
    {
        $data = [
            'title'     => 'Software',
            'list_data' => $this->SoftwareModel->findAll()

        ];

        return view('inventory/software', $data);
    }

    public function software_add()
    {
        $data = [
            'title'     => 'Software Add'
        ];

        return view('inventory/software_add', $data);
    }

    public function software_save()
    {
        // Upload lampiran jika ada
        $lampiran = $this->request->getFile('lampiran');
        $lampiranName = '';

        if ($lampiran && $lampiran->isValid() && !$lampiran->hasMoved()) {
            $lampiranName = $lampiran->getRandomName();
            $lampiran->move('inventory', $lampiranName); // folder inventory harus ada
        }

        // Ambil prefix default untuk software
        $prefix = 'SW';

        // Cari nomor urut terakhir dengan prefix yang sama
        $last = $this->SoftwareModel
            ->like('kode_asset', 'SW-', 'after')
            ->orderBy('kode_asset', 'DESC')
            ->first();

        $lastNumber = 0;
        if ($last) {
            $parts = explode('-', $last->kode_asset);
            $lastNumber = isset($parts[1]) ? (int) $parts[1] : 0;
        }
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);

        // Generate kode asset
        $kodeAsset = 'SW-' . $newNumber;

        // Simpan data
        $this->SoftwareModel->save([
            'kode_asset'       => $kodeAsset,
            'name'             => $this->request->getPost('name'),
            'vendor'           => $this->request->getPost('vendor'),
            'versi'            => $this->request->getPost('versi'),
            'license_type'     => $this->request->getPost('license_type'),
            'license_key'      => $this->request->getPost('license_key'),
            'jumlah_lisensi'   => $this->request->getPost('jumlah_lisensi'),
            'platform'         => $this->request->getPost('platform'),
            'tgl_instal'       => $this->request->getPost('tgl_install'),
            'tgl_expired'      => $this->request->getPost('tgl_expired'),
            'lokasi'           => $this->request->getPost('lokasi'),
            'pengguna'         => $this->request->getPost('pengguna'),
            'status'           => $this->request->getPost('status'),
            'keterangan'       => $this->request->getPost('keterangan'),
            'lampiran'         => $lampiranName,
        ]);

        return redirect()->to(base_url('inventory/software'))->with('success', 'Data <strong>Software</strong> berhasil disimpan');
    }

    public function software_edit($id)
    {
        $data = [
            'title'     => 'Software Edit',
            'list_data' => $this->SoftwareModel->where(['id' => $id])->first()
        ];

        return view('inventory/software_edit', $data);
    }

    public function software_update()
    {
        // Upload lampiran jika ada
        $lampiran = $this->request->getFile('lampiran');
        $lampiranName = '';

        if ($lampiran && $lampiran->isValid() && !$lampiran->hasMoved()) {
            $lampiranName = $lampiran->getRandomName();
            $lampiran->move('inventory', $lampiranName); // folder inventory harus ada
        }

        // Simpan data
        $this->SoftwareModel->save([
            'id'               => $this->request->getPost('id'),
            'name'             => $this->request->getPost('name'),
            'vendor'           => $this->request->getPost('vendor'),
            'versi'            => $this->request->getPost('versi'),
            'license_type'     => $this->request->getPost('license_type'),
            'license_key'      => $this->request->getPost('license_key'),
            'jumlah_lisensi'   => $this->request->getPost('jumlah_lisensi'),
            'platform'         => $this->request->getPost('platform'),
            'tgl_instal'       => $this->request->getPost('tgl_instal'),
            'tgl_expired'      => $this->request->getPost('tgl_expired'),
            'lokasi'           => $this->request->getPost('lokasi'),
            'pengguna'         => $this->request->getPost('pengguna'),
            'status'           => $this->request->getPost('status'),
            'keterangan'       => $this->request->getPost('keterangan'),
            'lampiran'         => $lampiranName,
        ]);

        return redirect()->to(base_url('inventory/software'))->with('success', 'Data <strong>Software</strong> berhasil diupdate');
    }

    public function software_delete($id)
    {
        $this->SoftwareModel->delete($id);
        return redirect()->to(base_url('inventory/software'))->with('success', 'Data <strong>Software</strong> berhasil didelete');
    }

    public function network()
    {
        $data = [
            'title'     => 'Network',
            'list_data' => $this->NetworkModel->findAll()
        ];

        return view('inventory/network', $data);
    }

    public function network_add()
    {
        $data = [
            'title'     => 'Network Add',
        ];

        return view('inventory/network_add', $data);
    }

    public function network_save()
    {
        // Upload lampiran jika ada
        $lampiran = $this->request->getFile('lampiran');
        $lampiranName = '';

        if ($lampiran && $lampiran->isValid() && !$lampiran->hasMoved()) {
            $lampiranName = $lampiran->getRandomName();
            $lampiran->move('inventory', $lampiranName); // folder 'inventory' harus ada
        }

        // Generate kode_asset: NW-0001, NW-0002, dst
        $last = $this->NetworkModel
            ->like('kode_asset', 'NW-', 'after')
            ->orderBy('kode_asset', 'DESC')
            ->first();

        $lastNumber = 0;
        if ($last) {
            $parts = explode('-', $last->kode_asset);
            $lastNumber = isset($parts[1]) ? (int) $parts[1] : 0;
        }
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        $kodeAsset = 'NW-' . $newNumber;

        // Simpan ke database
        $this->NetworkModel->save([
            'kode_asset'   => $kodeAsset,
            'name'         => $this->request->getPost('name'),
            'tipe'         => $this->request->getPost('tipe'),
            'ip_address'   => $this->request->getPost('ip_address'),
            'mac_address'  => $this->request->getPost('mac_address'),
            'lokasi'       => $this->request->getPost('lokasi'),
            'pengguna'     => $this->request->getPost('pengguna'),
            'keterangan'   => $this->request->getPost('keterangan'),
            'status'       => $this->request->getPost('status'),
            'lampiran'     => $lampiranName,
        ]);

        return redirect()->to(base_url('inventory/network'))->with('success', 'Data <strong>Network</strong> berhasil disimpan.');
    }

    public function network_edit($id)
    {
        $data = [
            'title'     => 'Network Edit',
            'list_data' => $this->NetworkModel->where(['id' => $id])->first()
        ];

        return view('inventory/network_edit', $data);
    }

    public function network_update()
    {
        $id = $this->request->getPost('id');

        // Handle lampiran file (optional)
        $lampiranFile = $this->request->getFile('lampiran');
        $lampiranName = '';

        if ($lampiranFile && $lampiranFile->isValid() && !$lampiranFile->hasMoved()) {
            $lampiranName = $lampiranFile->getRandomName();
            $lampiranFile->move('inventory', $lampiranName);
        }

        // Data yang diupdate
        $dataUpdate = [
            'name'          => $this->request->getPost('name'),
            'tipe'          => $this->request->getPost('tipe'),
            'ip_address'    => $this->request->getPost('ip_address'),
            'mac_address'   => $this->request->getPost('mac_address'),
            'lokasi'        => $this->request->getPost('lokasi'),
            'pengguna'      => $this->request->getPost('pengguna'),
            'keterangan'    => $this->request->getPost('keterangan'),
            'status'        => $this->request->getPost('status'),
        ];

        // Tambahkan lampiran jika ada file baru
        if ($lampiranName !== '') {
            $dataUpdate['lampiran'] = $lampiranName;
        }

        // Jalankan update
        $this->NetworkModel->update($id, $dataUpdate);

        return redirect()->to(base_url('inventory/network'))->with('success', 'Data <strong>network</strong> berhasil diperbarui.');
    }

    public function network_delete($id)
    {
        $data = $this->NetworkModel->find($id);

        if (!$data) {
            return redirect()->to(base_url('inventory/network'))->with('error', 'Data tidak ditemukan.');
        }

        $this->NetworkModel->delete($id);

        return redirect()->to(base_url('inventory/network'))->with('success', 'Data <strong>network</strong> berhasil dihapus.');
    }
}
