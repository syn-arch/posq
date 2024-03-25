<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Penawaran extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';
        $this->load->model('Penawaran_model');

        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['judul'] = 'Riwayat Penawaran';

        $this->load->view('templates/header', $data);
        $this->load->view('penawaran/penawaran_list', $data);
        $this->load->view('templates/footer', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Penawaran_model->json();
    }

    public function read($id)
    {
        $row = $this->Penawaran_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_penawaran' => $row->id_penawaran,
                'nama_penawaran' => $row->nama_penawaran,
                'produk' => $row->produk,
                'lampiran' => $row->lampiran,
                'keterangan' => $row->keterangan,
                'status' => $row->status,
            );


            $data['judul'] = 'Detail Penawaran';

            $this->load->view('templates/header', $data);
            $this->load->view('penawaran/penawaran_read', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('penawaran'));
        }
    }

    public function hapus_bulk()
    {
        cek_akses('d');

        foreach ($_POST['data'] as $id) {
            delImage('penawaran', $id, 'lampiran');
            $this->db->delete('penawaran', ['id_penawaran' => $id]);
        }
    }

    public function update_bulk()
    {
        cek_akses('u');

        foreach ($_POST['data'] as $row) {
            $this->db->set('status', $_POST['id_status']);
            $this->db->where('id_penawaran', $row);
            $this->db->update('penawaran');
        }
    }

    public function create()
    {
        cek_akses('c');

        $data = array(
            'button' => 'Create',
            'action' => site_url('penawaran/create_action'),
            'id_penawaran' => set_value('id_penawaran'),
            'nama_penawaran' => set_value('nama_penawaran'),
            'produk' => set_value('produk'),
            'lampiran' => set_value('lampiran'),
            'keterangan' => set_value('keterangan'),
        );

        $data['judul'] = 'Input Penawaran Baru';
        $this->load->view('templates/header', $data);
        $this->load->view('penawaran/penawaran_form', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $lampiran = _upload('lampiran', 'penawaran/create', 'penawaran');
            $data = array(
                'nama_penawaran' => $this->input->post('nama_penawaran', TRUE),
                'produk' => $this->input->post('produk', TRUE),
                'lampiran' => $lampiran,
                'keterangan' => $this->input->post('keterangan', TRUE),
                'status' => 'Penawaran Baru',
            );

            $id = $this->Penawaran_model->insert($data);

            redirect('https://wa.me?text=' . base_url('penawaran/lampiran/') . $id);

            $this->session->set_flashdata('success', 'Ditambah');
            redirect(site_url('penawaran'));
        }
    }

    public function lampiran($id)
    {
        $lampiran = $this->Penawaran_model->get_by_id($id)->lampiran;

        force_download('assets/img/penawaran/' . $lampiran, null, true);

    }

    public function update($id)
    {
        cek_akses('u');

        $row = $this->Penawaran_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('penawaran/update_action'),
                'id_penawaran' => set_value('id_penawaran', $row->id_penawaran),
                'nama_penawaran' => set_value('nama_penawaran', $row->nama_penawaran),
                'produk' => set_value('produk', $row->produk),
                'lampiran' => set_value('lampiran', $row->lampiran),
                'keterangan' => set_value('keterangan', $row->keterangan),
                'status' => set_value('status', $row->status),
            );

            $data['judul'] = 'Ubah Penawaran';
            $this->load->view('templates/header', $data);
            $this->load->view('penawaran/penawaran_form', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('penawaran'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_penawaran', TRUE));
        } else {
            $data = array(
                'nama_penawaran' => $this->input->post('nama_penawaran', TRUE),
                'produk' => $this->input->post('produk', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
                'status' => $this->input->post('status', TRUE),
            );

            $id = $this->input->post('id_penawaran', TRUE);
            if ($_FILES['lampiran']['name']) {
                $data['lampiran'] = _upload('lampiran', 'penawaran/update/' . $id, 'penawaran');
                delImage('penawaran', $id, 'lampiran');
            }

            $this->Penawaran_model->update($this->input->post('id_penawaran', TRUE), $data);
            $this->session->set_flashdata('success', 'Diubah');
            redirect(site_url('penawaran'));
        }
    }

    public function delete($id)
    {
        cek_akses('d');
        delImage('penawaran', $id, 'lampiran');
        $row = $this->Penawaran_model->get_by_id($id);

        if ($row) {
            $this->Penawaran_model->delete($id);
            $this->session->set_flashdata('success', 'Dihapus');
            redirect(site_url('penawaran'));
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('penawaran'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('nama_penawaran', 'nama penawaran', 'trim|required');
        $this->form_validation->set_rules('produk', 'produk', 'trim|required');

        $this->form_validation->set_rules('id_penawaran', 'id_penawaran', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "penawaran.xls";
        $judul = "penawaran";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Penawaran");
        xlsWriteLabel($tablehead, $kolomhead++, "Produk");
        xlsWriteLabel($tablehead, $kolomhead++, "Lampiran");
        xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");
        xlsWriteLabel($tablehead, $kolomhead++, "Status");

        foreach ($this->Penawaran_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_penawaran);
            xlsWriteLabel($tablebody, $kolombody++, $data->produk);
            xlsWriteLabel($tablebody, $kolombody++, $data->lampiran);
            xlsWriteLabel($tablebody, $kolombody++, $data->keterangan);
            xlsWriteLabel($tablebody, $kolombody++, $data->status);

            $tablebody++;
            $nourut++;
        }

        xlsEOF();
        exit();
    }

    public function word()
    {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=penawaran.doc");

        $data = array(
            'penawaran_data' => $this->Penawaran_model->get_all(),
            'start' => 0
        );

        $this->load->view('penawaran/penawaran_doc', $data);
    }

    function pdf()
    {
        $data = array(
            'penawaran_data' => $this->Penawaran_model->get_all(),
            'start' => 0
        );

        ini_set('memory_limit', '32M');
        $html = $this->load->view('penawaran/penawaran_pdf', $data, true);
        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($html);
        $pdf->Output('penawaran.pdf', 'D');
    }
}

/* End of file Penawaran.php */
                        /* Location: ./application/modules/D:\xampp\htdocs\posq\application/modules//controllers/Penawaran.php */
                        /* Please DO NOT modify this information : */
                        /* Generated by Harviacode Codeigniter CRUD Generator 2024-03-21 15:17:45 */
                        /* http://harviacode.com */
