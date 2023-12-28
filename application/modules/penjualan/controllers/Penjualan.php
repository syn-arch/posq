<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penjualan extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';
        $this->load->model('Penjualan_model');
        $this->load->model('pelanggan/Pelanggan_model');
        $this->load->model('user/User_model');
        $this->load->model('produk/Produk_model');
        $this->load->model('marketplace/Marketplace_model');
        $this->load->model('status/Status_model');
        $this->load->library('form_validation');
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

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Penjualan_model->total_rows($q);
        $penjualan = $this->Penjualan_model->get_limit_data($config['per_page'], $start, $q);

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
                'id_pelanggan' => $row->id_pelanggan,
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
            );


            $data['judul'] = 'Detail Penjualan';

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

            $this->db->delete('penjualan', ['id_penjualan' => $id]);
        }
    }

    public function create()
    {
        cek_akses('c');

        $data = array(
            'button' => 'Create',
            'action' => site_url('penjualan/create_action'),
            'id_penjualan' => set_value('id_penjualan'),
            'id_pelanggan' => set_value('id_pelanggan'),
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
        $data['pelanggan'] = $this->Pelanggan_model->get_all();
        $data['user'] = $this->User_model->get_all();
        $data['produk'] = $this->Produk_model->get_all();
        $data['marketplace'] = $this->Marketplace_model->get_all();
        $data['status'] = $this->Status_model->get_all();

        $this->load->view('templates/header', $data);
        $this->load->view('penjualan/penjualan_tambah', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'id_pelanggan' => $this->input->post('id_pelanggan', TRUE),
                'id_user' => $this->input->post('id_user', TRUE),
                'id_marketplace' => $this->input->post('id_marketplace', TRUE),
                'id_status' => $this->input->post('id_status', TRUE),
                'nomor_invoice' => $this->input->post('nomor_invoice', TRUE),
                'tanggal' => $this->input->post('tanggal', TRUE),
                'sub_total' => $this->input->post('sub_total', TRUE),
                'diskon' => $this->input->post('diskon', TRUE),
                'total' => $this->input->post('total', TRUE),
                'bayar' => $this->input->post('bayar', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
            );

            $this->Penjualan_model->insert($data);
            $this->session->set_flashdata('success', 'Ditambah');
            redirect(site_url('penjualan'));
        }
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
                'id_pelanggan' => set_value('id_pelanggan', $row->id_pelanggan),
                'id_user' => set_value('id_user', $row->id_user),
                'id_marketplace' => set_value('id_marketplace', $row->id_marketplace),
                'id_status' => set_value('id_status', $row->id_status),
                'nomor_invoice' => set_value('nomor_invoice', $row->nomor_invoice),
                'tanggal' => set_value('tanggal', $row->tanggal),
                'sub_total' => set_value('sub_total', $row->sub_total),
                'diskon' => set_value('diskon', $row->diskon),
                'total' => set_value('total', $row->total),
                'bayar' => set_value('bayar', $row->bayar),
                'keterangan' => set_value('keterangan', $row->keterangan),
            );

            $data['judul'] = 'Ubah Penjualan';
            $data['pelanggan'] = $this->Pelanggan_model->get_all();
            $data['user'] = $this->User_model->get_all();
            $data['marketplace'] = $this->Marketplace_model->get_all();
            $data['status'] = $this->Status_model->get_all();
            $this->load->view('templates/header', $data);
            $this->load->view('penjualan/penjualan_form', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('penjualan'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_penjualan', TRUE));
        } else {
            $data = array(
                'id_pelanggan' => $this->input->post('id_pelanggan', TRUE),
                'id_user' => $this->input->post('id_user', TRUE),
                'id_marketplace' => $this->input->post('id_marketplace', TRUE),
                'id_status' => $this->input->post('id_status', TRUE),
                'nomor_invoice' => $this->input->post('nomor_invoice', TRUE),
                'tanggal' => $this->input->post('tanggal', TRUE),
                'sub_total' => $this->input->post('sub_total', TRUE),
                'diskon' => $this->input->post('diskon', TRUE),
                'total' => $this->input->post('total', TRUE),
                'bayar' => $this->input->post('bayar', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
            );

            $this->Penjualan_model->update($this->input->post('id_penjualan', TRUE), $data);
            $this->session->set_flashdata('success', 'Diubah');
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

    public function _rules()
    {
        $this->form_validation->set_rules('id_pelanggan', 'id pelanggan', 'trim|required|numeric');
        $this->form_validation->set_rules('id_user', 'id user', 'trim|required|numeric');
        $this->form_validation->set_rules('id_marketplace', 'id marketplace', 'trim|required|numeric');
        $this->form_validation->set_rules('id_status', 'id status', 'trim|required|numeric');
        $this->form_validation->set_rules('nomor_invoice', 'nomor invoice', 'trim|required');
        $this->form_validation->set_rules('tanggal', 'tanggal', 'trim|required');
        $this->form_validation->set_rules('sub_total', 'sub total', 'trim|required|numeric');
        $this->form_validation->set_rules('diskon', 'diskon', 'trim|required|numeric');
        $this->form_validation->set_rules('total', 'total', 'trim|required|numeric');
        $this->form_validation->set_rules('bayar', 'bayar', 'trim|required|numeric');
        $this->form_validation->set_rules('keterangan', 'keterangan', 'trim|required');

        $this->form_validation->set_rules('id_penjualan', 'id_penjualan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
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
        xlsWriteLabel($tablehead, $kolomhead++, "Id Pelanggan");
        xlsWriteLabel($tablehead, $kolomhead++, "Id User");
        xlsWriteLabel($tablehead, $kolomhead++, "Id Marketplace");
        xlsWriteLabel($tablehead, $kolomhead++, "Id Status");
        xlsWriteLabel($tablehead, $kolomhead++, "Nomor Invoice");
        xlsWriteLabel($tablehead, $kolomhead++, "Tanggal");
        xlsWriteLabel($tablehead, $kolomhead++, "Sub Total");
        xlsWriteLabel($tablehead, $kolomhead++, "Diskon");
        xlsWriteLabel($tablehead, $kolomhead++, "Total");
        xlsWriteLabel($tablehead, $kolomhead++, "Bayar");
        xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");

        foreach ($this->Penjualan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_pelanggan);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_user);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_marketplace);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_status);
            xlsWriteLabel($tablebody, $kolombody++, $data->nomor_invoice);
            xlsWriteLabel($tablebody, $kolombody++, $data->tanggal);
            xlsWriteNumber($tablebody, $kolombody++, $data->sub_total);
            xlsWriteNumber($tablebody, $kolombody++, $data->diskon);
            xlsWriteNumber($tablebody, $kolombody++, $data->total);
            xlsWriteNumber($tablebody, $kolombody++, $data->bayar);
            xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    function pdf()
    {
        $data = array(
            'penjualan_data' => $this->Penjualan_model->get_all(),
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
