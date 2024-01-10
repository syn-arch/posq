<?php
defined('BASEPATH') or exit('No direct script access allowed');

class laporan_model extends CI_Model
{

    public function get_total_keuangan()
    {
        $this->db->select_sum('total_bayar', 'total');
        $this->db->where('piutang', 0);
        $this->db->where('DATE(penjualan.tgl)', date('Y-m-d'));
        $this->db->join('penjualan', 'faktur_penjualan');
        $penjualan = $this->db->get('pembayaran')->row_array()['total'];

        $this->db->select_sum('nominal', 'total');
        $this->db->where('DATE(penjualan.tgl)', date('Y-m-d'));
        $this->db->where('piutang', 1);
        $this->db->join('penjualan', 'faktur_penjualan');
        $piutang = $this->db->get('pembayaran')->row_array()['total'];


        return [
            'penjualan' => $penjualan,
            'piutang' => $piutang,
        ];
    }

    public function get_total_pendapatan($golongan, $dari = '', $sampai = '', $id_outlet = '')
    {
        if ($id_outlet != '') {
            $id_outlet = "AND id_outlet = '$id_outlet'";
        } else {
            $id_outlet = "";
        }

        if ($dari != '') {
            $query = "SELECT 
			SUM(total_harga) AS total_bayar
			FROM penjualan 
			JOIN detail_penjualan USING(faktur_penjualan)
			WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai'
			AND type_golongan = '$golongan' AND status != 'Hold' " . $id_outlet;
        } else {
            $query = "SELECT 
			SUM(total_harga) AS total_bayar
			FROM penjualan 
			JOIN detail_penjualan USING(faktur_penjualan)
			WHERE type_golongan = '$golongan' AND status != 'Hold' ";
        }

        return  $this->db->query($query)->row()->total_bayar;
    }

    public function get_total_laba($golongan, $dari = '', $sampai = '', $id_outlet = '')
    {
        if ($id_outlet != '') {
            $id_outlet = "AND id_outlet = '$id_outlet'";
        } else {
            $id_outlet = "";
        }

        if ($golongan == 'golongan_1') {
            $profit = 'profit_1';
        }
        if ($golongan == 'golongan_2') {
            $profit = 'profit_2';
        }
        if ($golongan == 'golongan_3') {
            $profit = 'profit_3';
        }
        if ($golongan == 'golongan_4') {
            $profit = 'profit_4';
        }

        if ($dari != '') {

            $query = " SELECT SUM(laba_bersih) AS total_laba_bersih
			FROM(
				SELECT 
				{$profit} * jumlah AS 'laba_bersih'
				FROM detail_penjualan 
				JOIN penjualan USING(faktur_penjualan) 
				JOIN barang USING(id_barang)
				WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai'
				AND type_golongan = '$golongan' AND status != 'Hold'
				" . $id_outlet . "
				) t
				";
        } else {

            $query = " SELECT SUM(laba_bersih) AS total_laba_bersih
				FROM(
					SELECT 
					{$profit} * jumlah AS 'laba_bersih'
					FROM detail_penjualan 
					JOIN penjualan USING(faktur_penjualan) 
					JOIN barang USING(id_barang)
					WHERE type_golongan = '$golongan' AND status != 'Hold'
					) t
				";
        }

        return $this->db->query($query)->row_array()['total_laba_bersih'];
    }


