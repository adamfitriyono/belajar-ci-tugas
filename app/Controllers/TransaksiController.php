<?php

namespace App\Controllers;

use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;
use App\Models\ProductModel;  

class TransaksiController extends BaseController
{
    protected $cart;
    protected $client;
    protected $apiKey;
    protected $transaction;
    protected $transaction_detail;
    protected $productModel;

    function __construct()
    {
        helper('number');
        helper('form');
        $this->cart = \Config\Services::cart();
        $this->client = new \GuzzleHttp\Client();
        $this->apiKey = env('COST_KEY');
        // Menambahkan inisialisasi model
        $this->transaction = new TransactionModel(); 
        $this->transaction_detail = new TransactionDetailModel();
        $this->productModel = new ProductModel();
    }

    public function index()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();
        return view('v_keranjang', $data);
    }

    public function cart_add()
    {
        $product_id = $this->request->getPost('id');
        $product = $this->productModel->find($product_id); 
        $nominal_diskon = session()->get('diskon_nominal');  // Ambil diskon dari session

        // Jika diskon tersedia, kurangi harga produk
        if ($nominal_diskon) {
            $product['harga'] = $product['harga'] - $nominal_diskon;  // Mengurangi harga produk dengan diskon
        }

        // Menambahkan produk ke dalam cart
        $this->cart->insert(array(
            'id'        => $product_id,
            'qty'       => 1,
            'price'     => $product['harga'],
            'name'      => $product['nama'],
            'options'   => array('foto' => $product['foto'])
        ));

        // Gunakan library Cart untuk menambah produk ke dalam cart
        \Config\Services::cart()->insert($cart_data);

        session()->setflashdata('success', 'Produk berhasil ditambahkan ke keranjang. (<a href="' . base_url() . 'keranjang">Lihat</a>)');
        return redirect()->to(base_url('/'));
    }


    public function cart_clear()
    {
        $this->cart->destroy();
        session()->setflashdata('success', 'Keranjang Berhasil Dikosongkan');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_edit()
    {
        $i = 1;
        foreach ($this->cart->contents() as $value) {
            $this->cart->update(array(
                'rowid' => $value['rowid'],
                'qty'   => $this->request->getPost('qty' . $i++)
            ));
        }

        session()->setflashdata('success', 'Keranjang Berhasil Diedit');
        return redirect()->to(base_url('keranjang'));
    }

    public function cart_delete($rowid)
    {
        $this->cart->remove($rowid);
        session()->setflashdata('success', 'Keranjang Berhasil Dihapus');
        return redirect()->to(base_url('keranjang'));
    }
    
    public function checkout()
    {
        $data['items'] = $this->cart->contents();
        $data['total'] = $this->cart->total();

        return view('v_checkout', $data);
    }

    public function getLocation()
    {
            //keyword pencarian yang dikirimkan dari halaman checkout
        $search = $this->request->getGet('search');

        $response = $this->client->request(
            'GET', 
            'https://rajaongkir.komerce.id/api/v1/destination/domestic-destination?search='.$search.'&limit=50', [
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true); 
        return $this->response->setJSON($body['data']);
    }

    public function getCost()
    { 
        $destination = $this->request->getGet('destination');

        $response = $this->client->request(
            'POST', 
            'https://rajaongkir.komerce.id/api/v1/calculate/domestic-cost', [
                'multipart' => [
                    [
                        'name' => 'origin',
                        'contents' => '64999'
                    ],
                    [
                        'name' => 'destination',
                        'contents' => $destination
                    ],
                    [
                        'name' => 'weight',
                        'contents' => '1000'
                    ],
                    [
                        'name' => 'courier',
                        'contents' => 'jne'
                    ]
                ],
                'headers' => [
                    'accept' => 'application/json',
                    'key' => $this->apiKey,
                ],
            ]
        );

        $body = json_decode($response->getBody(), true); 
        return $this->response->setJSON($body['data']);
    }

    public function buy()
    {
        if ($this->request->getPost()) { 
            $dataForm = [
                'username' => $this->request->getPost('username'),
                'total_harga' => $this->request->getPost('total_harga'),
                'alamat' => $this->request->getPost('alamat'),
                'ongkir' => $this->request->getPost('ongkir'),
                'status' => 0,
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s")
            ];

            $this->transaction->insert($dataForm);
            $last_insert_id = $this->transaction->getInsertID();

            $total_diskon = 0;  // Variabel untuk menghitung total diskon

            foreach ($this->cart->contents() as $value) {
                $nominal_diskon = session()->get('diskon_nominal');  // Ambil diskon dari session
                $harga_after_discount = $value['price'];

                // Mengurangi harga produk dengan diskon
                if ($nominal_diskon) {
                    $harga_after_discount = $value['price'] - $nominal_diskon;
                }

                $dataFormDetail = [
                    'transaction_id' => $last_insert_id,
                    'product_id' => $value['id'],
                    'jumlah' => $value['qty'],
                    'diskon' => $nominal_diskon,  // Menyimpan diskon pada detail transaksi
                    'subtotal_harga' => $value['qty'] * $harga_after_discount,  // Menggunakan harga setelah diskon
                    'created_at' => date("Y-m-d H:i:s"),
                    'updated_at' => date("Y-m-d H:i:s")
                ];

                $this->transaction_detail->insert($dataFormDetail);

                // Tambahkan total diskon untuk menghitung harga total
                $total_diskon += $nominal_diskon * $value['qty'];
            }

            // Update total harga transaksi setelah diskon
            $total_harga_after_discount = $this->request->getPost('total_harga') - $total_diskon;
            $this->transaction->update($last_insert_id, ['total_harga' => $total_harga_after_discount]);

            $this->cart->destroy();

            return redirect()->to(base_url());
        }
    }


}
