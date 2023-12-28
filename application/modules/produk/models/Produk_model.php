<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk_model extends CI_Model
{

    public $table = 'produk';
    public $id = 'id_produk';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    // datatables
    function json()
    {

        $menu = $this->uri->segment(1);
        $id_menu = $this->db->get_where('menu', ['url' => $menu])->row_array()['id_menu'];
        $id_role = $this->session->userdata('id_role');

        $this->db->select('c, u ,d');
        $this->db->where('id_menu', $id_menu);
        $this->db->where('id_role', $id_role);
        $access = $this->db->get('akses_role')->row_array();

        $this->datatables->select('id_produk,kategori.id_kategori,nama_produk,harga_modal,harga_jual,stok,gambar,keterangan,nama_kategori');
        $this->datatables->from('produk');
        //add this line for join
        //$this->datatables->join('table2', 'produk.field = table2.field');

        $this->datatables->join('kategori', 'kategori.id_kategori = produk.id_kategori');

        if ($access['u'] == '1' && $access['d'] == '1') {

            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('produk/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a href="'  . site_url('produk/update/$1') . '" class="btn btn-warning"><i class="fa fa-edit"></i></a> 
                <a data-href="'  . site_url('produk/delete/$1') . '" class="btn btn-danger hapus-data"><i class="fa fa-trash"></i></a>',
                'id_produk'
            );
        } else if ($access['u'] == '1') {

            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('produk/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a href="'  . site_url('produk/update/$1') . '" class="btn btn-warning"><i class="fa fa-edit"></i></a>',
                'id_produk'
            );
        } else if ($access['d'] == '1') {

            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('produk/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a data-href="'  . site_url('produk/delete/$1') . '" class="btn btn-danger hapus-data"><i class="fa fa-trash"></i></a>',
                'id_produk'
            );
        } else {

            $this->datatables->add_column('action', '<a href="'  . site_url('produk/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a>', 'id_produk');
        }



        if ($access['d'] == '1') {
            $this->datatables->add_column(
                'hapus_bulk',
                '<input type="checkbox" class="data_checkbox" name="data[]" value="$1">',
                'id_produk'
            );
        } else {
            $this->datatables->add_column('hapus_bulk', '', 'id_produk');
        }
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->select('*, kategori.id_kategori');
        $this->db->join('kategori', 'kategori.id_kategori = produk.id_kategori', 'left');
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select('*, kategori.id_kategori');
        $this->db->join('kategori', 'kategori.id_kategori = produk.id_kategori', 'left');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_produk', $q);
        $this->db->select('*, kategori.id_kategori');
        $this->db->join('kategori', 'kategori.id_kategori = produk.id_kategori', 'left');
        $this->db->or_like('kategori.id_kategori', $q);
        $this->db->or_like('nama_produk', $q);
        $this->db->or_like('harga_modal', $q);
        $this->db->or_like('harga_jual', $q);
        $this->db->or_like('stok', $q);
        $this->db->or_like('gambar', $q);
        $this->db->or_like('keterangan', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_produk', $q);
        $this->db->select('*, kategori.id_kategori');
        $this->db->join('kategori', 'kategori.id_kategori = produk.id_kategori', 'left');
        $this->db->or_like('kategori.id_kategori', $q);
        $this->db->or_like('nama_produk', $q);
        $this->db->or_like('harga_modal', $q);
        $this->db->or_like('harga_jual', $q);
        $this->db->or_like('stok', $q);
        $this->db->or_like('gambar', $q);
        $this->db->or_like('keterangan', $q);
        $this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}

/* End of file Produk_model.php */
/* Location: ./application/models/Produk_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-12-28 11:55:11 */
/* http://harviacode.com */
