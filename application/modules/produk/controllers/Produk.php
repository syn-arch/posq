<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Produk extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        require FCPATH . 'vendor/autoload.php';
        $this->load->model('Produk_model');
        $this->load->model('kategori/Kategori_model');
        $this->load->library('form_validation');
        $this->load->library('datatables');
    }

    public function index()
    {
        $data['judul'] = 'Data Produk';

        $this->load->view('templates/header', $data);
        $this->load->view('produk/produk_list', $data);
        $this->load->view('templates/footer', $data);
    }

    public function json()
    {
        header('Content-Type: application/json');
        echo $this->Produk_model->json();
    }

    public function get_by_id($id)
    {
        header('Content-Type: application/json');
        echo json_encode($this->Produk_model->get_by_id($id));
    }

    public function read($id)
    {
        $row = $this->Produk_model->get_by_id($id);
        if ($row) {
            $data = array(
                'id_produk' => $row->id_produk,
                'id_kategori' => $row->id_kategori,
                'nama_produk' => $row->nama_produk,
                'sku' => $row->sku,
                'satuan' => $row->satuan,
                'harga_modal' => $row->harga_modal,
                'harga_jual' => $row->harga_jual,
                'stok' => $row->stok,
                'gambar' => $row->gambar,
                'keterangan' => $row->keterangan,
                'nama_kategori' => $row->nama_kategori,
            );


            $data['judul'] = 'Detail Produk';

            $this->load->view('templates/header', $data);
            $this->load->view('produk/produk_read', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('produk'));
        }
    }

    public function hapus_bulk()
    {
        cek_akses('d');

        foreach ($_POST['data'] as $id) {
            delImage('produk', $id, 'gambar');
            $this->db->delete('produk', ['id_produk' => $id]);
        }
    }

    public function create()
    {
        cek_akses('c');

        $data = array(
            'button' => 'Create',
            'action' => site_url('produk/create_action'),
            'id_produk' => set_value('id_produk'),
            'id_kategori' => set_value('id_kategori'),
            'nama_produk' => set_value('nama_produk'),
            'sku' => set_value('sku'),
            'satuan' => set_value('satuan'),
            'harga_modal' => set_value('harga_modal'),
            'harga_jual' => set_value('harga_jual'),
            'stok' => set_value('stok'),
            'gambar' => set_value('gambar'),
            'keterangan' => set_value('keterangan'),
        );

        $data['judul'] = 'Tambah Produk';
        $data['kategori'] = $this->Kategori_model->get_all();
        $this->load->view('templates/header', $data);
        $this->load->view('produk/produk_form', $data);
        $this->load->view('templates/footer', $data);
    }

    public function create_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
                'id_kategori' => $this->input->post('id_kategori', TRUE),
                'nama_produk' => $this->input->post('nama_produk', TRUE),
                'sku' => $this->input->post('sku', TRUE),
                'satuan' => $this->input->post('satuan', TRUE),
                'harga_modal' => $this->input->post('harga_modal', TRUE),
                'harga_jual' => $this->input->post('harga_jual', TRUE),
                'stok' => $this->input->post('stok', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
            );

            if ($_FILES['gambar']['name']) {
                $data['gambar'] = _upload('gambar', 'produk/create', 'produk');
            } else {
                $data['gambar'] = 'default.png';
            }

            $this->Produk_model->insert($data);
            $this->session->set_flashdata('success', 'Ditambah');
            redirect(site_url('produk'));
        }
    }

    public function update($id)
    {
        cek_akses('u');

        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('produk/update_action'),
                'id_produk' => set_value('id_produk', $row->id_produk),
                'id_kategori' => set_value('id_kategori', $row->id_kategori),
                'nama_produk' => set_value('nama_produk', $row->nama_produk),
                'sku' => set_value('sku', $row->sku),
                'satuan' => set_value('satuan', $row->satuan),
                'harga_modal' => set_value('harga_modal', $row->harga_modal),
                'harga_jual' => set_value('harga_jual', $row->harga_jual),
                'stok' => set_value('stok', $row->stok),
                'gambar' => set_value('gambar', $row->gambar),
                'keterangan' => set_value('keterangan', $row->keterangan),
            );

            $data['judul'] = 'Ubah Produk';
            $data['kategori'] = $this->Kategori_model->get_all();
            $this->load->view('templates/header', $data);
            $this->load->view('produk/produk_form', $data);
            $this->load->view('templates/footer', $data);
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('produk'));
        }
    }

    public function update_action()
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_produk', TRUE));
        } else {
            $data = array(
                'id_kategori' => $this->input->post('id_kategori', TRUE),
                'nama_produk' => $this->input->post('nama_produk', TRUE),
                'sku' => $this->input->post('sku', TRUE),
                'satuan' => $this->input->post('satuan', TRUE),
                'harga_modal' => $this->input->post('harga_modal', TRUE),
                'harga_jual' => $this->input->post('harga_jual', TRUE),
                'stok' => $this->input->post('stok', TRUE),
                'keterangan' => $this->input->post('keterangan', TRUE),
            );

            $id = $this->input->post('id_produk', TRUE);
            if ($_FILES['gambar']['name']) {
                $data['gambar'] = _upload('gambar', 'produk/update/' . $id, 'produk');
                delImage('produk', $id, 'gambar');
            }

            $this->Produk_model->update($this->input->post('id_produk', TRUE), $data);
            $this->session->set_flashdata('success', 'Diubah');
            redirect(site_url('produk'));
        }
    }

    public function delete($id)
    {
        cek_akses('d');
        delImage('produk', $id, 'gambar');
        $row = $this->Produk_model->get_by_id($id);

        if ($row) {
            $this->Produk_model->delete($id);
            $this->session->set_flashdata('success', 'Dihapus');
            redirect(site_url('produk'));
        } else {
            $this->session->set_flashdata('error', 'Data tidak ditemukan');
            redirect(site_url('produk'));
        }
    }

    public function _rules()
    {
        $this->form_validation->set_rules('id_kategori', 'id kategori', 'trim|required|numeric');
        $this->form_validation->set_rules('nama_produk', 'nama produk', 'trim|required');
        $this->form_validation->set_rules('satuan', 'satuan', 'trim|required');
        $this->form_validation->set_rules('harga_modal', 'harga modal', 'trim|required|numeric');
        $this->form_validation->set_rules('harga_jual', 'harga jual', 'trim|required|numeric');
        $this->form_validation->set_rules('stok', 'stok', 'trim|required');

        $this->form_validation->set_rules('id_produk', 'id_produk', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function excel()
    {
        $this->load->helper('exportexcel');
        $namaFile = "produk.xls";
        $judul = "produk";
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
        xlsWriteLabel($tablehead, $kolomhead++, "Id Kategori");
        xlsWriteLabel($tablehead, $kolomhead++, "Nama Produk");
        xlsWriteLabel($tablehead, $kolomhead++, "SKU");
        xlsWriteLabel($tablehead, $kolomhead++, "Satuan");
        xlsWriteLabel($tablehead, $kolomhead++, "Harga Modal");
        xlsWriteLabel($tablehead, $kolomhead++, "Harga Jual");
        xlsWriteLabel($tablehead, $kolomhead++, "Stok");
        xlsWriteLabel($tablehead, $kolomhead++, "Gambar");
        xlsWriteLabel($tablehead, $kolomhead++, "Keterangan");

        foreach ($this->Produk_model->get_all() as $data) {
            $kolombody = 0;

            //ubah xlsWriteLabel menjadi xlsWriteNumber untuk kolom numeric
            xlsWriteNumber($tablebody, $kolombody++, $nourut);
            xlsWriteNumber($tablebody, $kolombody++, $data->id_kategori);
            xlsWriteLabel($tablebody, $kolombody++, $data->nama_produk);
            xlsWriteLabel($tablebody, $kolombody++, $data->sku);
            xlsWriteLabel($tablebody, $kolombody++, $data->satuan);
            xlsWriteNumber($tablebody, $kolombody++, $data->harga_modal);
            xlsWriteNumber($tablebody, $kolombody++, $data->harga_jual);
            xlsWriteLabel($tablebody, $kolombody++, $data->stok);
            xlsWriteLabel($tablebody, $kolombody++, $data->gambar);
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
            'produk_data' => $this->Produk_model->get_all(),
            'start' => 0
        );

        ini_set('memory_limit', '32M');
        $html = $this->load->view('produk/produk_pdf', $data, true);
        $pdf = new \Mpdf\Mpdf();
        $pdf->WriteHTML($html);
        $pdf->Output('produk.pdf', 'D');
    }
}

/* End of file Produk.php */
                        /* Location: ./application/modules/E:\xampp\htdocs\posq\application/modules//controllers/Produk.php */
                        /* Please DO NOT modify this information : */
                        /* Generated by Harviacode Codeigniter CRUD Generator 2023-12-28 11:55:11 */
                        /* http://harviacode.com */
