<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penjualan_model extends CI_Model
{

    public $table = 'penjualan';
    public $id = 'id_penjualan';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    function create($post)
    {
        $penjualan = $this->db->get_where('penjualan', ['nomor_invoice' => $post['no_invoice']])->row();

        if ($penjualan) {
            $this->session->set_flashdata('error', 'No Invoice Telah Digunakan');
            redirect(site_url('penjualan/create'));
        }

        $this->db->trans_begin();

        $this->db->insert('penjualan', [
            'id_user' => $this->session->userdata('id_user'),
            'id_marketplace' => $post['id_marketplace'],
            'id_status' => $post['id_status'],
            'no_pesanan' => $post['no_pesanan'],
            'nama_pelanggan' => $post['nama_pelanggan'],
            'alamat' => $post['alamat'],
            'telepon' => $post['telepon'],
            'nomor_invoice' => $post['no_invoice'],
            'tanggal' => $post['tanggal'],
            'sub_total' => str_replace('.', '', $post['sub_total']),
            'diskon' => str_replace('.', '', $post['diskon']),
            'total' => str_replace('.', '', $post['total']),
            'bayar' => str_replace('.', '', $post['bayar']),
            'keterangan' => $post['keterangan'],
        ]);

        $id_penjualan = $this->db->insert_id();

        for ($i = 0; $i < count($post['id_produk']); $i++) {
            $this->db->insert('detail_penjualan', [
                'id_penjualan' => $id_penjualan,
                'id_produk' => $post['id_produk'][$i],
                'nama_produk' => $post['nama_produk'][$i],
                'qty' => $post['qty'][$i],
                'harga_modal' => $post['harga_modal'][$i],
                'harga_jual' => $post['harga_jual'][$i],
                'total_harga' => str_replace('.', '', $post['total_harga'][$i]),
            ]);

            $this->db->set('stok', 'stok-' . $post['qty'][$i], FALSE);
            $this->db->where('id_produk', $post['id_produk'][$i]);
            $this->db->update('produk');
        }

        $this->db->trans_complete();

        return $id_penjualan;
    }

    function edit($id, $post)
    {
        $this->db->trans_begin();

        $this->db->where('id_penjualan', $id);
        $this->db->update('penjualan', [
            'id_user' => $this->session->userdata('id_user'),
            'id_marketplace' => $post['id_marketplace'],
            'id_status' => $post['id_status'],
            'no_pesanan' => $post['no_pesanan'],
            'nama_pelanggan' => $post['nama_pelanggan'],
            'alamat' => $post['alamat'],
            'telepon' => $post['telepon'],
            'nomor_invoice' => $post['no_invoice'],
            'tanggal' => $post['tanggal'],
            'sub_total' => str_replace('.', '', $post['sub_total']),
            'diskon' => str_replace('.', '', $post['diskon']),
            'total' => str_replace('.', '', $post['total']),
            'bayar' => str_replace('.', '', $post['bayar']),
            'keterangan' => $post['keterangan'],
        ]);

        $detail_penjualan = $this->db->get_where('detail_penjualan', ['id_penjualan' => $id])->result_array();
        foreach ($detail_penjualan as $row) {
            $this->db->set('stok', 'stok + ' . $row['qty'], FALSE);
            $this->db->where('id_produk', $row['id_produk']);
            $this->db->update('produk');
        }

        $this->db->delete('detail_penjualan', ['id_penjualan' => $id]);

        for ($i = 0; $i < count($post['id_produk']); $i++) {
            $this->db->insert('detail_penjualan', [
                'id_penjualan' => $id,
                'id_produk' => $post['id_produk'][$i],
                'nama_produk' => $post['nama_produk'][$i],
                'qty' => $post['qty'][$i],
                'harga_modal' => $post['harga_modal'][$i],
                'harga_jual' => $post['harga_jual'][$i],
                'total_harga' => str_replace('.', '', $post['total_harga'][$i]),
            ]);

            $this->db->set('stok', 'stok-' . $post['qty'][$i], FALSE);
            $this->db->where('id_produk', $post['id_produk'][$i]);
            $this->db->update('produk');
        }

        $this->db->trans_complete();
    }

    // get all
    function get_all($dari = '', $sampai = '', $id_status = '')
    {
        $this->db->select('*, user.id_user,marketplace.id_marketplace,status.id_status, penjualan.alamat, penjualan.telepon');
        $this->db->join('user', 'user.id_user = penjualan.id_user', 'left');
        $this->db->join('marketplace', 'marketplace.id_marketplace = penjualan.id_marketplace', 'left');
        $this->db->join('status', 'status.id_status = penjualan.id_status', 'left');
        if ($dari && $sampai) {
            $this->db->where('DATE(tanggal) >=', $dari);
            $this->db->where('DATE(tanggal) <=', $sampai);
        }
        if ($id_status) {
            $this->db->where('penjualan.id_status', $id_status);
        }
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select('*, user.id_user,marketplace.id_marketplace,status.id_status, penjualan.alamat, penjualan.telepon');
        $this->db->join('user', 'user.id_user = penjualan.id_user', 'left');
        $this->db->join('marketplace', 'marketplace.id_marketplace = penjualan.id_marketplace', 'left');
        $this->db->join('status', 'status.id_status = penjualan.id_status', 'left');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL, $dari = '', $sampai = '', $id_status = '')
    {
        $this->db->select('*, penjualan.alamat, penjualan.telepon');
        $this->db->join('user', 'user.id_user = penjualan.id_user', 'left');
        $this->db->join('marketplace', 'marketplace.id_marketplace = penjualan.id_marketplace', 'left');
        $this->db->join('status', 'status.id_status = penjualan.id_status', 'left');
        if ($dari && $sampai) {
            $this->db->where('DATE(tanggal) >=', $dari);
            $this->db->where('DATE(tanggal) <=', $sampai);
        }
        if ($id_status) {
            $this->db->where('penjualan.id_status', $id_status);
        }
        if ($q) {
            $this->db->or_like('nomor_invoice', $q);
            $this->db->or_like('no_pesanan', $q);
        }
        $this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL, $dari = '', $sampai = '', $id_status = '')
    {
        $this->db->order_by($this->id, $this->order);
        $this->db->select('*, penjualan.alamat, penjualan.telepon');
        $this->db->join('user', 'user.id_user = penjualan.id_user', 'left');
        $this->db->join('marketplace', 'marketplace.id_marketplace = penjualan.id_marketplace', 'left');
        $this->db->join('status', 'status.id_status = penjualan.id_status', 'left');
        if ($dari && $sampai) {
            $this->db->where('DATE(tanggal) >=', $dari);
            $this->db->where('DATE(tanggal) <=', $sampai);
        }
        if ($id_status) {
            $this->db->where('penjualan.id_status', $id_status);
        }
        if ($q) {
            $this->db->or_like('nomor_invoice', $q);
            $this->db->or_like('no_pesanan', $q);
        }
        $this->db->limit($limit, $start);
        $this->db->order_by($this->id, 'DESC');
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
        $detail_penjualan = $this->db->get_where('detail_penjualan', ['id_penjualan' => $id])->result_array();
        foreach ($detail_penjualan as $row) {
            $this->db->set('stok', 'stok + ' . $row['qty'], FALSE);
            $this->db->where('id_produk', $row['id_produk']);
            $this->db->update('produk');
        }

        $this->db->delete('detail_penjualan', ['id_penjualan' => $id]);

        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}

/* End of file Penjualan_model.php */
/* Location: ./application/models/Penjualan_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-12-28 13:23:46 */
/* http://harviacode.com */
