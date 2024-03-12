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

    // datatables
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
        penjualan.id_penjualan,
        user.id_user,
        marketplace.id_marketplace,
        status.id_status,
        nomor_invoice,
        no_pesanan,
        nama_pelanggan,
        penjualan.alamat,
        penjualan.telepon,
        tanggal,
        SUM(sub_total) as sub_total,
        diskon,
        total,
        bayar,
        keterangan,
        lampiran,
        nama_user,
        nama_marketplace,
        nama_status,
        GROUP_CONCAT(CONCAT('- ', detail_penjualan.nama_produk, ', Qty : ', detail_penjualan.qty) SEPARATOR '<br>') AS produk"
        );
        $this->datatables->from('penjualan');
        $this->datatables->join('detail_penjualan', 'penjualan.id_penjualan = detail_penjualan.id_penjualan', 'left');
        $this->datatables->join('user', 'user.id_user = penjualan.id_user', 'left');
        $this->datatables->join('marketplace', 'marketplace.id_marketplace = penjualan.id_marketplace', 'left');
        $this->datatables->join('status', 'status.id_status = penjualan.id_status', 'left');
        if ($dari && $sampai) {
            $this->datatables->where('DATE(tanggal) >=', $dari);
            $this->datatables->where('DATE(tanggal) <=', $sampai);
        }
        if ($this->session->userdata('level') == 'reseller lukman') {
            $this->datatables->where('penjualan.id_user', $this->session->userdata('id_user'));
        }
        if ($this->session->userdata('id_marketplace')) {
            $this->datatables->where('penjualan.id_marketplace', $this->session->userdata('id_marketplace'));
        }
        if ($id_status) {
            $this->datatables->where('penjualan.id_status', $id_status);
        }
        if ($access['u'] == '1' && $access['d'] == '1') {
            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('penjualan/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a href="'  . site_url('penjualan/update/$1') . '" class="btn btn-warning"><i class="fa fa-edit"></i></a> 
                <a data-href="'  . site_url('penjualan/delete/$1') . '" class="btn btn-danger hapus-data"><i class="fa fa-trash"></i></a>',
                'id_penjualan'
            );
        } else if ($access['u'] == '1') {
            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('penjualan/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a href="'  . site_url('penjualan/update/$1') . '" class="btn btn-warning"><i class="fa fa-edit"></i></a>',
                'id_penjualan'
            );
        } else if ($access['d'] == '1') {
            $this->datatables->add_column(
                'action',
                '<a href="'  . site_url('penjualan/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a> 
                <a data-href="'  . site_url('penjualan/delete/$1') . '" class="btn btn-danger hapus-data"><i class="fa fa-trash"></i></a>',
                'id_penjualan'
            );
        } else {
            $this->datatables->add_column('action', '<a href="'  . site_url('penjualan/read/$1') . '" class="btn btn-info"><i class="fa fa-eye"></i></a>', 'id_penjualan');
        }
        if ($access['d'] == '1') {
            $this->datatables->add_column(
                'hapus_bulk',
                '<input type="checkbox" class="data_checkbox" name="data[]" value="$1">',
                'id_penjualan'
            );
        } else {
            $this->datatables->add_column('hapus_bulk', '', 'id_penjualan');
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
        $this->db->group_by('penjualan.id_penjualan');
        $this->db->order_by('tanggal', 'DESC');
        return $this->datatables->generate();
    }

    function create($post)
    {
        $penjualan = $this->db->get_where('penjualan', ['nomor_invoice' => $post['no_invoice']])->row();

        if ($penjualan) {
            $no_invoice = no_invoice();
        } else {
            $no_invoice = $post['no_invoice'];
        }

        $this->db->trans_begin();

        $data = [
            'id_user' => $this->session->userdata('id_user'),
            'id_marketplace' => $post['id_marketplace'],
            'id_status' => $post['id_status'],
            'no_pesanan' => $post['no_pesanan'],
            'nama_pelanggan' => $post['nama_pelanggan'],
            'alamat' => $post['alamat'],
            'telepon' => $post['telepon'],
            'nomor_invoice' => $no_invoice,
            'tanggal' => $post['tanggal'],
            'sub_total' => str_replace('.', '', $post['sub_total']),
            'diskon' => str_replace('.', '', $post['diskon']),
            'total' => str_replace('.', '', $post['total']),
            'bayar' => str_replace('.', '', $post['bayar']),
            'keterangan' => $post['keterangan'],
            'sl' => $post['sl'],
        ];

        if ($_FILES['lampiran']['name']) {
            $data['lampiran'] = _upload('lampiran', 'penjualan/create', 'penjualan');
        }

        $this->db->insert('penjualan', $data);

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

        $data = [
            'id_user_edit' => $this->session->userdata('id_user'),
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
            'sl' => $post['sl'],
        ];

        if ($_FILES['lampiran']['name']) {
            $data['lampiran'] = _upload('lampiran', 'penjualan/create', 'penjualan');
        }

        $this->db->where('id_penjualan', $id);
        $this->db->update('penjualan', $data);

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
        if ($this->session->userdata('level') != 'Admin') {
            $this->db->where('penjualan.id_user', $this->session->userdata('id_user'));
        }
        if ($this->session->userdata('id_marketplace')) {
            $this->db->where('penjualan.id_marketplace', $this->session->userdata('id_marketplace'));
        }
        if ($id_status) {
            $this->db->where('penjualan.id_status', $id_status);
        }
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->select('*, user_edit.nama_user as user_edit, user.id_user,marketplace.id_marketplace,status.id_status, penjualan.alamat, penjualan.telepon');
        $this->db->join('user', 'user.id_user = penjualan.id_user', 'left');
        $this->db->join('user user_edit', 'user_edit.id_user = penjualan.id_user_edit', 'left');
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
