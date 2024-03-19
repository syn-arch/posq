<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class pembelian_model extends CI_Model
{

    public $table = 'pembelian';
    public $id = 'id_pembelian';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    function json($dari = '', $sampai = '', $id_status = '')
    {
        $menu = $this->uri->segment(1);
        $id_menu = $this->db->get_where('menu', ['url' => $menu])->row_array()['id_menu'];
        $id_role = $this->session->userdata('id_role');

        $this->db->select('c, u ,d');
        $this->db->where('id_menu', $id_menu);
        $this->db->where('id_role', $id_role);
        $access = $this->db->get('akses_role')->row_array();

        $this->datatables->select(
            "
        pembelian.id_pembelian,
        user.id_user,
        marketplace.id_marketplace,
        status.id_status,
        nomor_invoice,
        no_pesanan,
        nama_pelanggan,
        pembelian.alamat,
        pembelian.telepon,
        tanggal,
        SUM(sub_total) as sub_total,
        diskon,
        total,
        bayar,
        keterangan,
        nama_user,
        nama_marketplace,
        nama_status,
        GROUP_CONCAT(CONCAT('- ', detail_pembelian.nama_produk, ', Qty : ', detail_pembelian.qty) SEPARATOR '<br>') AS produk"
        );
        $this->datatables->from('pembelian');
        $this->datatables->join('detail_pembelian', 'pembelian.id_pembelian = detail_pembelian.id_pembelian', 'left');
        $this->datatables->join('user', 'user.id_user = pembelian.id_user', 'left');
        $this->datatables->join('marketplace', 'marketplace.id_marketplace = pembelian.id_marketplace', 'left');
        $this->datatables->join('status', 'status.id_status = pembelian.id_status', 'left');
        if ($dari && $sampai) {
            $this->datatables->where('DATE(tanggal) >=', $dari);
            $this->datatables->where('DATE(tanggal) <=', $sampai);
        }
        if ($this->session->userdata('level') == 'reseller lukman') {
            $this->datatables->where('pembelian.id_user', $this->session->userdata('id_user'));
        }
        if ($this->session->userdata('id_marketplace')) {
            $this->datatables->where('pembelian.id_marketplace', $this->session->userdata('id_marketplace'));
        }
        if ($id_status) {
            $this->datatables->where('pembelian.id_status', $id_status);
        }
        if ($access['u'] == '1' && $access['d'] == '1') {
            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('pembelian/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a href="'  . site_url('pembelian/update/$1') . '" class="btn btn-warning"><i class="fa fa-edit"></i></a> 
                <a data-href="'  . site_url('pembelian/delete/$1') . '" class="btn btn-danger hapus-data"><i class="fa fa-trash"></i></a>',
                'id_pembelian'
            );
        } else if ($access['u'] == '1') {
            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('pembelian/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a href="'  . site_url('pembelian/update/$1') . '" class="btn btn-warning"><i class="fa fa-edit"></i></a>',
                'id_pembelian'
            );
        } else if ($access['d'] == '1') {
            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('pembelian/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a data-href="'  . site_url('pembelian/delete/$1') . '" class="btn btn-danger hapus-data"><i class="fa fa-trash"></i></a>',
                'id_pembelian'
            );
        } else {
            $this->datatables->add_column('action', '<a href="'  . site_url('pembelian/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a>', 'id_pembelian');
        }
        if ($access['d'] == '1') {
            $this->datatables->add_column(
                'hapus_bulk',
                '<input type="checkbox" class="data_checkbox" name="data[]" value="$1">',
                'id_pembelian'
            );
        } else {
            $this->datatables->add_column('hapus_bulk', '', 'id_pembelian');
        }
        $this->datatables->add_column('data_pelanggan', '
        <div>
            <ul>
                <li>Nama : $1</li>
                <li>Alamat : $2</li>
                <li>Telepon : $3</li>
            </ul>
        </div>
        ', 'nama_pelanggan, alamat, telepon');

        $this->datatables->add_column(
            'data_produk',
            '<div>$1</div>',
            'produk'
        );
        $this->db->group_by('pembelian.id_pembelian');
        $this->db->order_by('tanggal', 'DESC');
        return $this->datatables->generate();
    }

    function create($post)
    {
        $pembelian = $this->db->get_where('pembelian', ['nomor_invoice' => $post['no_invoice']])->row();

        if ($pembelian) {
            $this->session->set_flashdata('error', 'No Invoice Telah Digunakan');
            redirect(site_url('pembelian/create'));
        }

        $this->db->trans_begin();

        $this->db->insert('pembelian', [
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

        $id_pembelian = $this->db->insert_id();

        for ($i = 0; $i < count($post['id_produk']); $i++) {
            $this->db->insert('detail_pembelian', [
                'id_pembelian' => $id_pembelian,
                'id_produk' => $post['id_produk'][$i],
                'nama_produk' => $post['nama_produk'][$i],
                'qty' => $post['qty'][$i],
                'harga_modal' => $post['harga_modal'][$i],
                'harga_jual' => $post['harga_jual'][$i],
                'total_harga' => str_replace('.', '', $post['total_harga'][$i]),
            ]);

            $this->db->set('stok', 'stok+' . $post['qty'][$i], FALSE);
            $this->db->where('id_produk', $post['id_produk'][$i]);
            $this->db->update('produk');
        }

        add_log('Pembelian', $id_pembelian, 'Tambah', $post['no_invoice']);


        $this->db->trans_complete();

        return $id_pembelian;
    }

    function edit($id, $post)
    {
        $this->db->trans_begin();

        $this->db->where('id_pembelian', $id);
        $this->db->update('pembelian', [
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

        $detail_pembelian = $this->db->get_where('detail_pembelian', ['id_pembelian' => $id])->result_array();
        foreach ($detail_pembelian as $row) {
            $this->db->set('stok', 'stok - ' . $row['qty'], FALSE);
            $this->db->where('id_produk', $row['id_produk']);
            $this->db->update('produk');
        }

        $this->db->delete('detail_pembelian', ['id_pembelian' => $id]);

        for ($i = 0; $i < count($post['id_produk']); $i++) {
            $this->db->insert('detail_pembelian', [
                'id_pembelian' => $id,
                'id_produk' => $post['id_produk'][$i],
                'nama_produk' => $post['nama_produk'][$i],
                'qty' => $post['qty'][$i],
                'harga_modal' => $post['harga_modal'][$i],
                'harga_jual' => $post['harga_jual'][$i],
                'total_harga' => str_replace('.', '', $post['total_harga'][$i]),
            ]);

            $this->db->set('stok', 'stok+' . $post['qty'][$i], FALSE);
            $this->db->where('id_produk', $post['id_produk'][$i]);
            $this->db->update('produk');
        }


        add_log('Pembelian', $id, 'Edit', $post['no_invoice']);


        $this->db->trans_complete();
    }

    // get all
    function get_all($dari = '', $sampai = '', $id_status = '')
    {
        $this->db->select('*, user.id_user,marketplace.id_marketplace,status.id_status, pembelian.alamat, pembelian.telepon');
        $this->db->join('user', 'user.id_user = pembelian.id_user', 'left');
        $this->db->join('marketplace', 'marketplace.id_marketplace = pembelian.id_marketplace', 'left');
        $this->db->join('status', 'status.id_status = pembelian.id_status', 'left');
        if ($dari && $sampai) {
            $this->db->where('DATE(tanggal) >=', $dari);
            $this->db->where('DATE(tanggal) <=', $sampai);
        }
        if ($id_status) {
            $this->db->where('pembelian.id_status', $id_status);
        }
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select('*, user.id_user,marketplace.id_marketplace,status.id_status, pembelian.alamat, pembelian.telepon');
        $this->db->join('user', 'user.id_user = pembelian.id_user', 'left');
        $this->db->join('marketplace', 'marketplace.id_marketplace = pembelian.id_marketplace', 'left');
        $this->db->join('status', 'status.id_status = pembelian.id_status', 'left');
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    // get total rows
    function total_rows($q = NULL, $dari = '', $sampai = '', $id_status = '')
    {
        $this->db->select('*, pembelian.alamat, pembelian.telepon');
        $this->db->join('user', 'user.id_user = pembelian.id_user', 'left');
        $this->db->join('marketplace', 'marketplace.id_marketplace = pembelian.id_marketplace', 'left');
        $this->db->join('status', 'status.id_status = pembelian.id_status', 'left');
        if ($dari && $sampai) {
            $this->db->where('DATE(tanggal) >=', $dari);
            $this->db->where('DATE(tanggal) <=', $sampai);
        }
        if ($id_status) {
            $this->db->where('pembelian.id_status', $id_status);
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
        $this->db->select('*, pembelian.alamat, pembelian.telepon');
        $this->db->join('user', 'user.id_user = pembelian.id_user');
        $this->db->join('marketplace', 'marketplace.id_marketplace = pembelian.id_marketplace', 'left');
        $this->db->join('status', 'status.id_status = pembelian.id_status', 'left');
        if ($dari && $sampai) {
            $this->db->where('DATE(tanggal) >=', $dari);
            $this->db->where('DATE(tanggal) <=', $sampai);
        }
        if ($id_status) {
            $this->db->where('pembelian.id_status', $id_status);
        }
        if ($q) {
            $this->db->or_like('nomor_invoice', $q);
            $this->db->or_like('no_pesanan', $q);
        }
        $this->db->limit($limit, $start);
        $this->db->order_by('tanggal', 'DESC');
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
        $no_invoice = $this->db->get_where('pembelian', ['id_pembelian' => $id])->row('nomor_invoice');
        add_log('Pembelian', $id, 'Hapus', $no_invoice);

        $detail_pembelian = $this->db->get_where('detail_pembelian', ['id_pembelian' => $id])->result_array();
        foreach ($detail_pembelian as $row) {
            $this->db->set('stok', 'stok + ' . $row['qty'], FALSE);
            $this->db->where('id_produk', $row['id_produk']);
            $this->db->update('produk');
        }

        $this->db->delete('detail_pembelian', ['id_pembelian' => $id]);

        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}

/* End of file pembelian_model.php */
/* Location: ./application/models/pembelian_model.php */
/* Please DO NOT modify this information : */
/* Generated by Harviacode Codeigniter CRUD Generator 2023-12-28 13:23:46 */
/* http://harviacode.com */
