<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';
        $this->load->model('laporan/Laporan_model');

        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function penjualan()
    {
        $data['judul'] = 'Laporan Penjualan';

        if ($this->input->get('dari')) {
            $data['laporan'] = $this->Laporan_model->get_laporan_penjualan($this->input->get('dari'), $this->input->get('sampai'));
        }

        $this->load->view('templates/header', $data);
        $this->load->view('laporan/penjualan', $data);
        $this->load->view('templates/footer', $data);
    }
}
