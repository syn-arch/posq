<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kategori extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';
        $this->load->model('Kategori_model');

        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['judul'] = 'Data Kategori';

        $this->load->view('templates/header', $data);
        $this->load->view('kategori/kategori_list', $data);
        $this->load->view('templates/footer', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Kategori_model->json();
    }

    public function read($id)
    {
        $row = $this->Kategori_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_kategori' => $row->id_kategori,
                'nama_kategori' => $row->nama_kategori,
            );


            $data['judul'] = 'Detail Kategori';

            $this->load->view('templates/header', $data);
            $this->load->view('kategori/kategori_read', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('kategori'));
        }
    }

    public function hapus_bulk()
    {
        cek_akses('d');

        foreach ($_POST['data'] as $id) {

            $this->db->delete('kategori', ['id_kategori' => $id]);
        }
    }

    public function create()
    {
        cek_akses('c');

        $data = array(
            'button' => 'Create',
            'action' => site_url('kategori/create_action'),
            'id_kategori' => set_value('id_kategori'),
            'nama_kategori' => set_value('nama_kategori'),
        );

        $data['judul'] = 'Tambah Kategori';
        $this->load->view('templates/header', $data);
        $this->load->view('kategori/kategori_form', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_kategori' => $this->input->post('nama_kategori', TRUE),
            );

            $this->Kategori_model->insert($data);
            $this->session->set_flashdata('success', 'Ditambah');
            redirect(site_url('kategori'));
        }
    }

    public function update($id)
    {
        cek_akses('u');

        $row = $this->Kategori_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kategori/update_action'),
                'id_kategori' => set_value('id_kategori', $row->id_kategori),
                'nama_kategori' => set_value('nama_kategori', $row->nama_kategori),
            );

            $data['judul'] = 'Ubah Kategori';
            $this->load->view('templates/header', $data);
            $this->load->view('kategori/kategori_form', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('kategori'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kategori', TRUE));
        } else {
            $data = array(
                'nama_kategori' => $this->input->post('nama_kategori', TRUE),
            );

            $this->Kategori_model->update($this->input->post('id_kategori', TRUE), $data);
            $this->session->set_flashdata('success', 'Diubah');
            redirect(site_url('kategori'));
        }
    }

    public function delete($id)
    {
        cek_akses('d');
        $row = $this->Kategori_model->get_by_id($id);

        if ($row) {
            $this->Kategori_model->delete($id);
            $this->session->set_flashdata('success', 'Dihapus');
            redirect(site_url('kategori'));
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('kategori'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_kategori', 'nama kategori', 'trim|required');

        $this->form_validation->set_rules('id_kategori', 'id_kategori', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "kategori.xls";
        $judul = "kategori";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Kategori");

        foreach ($this->Kategori_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_kategori);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    function pdf()
    {
        $data = array(
            'kategori_data' => $this->Kategori_model->get_all(),
            'start' => 0
        );

        ini_set('memory_limit', '32M');
        $html = $this->load->view('kategori/kategori_pdf', $data, true);
        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($html);
        $pdf->Output('kategori.pdf', 'D');
    }
}

/* End of file Kategori.php */
                        /* Location: ./application/modules/E:\xampp\htdocs\posq\application/modules//controllers/Kategori.php */
                        /* Please DO NOT modify this information : */
                        /* Generated by Harviacode Codeigniter CRUD Generator 2023-12-28 11:52:54 */
                        /* http://harviacode.com */
