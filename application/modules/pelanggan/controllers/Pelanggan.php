<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Pelanggan extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';
        $this->load->model('Pelanggan_model');

        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['judul'] = 'Data Pelanggan';

        $this->load->view('templates/header', $data);
        $this->load->view('pelanggan/pelanggan_list', $data);
        $this->load->view('templates/footer', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Pelanggan_model->json();
    }

    public function read($id)
    {
        $row = $this->Pelanggan_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_pelanggan' => $row->id_pelanggan,
                'nama_pelanggan' => $row->nama_pelanggan,
                'alamat' => $row->alamat,
                'no_telepon' => $row->no_telepon,
                'email' => $row->email,
            );


            $data['judul'] = 'Detail Pelanggan';

            $this->load->view('templates/header', $data);
            $this->load->view('pelanggan/pelanggan_read', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('pelanggan'));
        }
    }

    public function hapus_bulk()
    {
        cek_akses('d');

        foreach ($_POST['data'] as $id) {

            $this->db->delete('pelanggan', ['id_pelanggan' => $id]);
        }
    }

    public function create()
    {
        cek_akses('c');

        $data = array(
            'button' => 'Create',
            'action' => site_url('pelanggan/create_action'),
            'id_pelanggan' => set_value('id_pelanggan'),
            'nama_pelanggan' => set_value('nama_pelanggan'),
            'alamat' => set_value('alamat'),
            'no_telepon' => set_value('no_telepon'),
            'email' => set_value('email'),
        );

        $data['judul'] = 'Tambah Pelanggan';
        $this->load->view('templates/header', $data);
        $this->load->view('pelanggan/pelanggan_form', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_pelanggan' => $this->input->post('nama_pelanggan', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE),
                'email' => $this->input->post('email', TRUE),
            );

            $this->Pelanggan_model->insert($data);
            $this->session->set_flashdata('success', 'Ditambah');
            redirect(site_url('pelanggan'));
        }
    }

    public function update($id)
    {
        cek_akses('u');

        $row = $this->Pelanggan_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('pelanggan/update_action'),
                'id_pelanggan' => set_value('id_pelanggan', $row->id_pelanggan),
                'nama_pelanggan' => set_value('nama_pelanggan', $row->nama_pelanggan),
                'alamat' => set_value('alamat', $row->alamat),
                'no_telepon' => set_value('no_telepon', $row->no_telepon),
                'email' => set_value('email', $row->email),
            );

            $data['judul'] = 'Ubah Pelanggan';
            $this->load->view('templates/header', $data);
            $this->load->view('pelanggan/pelanggan_form', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('pelanggan'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_pelanggan', TRUE));
        } else {
            $data = array(
                'nama_pelanggan' => $this->input->post('nama_pelanggan', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE),
                'email' => $this->input->post('email', TRUE),
            );

            $this->Pelanggan_model->update($this->input->post('id_pelanggan', TRUE), $data);
            $this->session->set_flashdata('success', 'Diubah');
            redirect(site_url('pelanggan'));
        }
    }

    public function delete($id)
    {
        cek_akses('d');
        $row = $this->Pelanggan_model->get_by_id($id);

        if ($row) {
            $this->Pelanggan_model->delete($id);
            $this->session->set_flashdata('success', 'Dihapus');
            redirect(site_url('pelanggan'));
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('pelanggan'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_pelanggan', 'nama pelanggan', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('no_telepon', 'no telepon', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');

        $this->form_validation->set_rules('id_pelanggan', 'id_pelanggan', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "pelanggan.xls";
        $judul = "pelanggan";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Pelanggan");
        xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
        xlsWriteLabel($tablehead, $kolomhead++, "No Telepon");
        xlsWriteLabel($tablehead, $kolomhead++, "Email");

        foreach ($this->Pelanggan_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_pelanggan);
            xlsWriteLabel($tablebody, $kolombody++, $data->alamat);
            xlsWriteLabel($tablebody, $kolombody++, $data->no_telepon);
            xlsWriteLabel($tablebody, $kolombody++, $data->email);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    function pdf()
    {
        $data = array(
            'pelanggan_data' => $this->Pelanggan_model->get_all(),
            'start' => 0
        );

        ini_set('memory_limit', '32M');
        $html = $this->load->view('pelanggan/pelanggan_pdf', $data, true);
        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($html);
        $pdf->Output('pelanggan.pdf', 'D');
    }
}

/* End of file Pelanggan.php */
                        /* Location: ./application/modules/E:\xampp\htdocs\posq\application/modules//controllers/Pelanggan.php */
                        /* Please DO NOT modify this information : */
                        /* Generated by Harviacode Codeigniter CRUD Generator 2023-12-28 11:52:26 */
                        /* http://harviacode.com */
