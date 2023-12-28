<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

    public function index()
    {
        cek_login();

        $data['judul'] = "Dashboard";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('dashboard/index', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }
}
