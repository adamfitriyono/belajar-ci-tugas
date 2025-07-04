<?php

namespace App\Controllers;

use App\Models\DiskonModel;

class DiskonController extends BaseController
{
    protected $diskonModel;

    public function __construct()
    {
        $this->diskonModel = new DiskonModel();  
    }

    // Menampilkan daftar diskon
    public function index()
    {
        $data['diskons'] = $this->diskonModel->findAll();  // Ambil semua data diskon
        return view('v_diskon', $data);  // Menampilkan view diskon
    }

    // Menampilkan form untuk menambah diskon
    public function create()
    {
        return view('diskon/create');  // Halaman untuk form tambah diskon
    }

    // Menyimpan data diskon
    public function store()
    {
        $rules = [
            'tanggal' => 'required|is_unique[diskon.tanggal]',  // Validasi tanggal unik
            'nominal' => 'required|numeric',  // Validasi nominal sebagai angka
        ];

        if ($this->validate($rules)) {
            // Menyimpan data diskon baru
            $this->diskonModel->save([
                'tanggal' => $this->request->getVar('tanggal'),
                'nominal' => $this->request->getVar('nominal'),
            ]);

            $nominal = $this->request->getVar('nominal'); 

            // Update session dengan nominal diskon terbaru
            session()->set('diskon_nominal', $nominal);

            return redirect()->to('/diskon')->with('message', 'Diskon berhasil ditambahkan.');
        } else {
            // Jika validasi gagal, kembali ke form dengan pesan error
            return redirect()->back()->withInput()->with('failed', 'Diskon untuk tanggal ini sudah ada.');
        }
    }

    // Menampilkan form untuk mengedit diskon
    public function edit($id)
    {
        $data['diskon'] = $this->diskonModel->find($id);  
        return view('diskon/edit', $data);  
    }

    // Memperbarui data diskon
    public function update($id)
    {
        $rules = [
            'nominal' => 'required|numeric', 
        ];

        if ($this->validate($rules)) {
            $this->diskonModel->update($id, [
                'nominal' => $this->request->getVar('nominal'),
            ]);
            return redirect()->to('/diskon')->with('message', 'Diskon berhasil diperbarui.');
        } else {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }

    // Menghapus diskon
    public function delete($id)
    {
        $this->diskonModel->delete($id);  
        return redirect()->to('/diskon')->with('message', 'Diskon berhasil dihapus.');
    }
}
