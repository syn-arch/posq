<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelanggan_model extends CI_Model
{

    public $table = 'pelanggan';
    public $id = 'id_pelanggan';
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

        $this->datatables->select('id_pelanggan,nama_pelanggan,alamat,no_telepon,email');
        $this->datatables->from('pelanggan');
        //add this line for join
        //$this->datatables->join('table2', 'pelanggan.field = table2.field');


        if ($access['u'] == '1' && $access['d'] == '1') {

            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('pelanggan/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a href="'  . site_url('pelanggan/update/$1') . '" class="btn btn-warning"><i class="fa fa-edit"></i></a> 
                <a data-href="'  . site_url('pelanggan/delete/$1') . '" class="btn btn-danger hapus-data"><i class="fa fa-trash"></i></a>',
                'id_pelanggan'
            );
        } else if ($access['u'] == '1') {

            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('pelanggan/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a href="'  . site_url('pelanggan/update/$1') . '" class="btn btn-warning"><i class="fa fa-edit"></i></a>',
                'id_pelanggan'
            );
        } else if ($access['d'] == '1') {

            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('pelanggan/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a data-href="'  . site_url('pelanggan/delete/$1') . '" class="btn btn-danger hapus-data"><i class="fa fa-trash"></i></a>',
                'id_pelanggan'
            );
        } else {

            $this->datatables->add_column('action', '<a href="'  . site_url('pelanggan/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a>', 'id_pelanggan');
        }



        if ($access['d'] == '1') {
            $this->datatables->add_column(
                'hapus_bulk',
                '<input type="checkbox" class="data_checkbox" name="data[]" value="$1">',
                'id_pelanggan'
            );
        } else {
            $this->datatables->add_column('hapus_bulk', '', 'id_pelanggan');
        }
        return $this->datatables->generate();
    }

    // get all
    function get_all()
    {
        $this->db->select('*, ');
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select('*, ');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL)
    {
        $this->db->like('id_pelanggan', $q);
        $this->db->select('*, ');
        $this->db->or_like('nama_pelanggan', $q);
        $this->db->or_like('alamat', $q);
        $this->db->or_like('no_telepon', $q);
        $this->db->or_like('email', $q);
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL)
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_pelanggan', $q);
        $this->db->select('*, ');
        $this->db->or_like('nama_pelanggan', $q);
        $this->db->or_like('alamat', $q);
        $this->db->or_like('no_telepon', $q);
        $this->db->or_like('email', $q);
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

/* End of file Pelanggan_model.php */
/* Location: ./application/models/Pelanggan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-12-28 11:52:26 */
/* http://harviacode.com */
