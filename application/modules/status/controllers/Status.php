<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Status extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';
        $this->load->model('Status_model');

        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['judul'] = 'Status Pesanan';

        $this->load->view('templates/header', $data);
        $this->load->view('status/status_list', $data);
        $this->load->view('templates/footer', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Status_model->json();
    }

    public function read($id)
    {
        $row = $this->Status_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_status' => $row->id_status,
                'nama_status' => $row->nama_status,
                'warna' => $row->warna,
            );


            $data['judul'] = 'Detail Status';

            $this->load->view('templates/header', $data);
            $this->load->view('status/status_read', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('status'));
        }
    }

    public function hapus_bulk()
    {
        cek_akses('d');

        foreach ($_POST['data'] as $id) {

            $this->db->delete('status', ['id_status' => $id]);
        }
    }

    public function create()
    {
        cek_akses('c');

        $data = array(
            'button' => 'Create',
            'action' => site_url('status/create_action'),
            'id_status' => set_value('id_status'),
            'nama_status' => set_value('nama_status'),
            'warna' => set_value('warna'),
        );

        $data['judul'] = 'Tambah Status';
        $this->load->view('templates/header', $data);
        $this->load->view('status/status_form', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_status' => $this->input->post('nama_status', TRUE),
                'warna' => $this->input->post('warna', TRUE),
            );

            $this->Status_model->insert($data);
            $this->session->set_flashdata('success', 'Ditambah');
            redirect(site_url('status'));
        }
    }

    public function update($id)
    {
        cek_akses('u');

        $row = $this->Status_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('status/update_action'),
                'id_status' => set_value('id_status', $row->id_status),
                'nama_status' => set_value('nama_status', $row->nama_status),
                'warna' => set_value('warna', $row->warna),
            );

            $data['judul'] = 'Ubah Status';
            $this->load->view('templates/header', $data);
            $this->load->view('status/status_form', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('status'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_status', TRUE));
        } else {
            $data = array(
                'nama_status' => $this->input->post('nama_status', TRUE),
                'warna' => $this->input->post('warna', TRUE),
            );

            $this->Status_model->update($this->input->post('id_status', TRUE), $data);
            $this->session->set_flashdata('success', 'Diubah');
            redirect(site_url('status'));
        }
    }

    public function delete($id)
    {
        cek_akses('d');
        $row = $this->Status_model->get_by_id($id);

        if ($row) {
            $this->Status_model->delete($id);
            $this->session->set_flashdata('success', 'Dihapus');
            redirect(site_url('status'));
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('status'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_status', 'nama status', 'trim|required');
        $this->form_validation->set_rules('warna', 'warna', 'trim|required');

        $this->form_validation->set_rules('id_status', 'id_status', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "status.xls";
        $judul = "status";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Status");
        xlsWriteLabel($tablehead, $kolomhead++, "Warna");

        foreach ($this->Status_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_status);
            xlsWriteLabel($tablebody, $kolombody++, $data->warna);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    function pdf()
    {
        $data = array(
            'status_data' => $this->Status_model->get_all(),
            'start' => 0
        );

        ini_set('memory_limit', '32M');
        $html = $this->load->view('status/status_pdf', $data, true);
        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($html);
        $pdf->Output('status.pdf', 'D');
    }
}

/* End of file Status.php */
                        /* Location: ./application/modules/E:\xampp\htdocs\posq\application/modules//controllers/Status.php */
                        /* Please DO NOT modify this information : */
                        /* Generated by Harviacode Codeigniter CRUD Generator 2023-12-28 12:11:21 */
                        /* http://harviacode.com */
