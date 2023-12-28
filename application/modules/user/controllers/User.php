<?php
defined('BASEPATH') or exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class user extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->model('user/user_model');
    }

    public function get_user_json()
    {
        header('Content-Type: application/json');
        echo $this->user_model->get_user_json();
    }

    public function hapus($id)
    {
        cek_akses('d');

        $this->user_model->delete($id);
        $this->session->set_flashdata('success', 'dihapus');
        redirect('user', 'refresh');
    }

    public function index()
    {
        $data['judul'] = "Data Sales";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('user/index', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function tambah()
    {
        cek_akses('c');

        $valid = $this->form_validation;
        $valid->set_rules('nama_user', 'nama user', 'required');
        $valid->set_rules('jk', 'jenis kelamin', 'required');
        $valid->set_rules('id_user', 'ID user', 'required');
        $valid->set_rules('alamat', 'alamat', 'required');
        $valid->set_rules('telepon', 'telepon', 'required');
        $valid->set_rules('email', 'email', 'required');
        $valid->set_rules('pw1', 'password', 'required|matches[pw2]');
        $valid->set_rules('pw2', 'konfirmasi password', 'required|matches[pw1]');
        $valid->set_rules('id_role', 'level', 'required');

        if ($valid->run()) {
            $this->user_model->insert($this->input->post());
            $this->session->set_flashdata('success', 'ditambah');
            redirect('user', 'refresh');
        }

        $data['judul'] = "Tambah Sales";
        $data['role'] = $this->db->get('role')->result_array();

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('user/tambah', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function ubah($id)
    {
        cek_akses('u');

        $valid = $this->form_validation;
        $valid->set_rules('nama_user', 'nama user', 'required');
        $valid->set_rules('jk', 'jenis kelamin', 'required');
        $valid->set_rules('id_user', 'ID user', 'required');
        $valid->set_rules('alamat', 'alamat', 'required');
        $valid->set_rules('telepon', 'telepon', 'required');
        $valid->set_rules('email', 'email', 'required');
        $valid->set_rules('id_role', 'level', 'required');

        if ($valid->run()) {
            $this->user_model->update($id, $this->input->post());
            $this->session->set_flashdata('success', 'diubah');
            redirect('user', 'refresh');
        }

        $data['judul'] = "Ubah Sales";
        $data['role'] = $this->db->get('role')->result_array();
        $data['user'] = $this->user_model->get_user($id);

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('user/ubah', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function export()
    {
        $user = $this->user_model->get_user();
        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Kode Sales')
            ->setCellValue('C1', 'Nama Sales')
            ->setCellValue('D1', 'Alamat')
            ->setCellValue('E1', 'Jenis Kelamin')
            ->setCellValue('F1', 'Telepon')
            ->setCellValue('G1', 'Email')
            ->setCellValue('H1', 'Level');
        // Miscellaneous glyphs, UTF-8
        $i = 2;
        foreach ($user as $row) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['id_user'])
                ->setCellValue('C' . $i, $row['nama_user'])
                ->setCellValue('D' . $i, $row['alamat'])
                ->setCellValue('E' . $i, $row['jk'])
                ->setCellValue('F' . $i, $row['telepon'])
                ->setCellValue('G' . $i, $row['email'])
                ->setCellValue('H' . $i, $row['nama_role']);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data user.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}

/* End of file user.php */
/* Location: ./application/modules/user/controllers/user.php */
