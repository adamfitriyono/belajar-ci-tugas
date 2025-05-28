<?php

namespace App\Controllers;

use App\Models\ProductCategoryModel;

class ProdukKategoriController extends BaseController
{
    protected $product_category; 

    function __construct()
    {
        $this->product_category = new ProductCategoryModel();
    }

    public function index()
    {
        $product_category = $this->product_category->findAll();
        $data['product_category'] = $product_category;

        return view('v_produkkategori', $data);
    }
    public function create()
    {
        $dataGambar = $this->request->getFile('gambar');

        $dataForm = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'dibuat_pada' => date("Y-m-d H:i:s")
        ];

        if ($dataGambar->isValid()) {
            $fileName = $dataGambar->getRandomName();
            $dataForm['gambar'] = $fileName;
            $dataGambar->move('img/', $fileName);
        }

        $this->product_category->insert($dataForm);

        return redirect('produkkategori')->with('success', 'Data Berhasil Ditambah');
    } 
    public function edit($id)
    {
        $dataProdukKategori = $this->product_category->find($id);

        $dataForm = [
            'nama_kategori' => $this->request->getPost('nama_kategori'),
            'deskripsi' => $this->request->getPost('deskripsi'),
            'dibuat_pada' => date("Y-m-d H:i:s")
        ];

        if ($this->request->getPost('check') == 1) {
            if ($dataProdukKategori['gambar'] != '' and file_exists("img/" . $dataProdukKategori['gambar'] . "")) {
                unlink("img/" . $dataProdukKategori['gambar']);
            }

            $dataGambar = $this->request->getFile('foto');

            if ($dataGambar->isValid()) {
                $fileName = $dataGambar->getRandomName();
                $dataGambar->move('img/', $fileName);
                $dataForm['gambar'] = $fileName;
            }
        }

        $this->product_category->update($id, $dataForm);

        return redirect('produkkategori')->with('success', 'Data Berhasil Diubah Woi');
    }

    public function delete($id)
    {
        $dataProdukKategori = $this->product_category->find($id);

        if ($dataProdukKategori['gambar'] != '' and file_exists("img/" . $dataProdukKategori['gambar'] . "")) {
            unlink("img/" . $dataProdukKategori['gambar']);
        }

        $this->product_category->delete($id);

        return redirect('produkkategori')->with('success', 'Data Berhasil Dihapus Woi');
    }
}