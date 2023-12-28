<?php
defined('BASEPATH') or exit('No direct script access allowed');

class akses extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->model('akses/akses_model');
    }

    public function hapus($id)
    {
        $this->akses_model->delete($id);
        $this->session->set_flashdata('success', 'dihapus');
        redirect('akses', 'refresh');
    }

    public function index()
    {
        $data['judul'] = "Akses Menu Sales";
        $data['role'] = $this->akses_model->get_akses();

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('akses/index', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function tambah()
    {
        $valid = $this->form_validation;
        $valid->set_rules('nama_role', 'nama_role', 'required');

        if ($valid->run()) {
            $this->akses_model->insert($this->input->post());
            $this->session->set_flashdata('success', 'ditambah');
            redirect('user/akses', 'refresh');
        }

        $data['judul'] = "Tambah Role";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('akses/tambah', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function ubah($id)
    {
        $data['judul'] = "Ubah akses";
        $data['role'] = $this->akses_model->get_akses($id);
        $data['akses'] = $this->akses_model->get_akses_role($id);

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('akses/ubah', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function ubah_akses($id_menu, $id_role)
    {
        $data = [
            'id_menu' => $id_menu,
            'id_role' => $id_role
        ];

        $akses = $this->db->get_where('akses_role', $data)->row_array();

        if ($akses) {
            $this->db->delete('akses_role', $data);
        } else {
            $this->db->insert('akses_role', $data);
        }
    }

    public function ubah_crud_akses($id_menu, $id_role, $access)
    {
        $this->db->select($access);
        $this->db->where('id_menu', $id_menu);
        $this->db->where('id_role', $id_role);
        $result = $this->db->get('akses_role')->row_array()[$access];

        if ($result) {
            $this->db->set($access, 0);
            $this->db->where('id_menu', $id_menu);
            $this->db->where('id_role', $id_role);
            $this->db->update('akses_role');
        } else {
            $this->db->set($access, 1);
            $this->db->where('id_menu', $id_menu);
            $this->db->where('id_role', $id_role);
            $this->db->update('akses_role');
        }
    }

    public function grant_all($id_role)
    {
        $menu = $this->db->get('menu')->result();

        $this->db->delete('akses_role', ['id_role' => $id_role]);

        foreach ($menu as $row) {
            $data = [
                'id_menu' => $row->id_menu,
                'id_role' => $id_role
            ];

            if ($row->crudable) {
                $data['c'] = 1;
                $data['u'] = 1;
                $data['d'] = 1;
            }

            $this->db->insert('akses_role', $data);
        }

        $this->session->set_flashdata('success', 'ditambah');
        redirect('user/ubah_akses/' . $id_role, 'refresh');
    }
}

/* End of file akses.php */
/* Location: ./application/modules/akses/controllers/akses.php */
