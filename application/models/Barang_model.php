<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Barang_model extends CI_Model
{

    public $table = 'barang';
    public $id = 'id_barang';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_barang', $q);
	$this->db->or_like('kode_barang', $q);
    $this->db->or_like('nama_barang', $q);
	$this->db->or_like('satuan', $q);
    $this->db->or_like('stok', $q);
	$this->db->or_like('kategori', $q);
    $this->db->or_like('harga_pokok', $q);
	$this->db->or_like('harga_jual', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_barang', $q);
	$this->db->or_like('kode_barang', $q);
    $this->db->or_like('nama_barang', $q);
	$this->db->or_like('satuan', $q);
    $this->db->or_like('stok', $q);
	$this->db->or_like('kategori', $q);
    $this->db->or_like('harga_pokok', $q);
	$this->db->or_like('harga_jual', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    function deleteImage($id) {
        $row = $this->get_by_id($id);
        if ($row->foto_barang != "default.png" or $row->foto_barang != "default.jpg") {
            $filename = explode(".", $row->foto_barang)[0];
            return array_map('unlink', glob(FCPATH."image/barang_view/$filename.*"));
        }
    }

    function deleteImageUp($id) {
        $row = $this->get_by_id($id);
        if ($_FILES['foto_barang']['name'] == '') {
        }elseif ($row->foto_barang != "default.png" or $row->foto_barang != "default.jpg") {
            $filename = explode(".", $row->foto)[0];
            return array_map('unlink', glob(FCPATH."image/barang_view/$filename.*"));
        }
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->deleteImageUp($id);
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->deleteImage($id);
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

/* End of file Barang_model.php */
/* Location: ./application/models/Barang_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2018-03-15 09:55:35 */
/* http://harviacode.com */