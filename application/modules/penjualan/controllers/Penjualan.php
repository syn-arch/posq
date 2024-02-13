<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Penjualan extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';
        $this->load->model('Penjualan_model');
        $this->load->model('user/User_model');
        $this->load->model('produk/Produk_model');
        $this->load->model('marketplace/Marketplace_model');
        $this->load->model('status/Status_model');
        $this->load->library('form_validation');
    }

    public function json()
    {
        header('Content-Type: application/json');

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_status = $this->input->get('id_status');

        echo $this->Penjualan_model->json($dari, $sampai, $id_status);
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = base_url() . 'penjualan/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'penjualan/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'penjualan/index.html';
            $config['first_url'] = base_url() . 'penjualan/index.html';
        }

        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_status = $this->input->get('id_status');

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Penjualan_model->total_rows($q, $dari, $sampai, $id_status);
        $penjualan = $this->Penjualan_model->get_limit_data($config['per_page'], $start, $q, $dari, $sampai, $id_status);

        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'penjualan_data' => $penjualan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );

        $data['judul'] = 'Riwayat Penjualan';
        $data['data_status'] = $this->Status_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('penjualan/penjualan_list', $data);
        $this->load->view('templates/footer', $data);
    }

    public function read($id)
    {
        $row = $this->Penjualan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'id_penjualan' => $row->id_penjualan,
                'id_user' => $row->id_user,
                'id_marketplace' => $row->id_marketplace,
                'id_status' => $row->id_status,
                'nomor_invoice' => $row->nomor_invoice,
                'tanggal' => $row->tanggal,
                'sub_total' => $row->sub_total,
                'diskon' => $row->diskon,
                'total' => $row->total,
                'bayar' => $row->bayar,
                'keterangan' => $row->keterangan,
                'nama_pelanggan' => $row->nama_pelanggan,
                'nama_user' => $row->nama_user,
                'nama_marketplace' => $row->nama_marketplace,
                'nama_status' => $row->nama_status,
                'no_pesanan' => $row->no_pesanan,
                'alamat' => $row->alamat,
                'telepon' => $row->telepon,
                'lampiran' => $row->lampiran,
            );


            $data['judul'] = 'Detail Penjualan';
            $data['detail_penjualan'] = $this->db->get_where('detail_penjualan', ['id_penjualan' => $id])->result_array();

            $this->load->view('templates/header', $data);
            $this->load->view('penjualan/penjualan_read', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('penjualan'));
        }
    }

    public function hapus_bulk()
    {
        cek_akses('d');

        foreach ($_POST['data'] as $id) {
            $detail_penjualan = $this->db->get_where('detail_penjualan', ['id_penjualan' => $id])->result_array();
            foreach ($detail_penjualan as $row) {
                $this->db->set('stok', 'stok + ' . $row['qty'], FALSE);
                $this->db->where('id_produk', $row['id_produk']);
                $this->db->update('produk');
            }
            $this->db->delete('detail_penjualan', ['id_penjualan' => $id]);
            $this->db->delete('penjualan', ['id_penjualan' => $id]);
        }
    }

    public function update_bulk()
    {
        cek_akses('u');

        foreach ($_POST['data'] as $row) {
            $this->db->set('id_status', $_POST['id_status']);
            $this->db->where('id_penjualan', $row);
            $this->db->update('penjualan');
        }
    }

    public function create()
    {
        cek_akses('c');

        $data = array(
            'button' => 'Create',
            'action' => site_url('penjualan/create_action'),
            'id_penjualan' => set_value('id_penjualan'),
            'id_user' => set_value('id_user'),
            'id_marketplace' => set_value('id_marketplace'),
            'id_status' => set_value('id_status'),
            'nomor_invoice' => set_value('nomor_invoice'),
            'tanggal' => set_value('tanggal'),
            'sub_total' => set_value('sub_total'),
            'diskon' => set_value('diskon'),
            'total' => set_value('total'),
            'bayar' => set_value('bayar'),
            'keterangan' => set_value('keterangan'),
        );

        $data['judul'] = 'Penjualan Baru';
        $data['user'] = $this->User_model->get_all();
        $data['produk'] = $this->Produk_model->get_all();
        $data['marketplace'] = $this->Marketplace_model->get_all();
        $data['status'] = $this->Status_model->get_all();

        $this->form_validation->set_rules('tanggal', 'tanggal', 'required');

        if ($this->form_validation->run()) {
            $id = $this->Penjualan_model->create($this->input->post());
            $this->session->set_flashdata('success', 'Ditambah');
            redirect(site_url('penjualan/read/' . $id));
        }

        $this->load->view('templates/header', $data);
        $this->load->view('penjualan/penjualan_tambah', $data);
        $this->load->view('templates/footer', $data);
    }

    public function update($id)
    {
        cek_akses('u');

        $row = $this->Penjualan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('penjualan/update_action'),
                'id_penjualan' => set_value('id_penjualan', $row->id_penjualan),
                'id_user' => set_value('id_user', $row->id_user),
                'nama_user' => set_value('nama_user', $row->nama_user),
                'id_marketplace' => set_value('id_marketplace', $row->id_marketplace),
                'id_status' => set_value('id_status', $row->id_status),
                'nomor_invoice' => set_value('nomor_invoice', $row->nomor_invoice),
                'tanggal' => set_value('tanggal', $row->tanggal),
                'sub_total' => set_value('sub_total', $row->sub_total),
                'diskon' => set_value('diskon', $row->diskon),
                'total' => set_value('total', $row->total),
                'bayar' => set_value('bayar', $row->bayar),
                'keterangan' => set_value('keterangan', $row->keterangan),
                'nama_pelanggan' => set_value('nama_pelanggan', $row->nama_pelanggan),
                'alamat' => set_value('alamat', $row->alamat),
                'telepon' => set_value('telepon', $row->telepon),
                'no_pesanan' => set_value('no_pesanan', $row->no_pesanan),
                'lampiran' => set_value('lampiran', $row->lampiran),
            );

            $data['judul'] = 'Ubah Penjualan';
            $data['user'] = $this->User_model->get_all();
            $data['marketplace'] = $this->Marketplace_model->get_all();
            $data['status'] = $this->Status_model->get_all();
            $data['produk'] = $this->Produk_model->get_all();
            $data['detail_penjualan'] = $this->db->get_where('detail_penjualan', ['id_penjualan' => $id])->result_array();

            $this->form_validation->set_rules('tanggal', 'tanggal', 'required');

            if ($this->form_validation->run()) {
                $this->Penjualan_model->edit($id, $this->input->post());
                $this->session->set_flashdata('success', 'Ditambah');
                redirect(site_url('penjualan'));
            }

            $this->load->view('templates/header', $data);
            $this->load->view('penjualan/penjualan_ubah', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('penjualan'));
        }
    }

    public function delete($id)
    {
        cek_akses('d');
        $row = $this->Penjualan_model->get_by_id($id);

        if ($row) {
            $this->Penjualan_model->delete($id);
            $this->session->set_flashdata('success', 'Dihapus');
            redirect(site_url('penjualan'));
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('penjualan'));
        }
    }

    public function excel($dari = '', $sampai = '', $id_status = '')
    {
        $this->load->helper('exportexcel');
        $namaFile = "penjualan.xls";
        $judul = "penjualan";
        $tablehead = 0;
        $tablebody = 1;
        $nourut = 1;
        //penulisan header
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0,pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $namaFile . "");
        header("Content-Transfer-Encoding: binary ");

        xlsBOF();

        $kolomhead = 0;
        xlsWriteLabel($tablehead, $kolomhead++, "No");
        xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
        xlsWriteLabel($tablehead, $kolomhead++, "Pelanggan");
        xlsWriteLabel($tablehead, $kolomhead++, "Sales");
        xlsWriteLabel($tablehead, $kolomhead++, "Marketplace");
        xlsWriteLabel($tablehead, $kolomhead++, "Nomor Invoice");
        xlsWriteLabel($tablehead, $kolomhead++, "Nomor Pesanan");
        xlsWriteLabel($tablehead, $kolomhead++, "Daftar Produk");
        xlsWriteLabel($tablehead, $kolomhead++, "Sub Total");
        xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
        xlsWriteLabel($tablehead, $kolomhead++, "Status");

        foreach ($this->Penjualan_model->get_all($dari, $sampai, $id_status) as $data) {
            $kolombody = 0;

            $this->db->where('id_penjualan', $data->id_penjualan);
            $produk = $this->db->get('detail_penjualan')->result();

            $daftar_produk = "";
            foreach ($produk as $row) {
                $daftar_produk .= " -" . $row->nama_produk . "(" . $row->qty . ")";
            }

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteLabel($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->tanggal);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_pelanggan);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_user);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_marketplace);
            xlsWriteLabel($tablebody, $kolombody++, $data->nomor_invoice);
            xlsWriteLabel($tablebody, $kolombody++, $data->no_pesanan);
            xlsWriteLabel($tablebody, $kolombody++, $daftar_produk);
            xlsWriteLabel($tablebody, $kolombody++, $data->sub_total);
            xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_status);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    function pdf($dari = '', $sampai = '', $id_status = '')
    {
        $data = array(
            'penjualan_data' => $this->Penjualan_model->get_all($dari, $sampai, $id_status),
            'start' => 0
        );

        ini_set('memory_limit', '32M');
        $html = $this->load->view('penjualan/penjualan_pdf', $data, true);
        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($html);
        $pdf->Output('penjualan.pdf', 'D');
    }
}

/* End of file Penjualan.php */
                        /* Location: ./application/modules/E:\xampp\htdocs\posq\application/modules//controllers/Penjualan.php */
                        /* Please DO NOT modify this information : */
                        /* Generated by Harviacode Codeigniter CRUD Generator 2023-12-28 13:23:46 */
                        /* http://harviacode.com */
