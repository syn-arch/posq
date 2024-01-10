<?php
defined('BASEPATH') or exit('No direct script access allowed');

require './vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class laporan extends MX_Controller
{

    public function __construct()
    {
        parent::__construct();
        cek_login();
        $this->load->model('laporan/laporan_model');
        $this->load->model('produk/produk_model');
    }

    public function penjualan()
    {
        $data['judul'] = "Laporan Penjualan";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('laporan/penjualan', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function paling_banyak_dijual()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_outlet = $this->input->get('id_outlet');
        $data['outlet'] = $this->outlet_model->get_outlet();

        if ($dari != '') {
            $data['laporan'] = $this->laporan_model->get_paling_banyak_dijual($dari, $sampai, $id_outlet);
        } else {
            $data['laporan'] = $this->laporan_model->get_paling_banyak_dijual();
        }

        $data['judul'] = "Laporan produk Paling Banyak Dijual";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('laporan/paling_banyak_dijual', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function export_paling_banyak_dijual($dari = '', $sampai = '', $id_outlet = '')
    {
        if ($dari != '') {
            $laporan = $this->laporan_model->get_paling_banyak_dijual($dari, $sampai, $id_outlet);
        } else {
            $laporan = $this->laporan_model->get_paling_banyak_dijual();
        }


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Kode produk')
            ->setCellValue('B1', 'Nama produk')
            ->setCellValue('C1', 'Kuantitas');
        // Miscellaneous glyphs, UTF-8
        $i = 2;
        foreach ($laporan as $row) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['id_produk'])
                ->setCellValue('B' . $i, $row['nama_produk'])
                ->setCellValue('C' . $i, $row['kuantitas']);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Paling Banyak Dijual.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function paling_sering_dijual()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_outlet = $this->input->get('id_outlet');
        $data['outlet'] = $this->outlet_model->get_outlet();

        if ($dari != '') {
            $data['laporan'] = $this->laporan_model->get_paling_sering_dijual($dari, $sampai, $id_outlet);
        } else {
            $data['laporan'] = $this->laporan_model->get_paling_sering_dijual();
        }

        $data['judul'] = "Laporan produk Paling Sering Dijual";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('laporan/paling_sering_dijual', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function export_paling_sering_dijual($dari = '', $sampai = '', $id_outlet = '')
    {
        if ($dari != '') {
            $laporan = $this->laporan_model->get_paling_sering_dijual($dari, $sampai, $id_outlet);
        } else {
            $laporan = $this->laporan_model->get_paling_sering_dijual();
        }


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Kode produk')
            ->setCellValue('B1', 'Nama produk')
            ->setCellValue('C1', 'kali');
        // Miscellaneous glyphs, UTF-8
        $i = 2;
        foreach ($laporan as $row) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['id_produk'])
                ->setCellValue('B' . $i, $row['nama_produk'])
                ->setCellValue('C' . $i, $row['kali']);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Paling sering Dijual.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function per_kasir()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');

        if ($dari != '') {
            $data['laporan'] = $this->laporan_model->get_per_kasir($dari, $sampai);
        } else {
            $data['laporan'] = $this->laporan_model->get_per_kasir();
        }

        $data['judul'] = "Laporan Per kasir";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('laporan/per_kasir', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function export_per_kasir($dari = '', $sampai = '', $id_outlet = '')
    {
        if ($dari != '') {
            $laporan = $this->laporan_model->get_per_kasir($dari, $sampai, $id_outlet);
        } else {
            $laporan = $this->laporan_model->get_per_kasir();
        }


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Kode Kasir')
            ->setCellValue('B1', 'Nama Kasir')
            ->setCellValue('C1', 'Penjualan')
            ->setCellValue('D1', 'Pendapatan');
        // Miscellaneous glyphs, UTF-8
        $i = 2;
        foreach ($laporan as $row) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['id_petugas'])
                ->setCellValue('B' . $i, $row['nama_petugas'])
                ->setCellValue('C' . $i, $row['transaksi'])
                ->setCellValue('D' . $i, $row['pendapatan']);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Per Kasir.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function per_kategori()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_outlet = $this->input->get('id_outlet');
        $data['outlet'] = $this->outlet_model->get_outlet();

        if ($dari != '') {
            $data['laporan'] = $this->laporan_model->get_per_kategori($dari, $sampai, $id_outlet);
        } else {
            $data['laporan'] = $this->laporan_model->get_per_kategori();
        }

        $data['judul'] = "Laporan Per kategori";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('laporan/per_kategori', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function export_per_kategori($dari = '', $sampai = '', $id_outlet = '')
    {
        if ($dari != '') {
            $laporan = $this->laporan_model->get_per_kategori($dari, $sampai, $id_outlet);
        } else {
            $laporan = $this->laporan_model->get_per_kategori();
        }


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Kode kategori')
            ->setCellValue('B1', 'Nama kategori')
            ->setCellValue('C1', 'Penjualan')
            ->setCellValue('D1', 'Pendapatan');
        // Miscellaneous glyphs, UTF-8
        $i = 2;
        foreach ($laporan as $row) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['id_kategori'])
                ->setCellValue('B' . $i, $row['nama_kategori'])
                ->setCellValue('C' . $i, $row['penjualan'])
                ->setCellValue('D' . $i, $row['pendapatan']);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Per kategori.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function per_pelanggan()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_outlet = $this->input->get('id_outlet');
        $data['outlet'] = $this->outlet_model->get_outlet();

        if ($dari != '') {
            $data['laporan'] = $this->laporan_model->get_per_pelanggan($dari, $sampai, $id_outlet);
        } else {
            $data['laporan'] = $this->laporan_model->get_per_pelanggan();
        }

        $data['judul'] = "Laporan Per Pelanggan";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('laporan/per_pelanggan', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function export_per_pelanggan($dari = '', $sampai = '', $id_outlet = '')
    {
        if ($dari != '') {
            $laporan = $this->laporan_model->get_per_pelanggan($dari, $sampai, $id_outlet);
        } else {
            $laporan = $this->laporan_model->get_per_pelanggan();
        }


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Kode pelanggan')
            ->setCellValue('B1', 'Nama pelanggan')
            ->setCellValue('C1', 'Penjualan')
            ->setCellValue('D1', 'Pendapatan');
        // Miscellaneous glyphs, UTF-8
        $i = 2;
        foreach ($laporan as $row) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['id_pelanggan'])
                ->setCellValue('B' . $i, $row['nama_pelanggan'])
                ->setCellValue('C' . $i, $row['penjualan'])
                ->setCellValue('D' . $i, $row['pendapatan']);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Per pelanggan.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function per_supplier()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_outlet = $this->input->get('id_outlet');
        $data['outlet'] = $this->outlet_model->get_outlet();

        if ($dari != '') {
            $data['laporan'] = $this->laporan_model->get_per_supplier($dari, $sampai, $id_outlet);
        } else {
            $data['laporan'] = $this->laporan_model->get_per_supplier();
        }

        $data['judul'] = "Laporan Per Supplier";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('laporan/per_supplier', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function export_per_supplier($dari = '', $sampai = '', $id_outlet = '')
    {
        if ($dari != '') {
            $laporan = $this->laporan_model->get_per_supplier($dari, $sampai, $id_outlet);
        } else {
            $laporan = $this->laporan_model->get_per_supplier();
        }


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Kode Supplier')
            ->setCellValue('B1', 'Nama supplier')
            ->setCellValue('C1', 'Penjualan')
            ->setCellValue('D1', 'Pendapatan');
        // Miscellaneous glyphs, UTF-8
        $i = 2;
        foreach ($laporan as $index => $row) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['id_supplier'])
                ->setCellValue('B' . $i, $row['nama_supplier'])
                ->setCellValue('C' . $i, $row['penjualan'])
                ->setCellValue('D' . $i, $row['pendapatan']);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Per supplier.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function pembelian()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');

        if ($dari != '') {
            $data['laporan'] = $this->laporan_model->get_all_pembelian($dari, $sampai);
            $data['total_pembelian'] = $this->laporan_model->get_total_pembelian($dari, $sampai);
        } else {
            $data['laporan'] = $this->laporan_model->get_all_pembelian();
            $data['total_pembelian'] = $this->laporan_model->get_total_pembelian();
        }

        $data['judul'] = "Laporan Pembelian";

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('laporan/pembelian', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }
    public function omset()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_outlet = $this->input->get('id_outlet');

        $data['omset'] = $this->laporan_model->get_omset($dari, $sampai, $id_outlet);
        $data['qty'] = $this->laporan_model->get_qty_beli($dari, $sampai, $id_outlet);

        $data['judul'] = "Laporan Omset";
        $data['outlet'] = $this->outlet_model->get_outlet();

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('laporan/omset', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function laba_rugi()
    {
        $dari = $this->input->get('dari');
        $sampai = $this->input->get('sampai');
        $id_outlet = $this->input->get('id_outlet');
        $id_produk = $this->input->get('id_produk');

        if ($dari != '') {
            $data['laba_rugi'] = $this->laporan_model->get_laba_rugi($dari, $sampai, $id_outlet, $id_produk);

            $data['penjualan'] = $this->laporan_model->get_total_penjualan($dari, $sampai, $id_outlet, $id_produk);
            $data['potongan_penjualan'] = $this->laporan_model->get_potongan_penjualan($dari, $sampai, $id_outlet);
            $data['diskon_penjualan'] = $this->laporan_model->get_diskon_penjualan($dari, $sampai, $id_outlet);
            $data['penjualan_bersih'] = $this->laporan_model->get_penjualan_bersih($dari, $sampai, $id_outlet);

            $data['pembelian_bersih'] = $this->laporan_model->get_pembelian_bersih($dari, $sampai, $id_outlet, $id_produk);

            $data['pemasukan'] = $this->laporan_model->get_pemasukan($dari, $sampai, $id_outlet);
            $data['pengeluaran'] = $this->laporan_model->get_pengeluaran($dari, $sampai, $id_outlet);

            $data['detail_pengeluaran'] = $this->laporan_model->get_detail_pengeluaran($dari, $sampai, $id_outlet);
            $data['detail_pemasukan'] = $this->laporan_model->get_detail_pemasukan($dari, $sampai, $id_outlet);

            $data['laba_rugi'] = $this->laporan_model->get_profit($dari, $sampai, $id_outlet, $id_produk);

            $data['pembelian_list'] = $this->laporan_model->get_pembelian_list($dari, $sampai, $id_outlet, $id_produk);
            $data['penjualan_list'] = $this->laporan_model->get_penjualan_list($dari, $sampai, $id_outlet, $id_produk);
        }

        $data['judul'] = "Laporan Laba Rugi";
        $data['outlet'] = $this->outlet_model->get_outlet();
        $data['produk'] = $this->produk_model->get_produk();

        $this->load->view('templates/header', $data, FALSE);
        $this->load->view('laporan/laba_rugi', $data, FALSE);
        $this->load->view('templates/footer', $data, FALSE);
    }

    public function export_omset($dari = '', $sampai = '', $id_outlet = '')
    {
        $omset = $this->laporan_model->get_omset($dari, $sampai, $id_outlet);
        $qty = $this->laporan_model->get_qty_beli($dari, $sampai, $id_outlet);


        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Tanggal')
            ->setCellValue('B1', 'Net Sales')
            ->setCellValue('C1', 'Total Charge')
            ->setCellValue('D1', 'Total Sales')
            ->setCellValue('E1', 'Total Customer')
            ->setCellValue('F1', 'Total Qty')
            ->setCellValue('G1', 'Total Beli');
        // Miscellaneous glyphs, UTF-8
        $i = 2;
        foreach ($omset as $index => $row) {

            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['tgl_penjualan'])
                ->setCellValue('B' . $i, $row['net_sales'])
                ->setCellValue('C' . $i, $row['ttl_charge'])
                ->setCellValue('D' . $i, $row['ttl_sales'])
                ->setCellValue('E' . $i, $row['ttl_customer'])
                ->setCellValue('F' . $i, $qty[$index]['ttl_qty'])
                ->setCellValue('G' . $i, $qty[$index]['ttl_beli']);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Omset.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

    public function export_pembelian($dari = '', $sampai = '')
    {
        if ($dari != '') {
            $pembelian = $this->laporan_model->get_all_pembelian($dari, $sampai);
        } else {
            $pembelian = $this->laporan_model->get_all_pembelian();
        }

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Kode produk')
            ->setCellValue('B1', 'Barcode')
            ->setCellValue('C1', 'Nama produk')
            ->setCellValue('D1', 'Harga')
            ->setCellValue('E1', 'Jumlah')
            ->setCellValue('F1', 'Total');
        // Miscellaneous glyphs, UTF-8
        $i = 2;
        foreach ($pembelian as $row) {
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $i, $row['id_produk'])
                ->setCellValue('B' . $i, $row['barcode'])
                ->setCellValue('C' . $i, $row['nama_produk'])
                ->setCellValue('D' . $i, $row['harga_pokok'])
                ->setCellValue('E' . $i, $row['produk_terbeli'])
                ->setCellValue('F' . $i, $row['total']);
            $i++;
        }

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Laporan Pembelian.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }

}

/* End of file laporan.php */
/* Location: ./application/modules/laporan/controllers/laporan.php */
