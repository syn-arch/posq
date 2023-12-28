<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Supplier extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';
        $this->load->model('Supplier_model');

        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['judul'] = 'Data Supplier';

        $this->load->view('templates/header', $data);
        $this->load->view('supplier/supplier_list', $data);
        $this->load->view('templates/footer', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Supplier_model->json();
    }

    public function read($id)
    {
        $row = $this->Supplier_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_supplier' => $row->id_supplier,
                'nama_supplier' => $row->nama_supplier,
                'alamat' => $row->alamat,
                'no_telepon' => $row->no_telepon,
                'email' => $row->email,
            );


            $data['judul'] = 'Detail Supplier';

            $this->load->view('templates/header', $data);
            $this->load->view('supplier/supplier_read', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('supplier'));
        }
    }

    public function hapus_bulk()
    {
        cek_akses('d');

        foreach ($_POST['data'] as $id) {

            $this->db->delete('supplier', ['id_supplier' => $id]);
        }
    }

    public function create()
    {
        cek_akses('c');

        $data = array(
            'button' => 'Create',
            'action' => site_url('supplier/create_action'),
            'id_supplier' => set_value('id_supplier'),
            'nama_supplier' => set_value('nama_supplier'),
            'alamat' => set_value('alamat'),
            'no_telepon' => set_value('no_telepon'),
            'email' => set_value('email'),
        );

        $data['judul'] = 'Tambah Supplier';
        $this->load->view('templates/header', $data);
        $this->load->view('supplier/supplier_form', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'nama_supplier' => $this->input->post('nama_supplier', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE),
                'email' => $this->input->post('email', TRUE),
            );

            $this->Supplier_model->insert($data);
            $this->session->set_flashdata('success', 'Ditambah');
            redirect(site_url('supplier'));
        }
    }

    public function update($id)
    {
        cek_akses('u');

        $row = $this->Supplier_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('supplier/update_action'),
                'id_supplier' => set_value('id_supplier', $row->id_supplier),
                'nama_supplier' => set_value('nama_supplier', $row->nama_supplier),
                'alamat' => set_value('alamat', $row->alamat),
                'no_telepon' => set_value('no_telepon', $row->no_telepon),
                'email' => set_value('email', $row->email),
            );

            $data['judul'] = 'Ubah Supplier';
            $this->load->view('templates/header', $data);
            $this->load->view('supplier/supplier_form', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('supplier'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_supplier', TRUE));
        } else {
            $data = array(
                'nama_supplier' => $this->input->post('nama_supplier', TRUE),
                'alamat' => $this->input->post('alamat', TRUE),
                'no_telepon' => $this->input->post('no_telepon', TRUE),
                'email' => $this->input->post('email', TRUE),
            );

            $this->Supplier_model->update($this->input->post('id_supplier', TRUE), $data);
            $this->session->set_flashdata('success', 'Diubah');
            redirect(site_url('supplier'));
        }
    }

    public function delete($id)
    {
        cek_akses('d');
        $row = $this->Supplier_model->get_by_id($id);

        if ($row) {
            $this->Supplier_model->delete($id);
            $this->session->set_flashdata('success', 'Dihapus');
            redirect(site_url('supplier'));
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('supplier'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_supplier', 'nama supplier', 'trim|required');
        $this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
        $this->form_validation->set_rules('no_telepon', 'no telepon', 'trim|required');
        $this->form_validation->set_rules('email', 'email', 'trim|required');

        $this->form_validation->set_rules('id_supplier', 'id_supplier', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "supplier.xls";
        $judul = "supplier";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Supplier");
        xlsWriteLabel($tablehead, $kolomhead++, "Alamat");
        xlsWriteLabel($tablehead, $kolomhead++, "No Telepon");
        xlsWriteLabel($tablehead, $kolomhead++, "Email");

        foreach ($this->Supplier_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_supplier);
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
            'supplier_data' => $this->Supplier_model->get_all(),
            'start' => 0
        );

        ini_set('memory_limit', '32M');
        $html = $this->load->view('supplier/supplier_pdf', $data, true);
        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($html);
        $pdf->Output('supplier.pdf', 'D');
    }
}

/* End of file Supplier.php */
                        /* Location: ./application/modules/E:\xampp\htdocs\posq\application/modules//controllers/Supplier.php */
                        /* Please DO NOT modify this information : */
                        /* Generated by Harviacode Codeigniter CRUD Generator 2023-12-28 11:52:47 */
                        /* http://harviacode.com */
