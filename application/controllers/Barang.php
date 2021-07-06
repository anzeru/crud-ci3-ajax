<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
    source : 
    part 1 : https://www.youtube.com/watch?v=0KCE_u4JU9c&ab_channel=idrcorner
    part 2 : https://www.youtube.com/watch?v=WofgszvmYeM&t=42s&ab_channel=idrcorner
    part 3 : https://www.youtube.com/watch?v=ee94kJLpCoM&ab_channel=idrcorner
    part 4 : https://www.youtube.com/watch?v=JKbizw4-CQQ&ab_channel=idrcorner
    part 5 : https://www.youtube.com/watch?v=1r1VOaTlpmc&ab_channel=idrcorner 
*/


class Barang extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_barang');
    }


    public function index()
    {
        $this->load->view('barang');
    }

    public function ambilData()
    {
        $dataBarang = $this->model_barang->ambildata('tbl_barang')->result();
        echo json_encode($dataBarang);
    }

    public function tambahData()
    {
        $this->_validasi();
        $kode_barang = $this->input->post('kode_barang');
        $nama_barang = $this->input->post('nama_barang');
        $harga = $this->input->post('harga');
        $stok = $this->input->post('stok');

        $data = [
            'kode_barang'   => $kode_barang,
            'nama_barang'   => $nama_barang,
            'harga'         => $harga,
            'stok'          => $stok
        ];

        $this->model_barang->tambahData($data, 'tbl_barang');

        echo json_encode([
            'status'    => TRUE
        ]);
    }

    public function ambilID()
    {
        $id = $this->input->post('id');
        $data = [
            'id'    => $id
        ];
        $databarang = $this->model_barang->ambilId($data);

        echo json_encode($databarang);
    }

    public function ubahData()
    {

        $id = $this->input->post('id');
        $kode_barang = $this->input->post('kode_barang');
        $nama_barang = $this->input->post('nama_barang');
        $harga = $this->input->post('harga');
        $stok = $this->input->post('stok');

        if ($kode_barang == '') {
            $result['pesan'] = "Kode barang harus diisi";
        } elseif ($nama_barang == '') {
            $result['pesan'] = "Nama barang harus diisi";
        } elseif ($harga == '') {
            $result['pesan'] = "Harga harus diisi";
        } elseif ($stok == '') {
            $result['pesan'] = "Stok harus diisi";
        } else {
            $result['pesan'] = "";

            $data = [
                'kode_barang'   => $kode_barang,
                'nama_barang'   => $nama_barang,
                'harga'         => $harga,
                'stok'          => $stok
            ];

            $this->model_barang->updateData($id, $data);
        }

        echo json_encode($result);
    }

    function hapusData()
    {
        $id = $this->input->post('id');
        $this->model_barang->hapusData($id);
    }

    private function _validasi()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = TRUE;

        if ($this->input->post('kode_barang') == '') {
            $data['inputerror'][] = 'kode_barang';
            $data['error_string'][] = 'Kode barang harus diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('nama_barang') == '') {
            $data['inputerror'][] = 'nama_barang';
            $data['error_string'][] = 'Nama barang harus diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('harga') == '') {
            $data['inputerror'][] = 'harga';
            $data['error_string'][] = 'Harga harus diisi';
            $data['status'] = FALSE;
        }

        if ($this->input->post('stok') == '') {
            $data['inputerror'][] = 'stok';
            $data['error_string'][] = 'Stok harus diisi';
            $data['status'] = FALSE;
        }
        /*if($this->input->post('image') == '')
        {
            $data['inputerror'][] = 'image';
            $data['error_string'][] = 'Image is required';
            $data['status'] = FALSE;
        }*/

        if ($data['status'] === FALSE) {
            echo json_encode($data);
            exit();
        }
    }
}
