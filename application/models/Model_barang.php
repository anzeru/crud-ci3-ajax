<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Model_barang extends CI_Model
{
    function ambilData($table)
    {
        return $this->db->get($table);
    }

    function tambahData($data, $table)
    {
        $this->db->insert($table, $data);
    }

    function ambilId($data)
    {
        return $this->db
            ->where($data)
            ->get('tbl_barang')->row_array();
    }

    function updateData($id, $data)
    {

        $this->db->where('id', $id);
        $this->db->update('tbl_barang', $data);
    }

    function hapusData($id)
    {
        $this->db->where('id', $id);
        $this->db->delete('tbl_barang');
    }
}