    public function get_paling_banyak_dijual($dari = '', $sampai = '', $id_outlet = '')
    {

        $this->db->select('barang.id_barang, nama_barang, SUM(detail_penjualan.jumlah) AS kuantitas');
        $this->db->join('detail_penjualan', 'faktur_penjualan');
        $this->db->join('barang', 'barang.id_barang = detail_penjualan.id_barang');
        $this->db->order_by('kuantitas', 'DESC');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tgl) >=', $dari);
            $this->db->where('DATE(penjualan.tgl) <=', $sampai);
        }
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        $this->db->group_by('id_barang');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_paling_sering_dijual($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select('barang.id_barang, nama_barang, COUNT(detail_penjualan.id_barang) AS kali');
        $this->db->join('detail_penjualan', 'faktur_penjualan');
        $this->db->join('barang', 'barang.id_barang = detail_penjualan.id_barang');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tgl) >=', $dari);
            $this->db->where('DATE(penjualan.tgl) <=', $sampai);
        }
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        $this->db->order_by('kali', 'DESC');
        $this->db->group_by('id_barang');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_kasir($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select_sum('total_bayar', 'pendapatan');
        $this->db->select('id_petugas, nama_petugas, COUNT(faktur_penjualan) AS transaksi');
        $this->db->join('petugas', 'id_petugas');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tgl) >=', $dari);
            $this->db->where('DATE(penjualan.tgl) <=', $sampai);
        }
        $this->db->group_by('id_petugas');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_karyawan($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select_sum('total_bayar', 'pendapatan');
        $this->db->select('id_karyawan, nama_karyawan, COUNT(faktur_penjualan) AS transaksi');
        $this->db->join('karyawan', 'id_karyawan');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tgl) >=', $dari);
            $this->db->where('DATE(penjualan.tgl) <=', $sampai);
        }
        $this->db->group_by('id_karyawan');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_kategori($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select('barang.id_kategori, nama_kategori, COUNT(faktur_penjualan) AS penjualan');
        $this->db->select_sum('total_harga', 'pendapatan');
        $this->db->join('detail_penjualan', 'faktur_penjualan');
        $this->db->join('barang', 'id_barang');
        $this->db->join('kategori', 'barang.id_kategori=kategori.id_kategori');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tgl) >=', $dari);
            $this->db->where('DATE(penjualan.tgl) <=', $sampai);
        }
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        $this->db->group_by('id_kategori');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_pelanggan($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select('id_pelanggan, nama_pelanggan, COUNT(faktur_penjualan) AS penjualan');
        $this->db->select_sum('total_bayar', 'pendapatan');
        $this->db->join('pelanggan', 'id_pelanggan');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tgl) >=', $dari);
            $this->db->where('DATE(penjualan.tgl) <=', $sampai);
        }
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        $this->db->group_by('id_pelanggan');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_jenis_pelanggan($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select('jenis, COUNT(faktur_penjualan) AS penjualan');
        $this->db->select_sum('total_bayar', 'pendapatan');
        $this->db->join('pelanggan', 'id_pelanggan');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tgl) >=', $dari);
            $this->db->where('DATE(penjualan.tgl) <=', $sampai);
        }
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        $this->db->group_by('jenis');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_supplier($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select('barang.id_supplier, nama_supplier, COUNT(faktur_penjualan) AS penjualan');
        $this->db->select_sum('total_harga', 'pendapatan');
        $this->db->join('detail_penjualan', 'faktur_penjualan');
        $this->db->join('barang', 'id_barang');
        $this->db->join('supplier', 'barang.id_supplier=supplier.id_supplier');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tgl) >=', $dari);
            $this->db->where('DATE(penjualan.tgl) <=', $sampai);
        }
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        $this->db->group_by('id_supplier');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_omset($dari = '', $sampai = '', $id_outlet = '')
    {
        if ($id_outlet != '') {
            $id_outlet = "AND id_outlet = '$id_outlet'";
        } else {
            $id_outlet = "";
        }

        if ($dari != '') {
            $query = "
				SELECT 
				DATE(tgl) AS tgl_penjualan,
				SUM(total_bayar) AS net_sales,
				SUM(diskon) AS ttl_charge,
				(SUM(diskon) / 100 ) * SUM(total_bayar) AS harga_diskon,
				SUM(total_bayar) - (SUM(diskon) / 100 ) * SUM(total_bayar) AS ttl_sales,
				COUNT(faktur_penjualan) AS ttl_customer
				FROM penjualan a
				WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai' " . $id_outlet . "
				GROUP BY DATE(tgl)
				";
        } else {
            $query = "
				SELECT 
				DATE(tgl) AS tgl_penjualan,
				SUM(total_bayar) AS net_sales,
				SUM(diskon) AS ttl_charge,
				(SUM(diskon) / 100 ) * SUM(total_bayar) AS harga_diskon,
				SUM(total_bayar) - (SUM(diskon) / 100 ) * SUM(total_bayar) AS ttl_sales,
				COUNT(faktur_penjualan) AS ttl_customer
				FROM penjualan a
				GROUP BY DATE(tgl)
				";
        }


        return $this->db->query($query)->result_array();
    }

    public function get_qty_beli($dari = '', $sampai = '', $id_outlet = '')
    {
        if ($id_outlet != '') {
            $id_outlet = "AND id_outlet = '$id_outlet'";
        } else {
            $id_outlet = "";
        }

        if ($dari != '') {
            $query = "
				SELECT 
				SUM(jumlah) AS ttl_qty,
				COUNT(jumlah) AS ttl_beli
				FROM penjualan
				JOIN detail_penjualan USING(faktur_penjualan)
				WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai' " . $id_outlet . "
				GROUP BY DATE(tgl)
				";
        } else {
            $query = "
				SELECT 
				SUM(jumlah) AS ttl_qty,
				COUNT(jumlah) AS ttl_beli
				FROM penjualan
				JOIN detail_penjualan USING(faktur_penjualan)
				GROUP BY DATE(tgl)
				";
        }

        return $this->db->query($query)->result_array();
    }

    public function get_all_pembelian($dari = '', $sampai = '')
    {

        if ($dari != '') {
            $query = "SELECT
				`barang`.`nama_barang`,
				`barang`.`barcode`,
				`barang`.`harga_pokok`,
				`barang`.`id_barang`,
				SUM(`detail_pembelian`.`jumlah`) AS 'barang_terbeli',
				`barang`.`harga_pokok` * SUM(`detail_pembelian`.`jumlah`) AS 'total'
				FROM pembelian
				JOIN detail_pembelian USING(faktur_pembelian)
				LEFT JOIN barang USING(id_barang)
				WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai'
				GROUP BY `barang`.`id_barang`
				";
        } else {
            $query = "SELECT
				`barang`.`nama_barang`,
				`barang`.`barcode`,
				`barang`.`harga_pokok`,
				`barang`.`id_barang`,
				SUM(`detail_pembelian`.`jumlah`) AS 'barang_terbeli',
				`barang`.`harga_pokok` * SUM(`detail_pembelian`.`jumlah`) AS 'total'
				FROM pembelian
				JOIN detail_pembelian USING(faktur_pembelian)
				LEFT JOIN barang USING(id_barang)
				GROUP BY `barang`.`id_barang`
				";
        }



        return $this->db->query($query)->result_array();
    }

    public function get_total_pembelian($dari = '', $sampai = '')
    {
        $this->db->select_sum('total_bayar', 'total');
        if ($dari != '') {
            $this->db->where('DATE(pembelian.tgl) >=', $dari);
            $this->db->where('DATE(pembelian.tgl) <=', $sampai);
        }
        return $this->db->get('pembelian')->row_array()['total'];
    }

    public function get_all_hutang()
    {
        $query = " 
			SELECT *,nama_supplier, total_bayar AS jumlah_hutang,
			SUM(nominal) AS telah_dibayar
			FROM pembelian
			JOIN supplier USING(id_supplier)
			JOIN pembayaran_pembelian USING(faktur_pembelian)
			WHERE status = 'Belum Lunas'
			GROUP BY faktur_pembelian
			ORDER BY DATE(pembelian.tgl) DESC
			";

        return $this->db->query($query)->result_array();
    }

    public function get_total_hutang()
    {
        $query = " 
			SELECT SUM(total_bayar) AS jumlah_hutang
			FROM pembelian
			WHERE status = 'Belum Lunas'
			";

        return $this->db->query($query)->row()->jumlah_hutang;
    }

    public function get_sisa_hutang()
    {
        $query = " 
			SELECT *,nama_supplier, SUM(total_bayar) AS jumlah_hutang,
			SUM(nominal) AS telah_dibayar,
			(SUM(total_bayar) - SUM(nominal)) AS sisa_hutang
			FROM pembelian
			JOIN supplier USING(id_supplier)
			JOIN pembayaran_pembelian USING(faktur_pembelian)
			WHERE status = 'Belum Lunas'
			";

        return $this->db->query($query)->row()->sisa_hutang;
    }

    public function get_telah_dibayar()
    {
        $query = " 
			SELECT *,nama_supplier, SUM(total_bayar) AS jumlah_hutang,
			SUM(nominal) AS telah_dibayar,
			(SUM(total_bayar) - SUM(nominal)) AS sisa_hutang
			FROM pembelian
			JOIN supplier USING(id_supplier)
			JOIN pembayaran_pembelian USING(faktur_pembelian)
			WHERE status = 'Belum Lunas'
			";

        return $this->db->query($query)->row()->telah_dibayar;
    }

    public function get_all_piutang()
    {
        $query = " 
			SELECT *,nama_pelanggan, total_bayar AS jumlah_piutang,penjualan.tgl,
			SUM(nominal) AS telah_dibayar
			FROM penjualan
			JOIN pelanggan USING(id_pelanggan)
			LEFT JOIN pembayaran USING(faktur_penjualan)
			WHERE status = 'Belum Lunas'
			GROUP BY faktur_penjualan
			ORDER BY DATE(penjualan.tgl) DESC
			";

        return $this->db->query($query)->result_array();
    }

    public function get_total_piutang()
    {
        $query = " 
			SELECT SUM(total_bayar) AS jumlah_piutang
			FROM penjualan
			WHERE status = 'Belum Lunas'
			";

        return $this->db->query($query)->row()->jumlah_piutang;
    }

    public function get_sisa_piutang()
    {
        $query = " 
			SELECT *, SUM(total_bayar) AS jumlah_piutang,
			SUM(nominal) AS telah_dibayar,
			(SUM(total_bayar) - SUM(nominal)) AS sisa_piutang
			FROM penjualan
			JOIN pelanggan USING(id_pelanggan)
			JOIN pembayaran USING(faktur_penjualan)
			WHERE status = 'Belum Lunas'
			";

        return $this->db->query($query)->row()->sisa_piutang;
    }

    public function get_telah_dibayar_piutang()
    {
        $query = " 
			SELECT *, SUM(total_bayar) AS jumlah_piutang,
			SUM(nominal) AS telah_dibayar,
			(SUM(total_bayar) - SUM(nominal)) AS sisa_piutang
			FROM penjualan
			JOIN pelanggan USING(id_pelanggan)
			JOIN pembayaran USING(faktur_penjualan)
			WHERE status = 'Belum Lunas'
			";

        return $this->db->query($query)->row()->telah_dibayar;
    }

    public function get_pendapatan($dari, $sampai, $id_outlet = '', $bersih = false)
    {
        if ($id_outlet == '') {
            $outlet = '';
        } else {
            $outlet = "AND id_outlet = '$id_outlet'";
        }

        $query = " 
			SELECT SUM(total_bayar) AS total_pendapatan
			FROM penjualan
			WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai' AND status != 'Hold' " . $outlet;

        return $this->db->query($query)->row()->total_pendapatan;
    }

    public function get_laba_rugi($dari, $sampai)
    {
        $query = "SELECT DATE(tgl) AS tanggal, SUM(total_bayar) AS total FROM penjualan WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai' AND status != 'Hold' GROUP BY DATE(tgl) ";
        return $this->db->query($query)->result_array();
    }

    public function get_potongan($dari, $sampai, $id_outlet = '')
    {
        if ($id_outlet == '') {
            $outlet = '';
        } else {
            $outlet = "AND id_outlet = '$id_outlet'";
        }

        $query = " 
			SELECT SUM(potongan) AS total_potongan
			FROM detail_penjualan
			JOIN penjualan USING(faktur_penjualan)
			WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai' AND status != 'Hold' " . $outlet;

        return $this->db->query($query)->row()->total_potongan;
    }



    public function get_pendapatan_bersih($dari, $sampai, $id_outlet = '')
    {
        if ($id_outlet == '') {
            $outlet = '';
        } else {
            $outlet = "AND id_outlet = '$id_outlet'";
        }

        $query1 = " 
			SELECT SUM(laba_bersih) AS g1
			FROM(
				SELECT 
				profit_1 * jumlah AS 'laba_bersih'
				FROM detail_penjualan 
				JOIN penjualan USING(faktur_penjualan) 
				JOIN barang USING(id_barang)
				WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai'
				AND type_golongan = 'golongan_1' AND status != 'Hold'
				" . $outlet . "
			) t";

        $g1 =  $this->db->query($query1)->row()->g1;

        $query2 = " 
			SELECT SUM(laba_bersih) AS g2
			FROM(
				SELECT 
				profit_2 * jumlah AS 'laba_bersih'
				FROM detail_penjualan 
				JOIN penjualan USING(faktur_penjualan) 
				JOIN barang USING(id_barang)
				WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai'
				AND type_golongan = 'golongan_2' AND status != 'Hold'
				" . $outlet . "
			) t";

        $g2 =  $this->db->query($query2)->row()->g2;

        $query3 = " 
			SELECT SUM(laba_bersih) AS g3
			FROM(
				SELECT 
				profit_3 * jumlah AS 'laba_bersih'
				FROM detail_penjualan 
				JOIN penjualan USING(faktur_penjualan) 
				JOIN barang USING(id_barang)
				WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai'
				AND type_golongan = 'golongan_3' AND status != 'Hold'
				" . $outlet . "
			) t";

        $g3 =  $this->db->query($query3)->row()->g3;

        $query4 = " 
			SELECT SUM(laba_bersih) AS g4
			FROM(
				SELECT 
				profit_4 * jumlah AS 'laba_bersih'
				FROM detail_penjualan 
				JOIN penjualan USING(faktur_penjualan) 
				JOIN barang USING(id_barang)
				WHERE DATE(tgl) BETWEEN '$dari' AND '$sampai'
				AND type_golongan = 'golongan_4' AND status != 'Hold'
				" . $outlet . "
			) t";

        $g4 =  $this->db->query($query4)->row()->g4;

        return $g1 + $g2 + $g3 + $g4;
    }

    public function get_detail_pengeluaran($dari, $sampai, $id_outlet = '')
    {
        if ($id_outlet == '') {
            $outlet = '';
        } else {
            $outlet = "AND id_outlet = '$id_outlet'";
        }

        $query = " 
			SELECT *
			FROM biaya
			WHERE status = 'PENGELUARAN' AND
			DATE(tgl) BETWEEN '$dari' AND '$sampai' " . $outlet;

        return $this->db->query($query)->result_array();
    }

    public function get_detail_pemasukan($dari, $sampai, $id_outlet = '')
    {
        if ($id_outlet == '') {
            $outlet = '';
        } else {
            $outlet = "AND id_outlet = '$id_outlet'";
        }

        $query = " 
			SELECT *
			FROM biaya
			WHERE status = 'PEMASUKAN' AND
			DATE(tgl) BETWEEN '$dari' AND '$sampai' " . $outlet;

        return $this->db->query($query)->result_array();
    }

    public function get_pengeluaran($dari, $sampai, $id_outlet = '')
    {
        if ($id_outlet == '') {
            $outlet = '';
        } else {
            $outlet = "AND id_outlet = '$id_outlet'";
        }

        $query = " 
			SELECT SUM(total_bayar) AS total_pengeluaran
			FROM biaya
			WHERE status = 'PENGELUARAN' AND
			DATE(tgl) BETWEEN '$dari' AND '$sampai' " . $outlet;

        return $this->db->query($query)->row()->total_pengeluaran;
    }

    public function get_pemasukan($dari, $sampai, $id_outlet = '')
    {
        if ($id_outlet == '') {
            $outlet = '';
        } else {
            $outlet = "AND id_outlet = '$id_outlet'";
        }

        $query = " 
			SELECT SUM(total_bayar) AS total_pengeluaran
			FROM biaya
			WHERE status = 'PEMASUKAN' AND
			DATE(tgl) BETWEEN '$dari' AND '$sampai' " . $outlet;

        return $this->db->query($query)->row()->total_pengeluaran;
    }

    public function get_pembelian_bersih($dari, $sampai, $id_outlet, $id_barang)
    {
        $this->db->select('sum(total_harga) as total_pembelian');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        if ($id_barang != '') {
            $this->db->where('detail_pembelian.id_barang', $id_barang);
        }
        $this->db->join('detail_pembelian', 'faktur_pembelian');
        return $this->db->get('pembelian')->row()->total_pembelian ?? 0;
    }

    public function get_persediaan_awal($dari, $sampai, $id_outlet, $id_barang)
    {
        $this->db->select('sum(jumlah) as terjual');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        if ($id_barang != '') {
            $this->db->where('detail_penjualan.id_barang', $id_barang);
        }
        $this->db->group_by('id_barang');
        $this->db->join('detail_penjualan', 'faktur_penjualan');
        $terjual =  $this->db->get('penjualan')->row()->terjual ?? 0;

        if ($id_barang != '') {
            $this->db->where('id_barang', $id_barang);
            $this->db->select('sum(harga_pokok) as harga_pokok');
        } else {
            $this->db->select('sum(harga_pokok) as harga_pokok');
        }

        $hpp = $this->db->get('barang')->row()->harga_pokok;

        if ($id_barang != '') {
            $this->db->select('sum(stok) as stok');
            $this->db->where('id_barang', $id_barang);
        } else {
            $this->db->select('sum(stok) as stok');
        }
        $stok_saat_ini = $this->db->get('stok_outlet')->row()->stok;

        $data = [
            'terjual' => $terjual,
            'stok_saat_ini' => $stok_saat_ini,
            'hpp' => $hpp,
            'persediaan_awal' => ($stok_saat_ini + $terjual) * $hpp
        ];

        return $data;
    }

    public function get_total_penjualan($dari, $sampai, $id_outlet, $id_barang)
    {
        $this->db->select('sum(total_harga) as total_penjualan');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        if ($id_barang != '') {
            $this->db->where('detail_penjualan.id_barang', $id_barang);
        }
        $this->db->join('detail_penjualan', 'faktur_penjualan');
        return $this->db->get('penjualan')->row()->total_penjualan ?? 0;
    }

    public function get_potongan_penjualan($dari, $sampai, $id_outlet)
    {
        $this->db->select('sum(potongan) as total_potongan');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        // $this->db->join('detail_penjualan', 'faktur_penjualan');
        // if ($id_barang != '') {
        // 	$this->db->where('id_barang', $id_barang);
        // }
        return $this->db->get('penjualan')->row()->total_potongan ?? 0;
    }

    public function get_diskon_penjualan($dari, $sampai, $id_outlet)
    {
        $this->db->select('sum(diskon) as total_diskon');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        // $this->db->join('detail_penjualan', 'faktur_penjualan');
        // if ($id_barang != '') {
        // 	$this->db->where('id_barang', $id_barang);
        // }
        return $this->db->get('penjualan')->row()->total_diskon ?? 0;
    }

    public function get_diskon_rupiah_penjualan($dari, $sampai, $id_outlet)
    {
        $this->db->select('sum(diskon_rupiah) as total_diskon');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        // $this->db->join('detail_penjualan', 'faktur_penjualan');
        // if ($id_barang != '') {
        // 	$this->db->where('id_barang', $id_barang);
        // }
        return $this->db->get('penjualan')->row()->total_diskon ?? 0;
    }

    public function get_penjualan_bersih($dari, $sampai, $id_outlet)
    {
        $this->db->select('sum(total_bayar) as penjualan_bersih');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        // $this->db->join('detail_penjualan', 'faktur_penjualan');
        // if ($id_barang != '') {
        // 	$this->db->where('id_barang', $id_barang);
        // }
        return $this->db->get('penjualan')->row()->penjualan_bersih ?? 0;
    }

    public function get_pembelian_list($dari, $sampai, $id_outlet, $id_barang)
    {
        $this->db->select('*, (total_harga/jumlah) as harga_beli, date(tgl) as tgl');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        $this->db->join('detail_pembelian', 'faktur_pembelian');
        $this->db->join('barang', 'detail_pembelian.id_barang = barang.id_barang', 'left');
        if ($id_barang != '') {
            $this->db->where('detail_pembelian.id_barang', $id_barang);
        }
        return $this->db->get('pembelian')->result_array();
    }

    public function get_penjualan_list($dari, $sampai, $id_outlet, $id_barang)
    {
        $this->db->select('* ,(total_harga/jumlah) as harga_jual, date(tgl) as tgl');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        $this->db->join('detail_penjualan', 'faktur_penjualan');
        $this->db->join('barang', 'detail_penjualan.id_barang = barang.id_barang', 'left');
        if ($id_barang != '') {
            $this->db->where('detail_penjualan.id_barang', $id_barang);
        }
        return $this->db->get('penjualan')->result_array();
    }

    public function get_profit($dari, $sampai, $id_outlet = '', $id_barang)
    {
        $this->db->select('sum(harga_pokok_barang * jumlah) as total_profit');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        if ($id_barang != '') {
            $this->db->where('detail_penjualan.id_barang', $id_barang);
        }
        $this->db->join('penjualan', 'faktur_penjualan');
        $harga_beli = $this->db->get('detail_penjualan')->row()->total_profit;

        $this->db->select('sum( (total_harga/jumlah) * jumlah) as total_harga');
        $this->db->where('DATE(tgl) >=', $dari);
        $this->db->where('DATE(tgl) <=', $sampai);
        if ($id_barang != '') {
            $this->db->where('detail_penjualan.id_barang', $id_barang);
        }
        $this->db->join('penjualan', 'faktur_penjualan');
        $harga_jual = $this->db->get('detail_penjualan')->row()->total_harga;

        return  $harga_jual - $harga_beli;
    }
}

	/* End of file penjualan_model.php */
	/* Location: ./application/modules/penjualan/models/penjualan_model.php */
