<?php
defined('BASEPATH') or exit('No direct script access allowed');

class laporan_model extends CI_Model
{

    public function get_total_keuangan()
    {
        $this->db->select_sum('sub_total', 'total');
        $this->db->where('piutang', 0);
        $this->db->where('DATE(penjualan.tanggal)', date('Y-m-d'));
        $this->db->join('penjualan', 'id_penjualan');
        $penjualan = $this->db->get('pembayaran')->row_array()['total'];

        $this->db->select_sum('nominal', 'total');
        $this->db->where('DATE(penjualan.tanggal)', date('Y-m-d'));
        $this->db->where('piutang', 1);
        $this->db->join('penjualan', 'id_penjualan');
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
			SUM(total_harga) AS sub_total
			FROM penjualan 
			JOIN detail_penjualan USING(id_penjualan)
			WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai'
			AND type_golongan = '$golongan' AND status != 'Hold' " . $id_outlet;
        } else {
            $query = "SELECT 
			SUM(total_harga) AS sub_total
			FROM penjualan 
			JOIN detail_penjualan USING(id_penjualan)
			WHERE type_golongan = '$golongan' AND status != 'Hold' ";
        }

        return  $this->db->query($query)->row()->sub_total;
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
				{$profit} * qty AS 'laba_bersih'
				FROM detail_penjualan 
				JOIN penjualan USING(id_penjualan) 
				JOIN produk USING(id_produk)
				WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai'
				AND type_golongan = '$golongan' AND status != 'Hold'
				" . $id_outlet . "
				) t
				";
        } else {

            $query = " SELECT SUM(laba_bersih) AS total_laba_bersih
				FROM(
					SELECT 
					{$profit} * qty AS 'laba_bersih'
					FROM detail_penjualan 
					JOIN penjualan USING(id_penjualan) 
					JOIN produk USING(id_produk)
					WHERE type_golongan = '$golongan' AND status != 'Hold'
					) t
				";
        }

        return $this->db->query($query)->row_array()['total_laba_bersih'];
    }


    public function get_paling_banyak_dijual($dari = '', $sampai = '', $id_outlet = '')
    {

        $this->db->select('produk.id_produk, produk.nama_produk, SUM(detail_penjualan.qty) AS kuantitas');
        $this->db->join('detail_penjualan', 'id_penjualan');
        $this->db->join('produk', 'produk.id_produk = detail_penjualan.id_produk');
        $this->db->order_by('kuantitas', 'DESC');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tanggal) >=', $dari);
            $this->db->where('DATE(penjualan.tanggal) <=', $sampai);
        }
        $this->db->group_by('id_produk');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_paling_sering_dijual($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select('produk.id_produk, produk.nama_produk, COUNT(detail_penjualan.id_produk) AS kali');
        $this->db->join('detail_penjualan', 'id_penjualan');
        $this->db->join('produk', 'produk.id_produk = detail_penjualan.id_produk');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tanggal) >=', $dari);
            $this->db->where('DATE(penjualan.tanggal) <=', $sampai);
        }
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        $this->db->order_by('kali', 'DESC');
        $this->db->group_by('id_produk');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_kasir($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select_sum('sub_total', 'pendapatan');
        $this->db->select('id_user, nama_user, COUNT(id_penjualan) AS transaksi');
        $this->db->join('user', 'id_user');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tanggal) >=', $dari);
            $this->db->where('DATE(penjualan.tanggal) <=', $sampai);
        }
        $this->db->group_by('id_user');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_karyawan($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select_sum('sub_total', 'pendapatan');
        $this->db->select('id_karyawan, nama_karyawan, COUNT(id_penjualan) AS transaksi');
        $this->db->join('karyawan', 'id_karyawan');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tanggal) >=', $dari);
            $this->db->where('DATE(penjualan.tanggal) <=', $sampai);
        }
        $this->db->group_by('id_karyawan');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_kategori($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select('produk.id_kategori, nama_kategori, COUNT(id_penjualan) AS penjualan');
        $this->db->select_sum('total_harga', 'pendapatan');
        $this->db->join('detail_penjualan', 'id_penjualan');
        $this->db->join('produk', 'id_produk');
        $this->db->join('kategori', 'produk.id_kategori=kategori.id_kategori');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tanggal) >=', $dari);
            $this->db->where('DATE(penjualan.tanggal) <=', $sampai);
        }
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        $this->db->group_by('id_kategori');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_pelanggan($dari = '', $sampai = '')
    {
        $this->db->select('id_pelanggan, nama_pelanggan, COUNT(id_penjualan) AS penjualan');
        $this->db->select_sum('sub_total', 'pendapatan');
        $this->db->join('pelanggan', 'id_pelanggan');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tanggal) >=', $dari);
            $this->db->where('DATE(penjualan.tanggal) <=', $sampai);
        }
        $this->db->group_by('id_pelanggan');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_jenis_pelanggan($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select('jenis, COUNT(id_penjualan) AS penjualan');
        $this->db->select_sum('sub_total', 'pendapatan');
        $this->db->join('pelanggan', 'id_pelanggan');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tanggal) >=', $dari);
            $this->db->where('DATE(penjualan.tanggal) <=', $sampai);
        }
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        $this->db->group_by('jenis');
        return $this->db->get('penjualan')->result_array();
    }

    public function get_per_supplier($dari = '', $sampai = '', $id_outlet = '')
    {
        $this->db->select('produk.id_supplier, nama_supplier, COUNT(id_penjualan) AS penjualan');
        $this->db->select_sum('total_harga', 'pendapatan');
        $this->db->join('detail_penjualan', 'id_penjualan');
        $this->db->join('produk', 'id_produk');
        $this->db->join('supplier', 'produk.id_supplier=supplier.id_supplier');
        if ($dari != '') {
            $this->db->where('DATE(penjualan.tanggal) >=', $dari);
            $this->db->where('DATE(penjualan.tanggal) <=', $sampai);
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
				DATE(tanggal) AS tgl_penjualan,
				SUM(sub_total) AS net_sales,
				SUM(diskon) AS ttl_charge,
				(SUM(diskon) / 100 ) * SUM(sub_total) AS harga_diskon,
				SUM(sub_total) - (SUM(diskon) / 100 ) * SUM(sub_total) AS ttl_sales,
				COUNT(id_penjualan) AS ttl_customer
				FROM penjualan a
				WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai' " . $id_outlet . "
				GROUP BY DATE(tanggal)
				";
        } else {
            $query = "
				SELECT 
				DATE(tanggal) AS tgl_penjualan,
				SUM(sub_total) AS net_sales,
				SUM(diskon) AS ttl_charge,
				(SUM(diskon) / 100 ) * SUM(sub_total) AS harga_diskon,
				SUM(sub_total) - (SUM(diskon) / 100 ) * SUM(sub_total) AS ttl_sales,
				COUNT(id_penjualan) AS ttl_customer
				FROM penjualan a
				GROUP BY DATE(tanggal)
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
				SUM(qty) AS ttl_qty,
				COUNT(qty) AS ttl_beli
				FROM penjualan
				JOIN detail_penjualan USING(id_penjualan)
				WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai' " . $id_outlet . "
				GROUP BY DATE(tanggal)
				";
        } else {
            $query = "
				SELECT 
				SUM(qty) AS ttl_qty,
				COUNT(qty) AS ttl_beli
				FROM penjualan
				JOIN detail_penjualan USING(id_penjualan)
				GROUP BY DATE(tanggal)
				";
        }

        return $this->db->query($query)->result_array();
    }

    public function get_all_pembelian($dari = '', $sampai = '')
    {
        $this->db->where('DATE(pembelian.tanggal) >=', $dari);
        $this->db->where('DATE(pembelian.tanggal) <=', $sampai);
        $this->db->join('detail_pembelian', 'id_pembelian');
        return $this->db->get('pembelian')->result_array();
    }

    public function get_total_pembelian($dari = '', $sampai = '')
    {
        $this->db->select_sum('sub_total', 'total');
        if ($dari != '') {
            $this->db->where('DATE(pembelian.tgl) >=', $dari);
            $this->db->where('DATE(pembelian.tgl) <=', $sampai);
        }
        return $this->db->get('pembelian')->row_array()['total'];
    }

    public function get_all_hutang()
    {
        $query = " 
			SELECT *,nama_supplier, sub_total AS qty_hutang,
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
			SELECT SUM(sub_total) AS qty_hutang
			FROM pembelian
			WHERE status = 'Belum Lunas'
			";

        return $this->db->query($query)->row()->qty_hutang;
    }

    public function get_sisa_hutang()
    {
        $query = " 
			SELECT *,nama_supplier, SUM(sub_total) AS qty_hutang,
			SUM(nominal) AS telah_dibayar,
			(SUM(sub_total) - SUM(nominal)) AS sisa_hutang
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
			SELECT *,nama_supplier, SUM(sub_total) AS qty_hutang,
			SUM(nominal) AS telah_dibayar,
			(SUM(sub_total) - SUM(nominal)) AS sisa_hutang
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
			SELECT *,nama_pelanggan, sub_total AS qty_piutang,penjualan.tanggal,
			SUM(nominal) AS telah_dibayar
			FROM penjualan
			JOIN pelanggan USING(id_pelanggan)
			LEFT JOIN pembayaran USING(id_penjualan)
			WHERE status = 'Belum Lunas'
			GROUP BY id_penjualan
			ORDER BY DATE(penjualan.tanggal) DESC
			";

        return $this->db->query($query)->result_array();
    }

    public function get_total_piutang()
    {
        $query = " 
			SELECT SUM(sub_total) AS qty_piutang
			FROM penjualan
			WHERE status = 'Belum Lunas'
			";

        return $this->db->query($query)->row()->qty_piutang;
    }

    public function get_sisa_piutang()
    {
        $query = " 
			SELECT *, SUM(sub_total) AS qty_piutang,
			SUM(nominal) AS telah_dibayar,
			(SUM(sub_total) - SUM(nominal)) AS sisa_piutang
			FROM penjualan
			JOIN pelanggan USING(id_pelanggan)
			JOIN pembayaran USING(id_penjualan)
			WHERE status = 'Belum Lunas'
			";

        return $this->db->query($query)->row()->sisa_piutang;
    }

    public function get_telah_dibayar_piutang()
    {
        $query = " 
			SELECT *, SUM(sub_total) AS qty_piutang,
			SUM(nominal) AS telah_dibayar,
			(SUM(sub_total) - SUM(nominal)) AS sisa_piutang
			FROM penjualan
			JOIN pelanggan USING(id_pelanggan)
			JOIN pembayaran USING(id_penjualan)
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
			SELECT SUM(sub_total) AS total_pendapatan
			FROM penjualan
			WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai' AND status != 'Hold' " . $outlet;

        return $this->db->query($query)->row()->total_pendapatan;
    }

    public function get_laba_rugi($dari, $sampai)
    {
        $query = "SELECT DATE(tanggal) AS tanggal, SUM(sub_total) AS total FROM penjualan WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai' AND status != 'Hold' GROUP BY DATE(tanggal) ";
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
			JOIN penjualan USING(id_penjualan)
			WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai' AND status != 'Hold' " . $outlet;

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
				profit_1 * qty AS 'laba_bersih'
				FROM detail_penjualan 
				JOIN penjualan USING(id_penjualan) 
				JOIN produk USING(id_produk)
				WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai'
				AND type_golongan = 'golongan_1' AND status != 'Hold'
				" . $outlet . "
			) t";

        $g1 =  $this->db->query($query1)->row()->g1;

        $query2 = " 
			SELECT SUM(laba_bersih) AS g2
			FROM(
				SELECT 
				profit_2 * qty AS 'laba_bersih'
				FROM detail_penjualan 
				JOIN penjualan USING(id_penjualan) 
				JOIN produk USING(id_produk)
				WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai'
				AND type_golongan = 'golongan_2' AND status != 'Hold'
				" . $outlet . "
			) t";

        $g2 =  $this->db->query($query2)->row()->g2;

        $query3 = " 
			SELECT SUM(laba_bersih) AS g3
			FROM(
				SELECT 
				profit_3 * qty AS 'laba_bersih'
				FROM detail_penjualan 
				JOIN penjualan USING(id_penjualan) 
				JOIN produk USING(id_produk)
				WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai'
				AND type_golongan = 'golongan_3' AND status != 'Hold'
				" . $outlet . "
			) t";

        $g3 =  $this->db->query($query3)->row()->g3;

        $query4 = " 
			SELECT SUM(laba_bersih) AS g4
			FROM(
				SELECT 
				profit_4 * qty AS 'laba_bersih'
				FROM detail_penjualan 
				JOIN penjualan USING(id_penjualan) 
				JOIN produk USING(id_produk)
				WHERE DATE(tanggal) BETWEEN '$dari' AND '$sampai'
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
			DATE(tanggal) BETWEEN '$dari' AND '$sampai' " . $outlet;

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
			DATE(tanggal) BETWEEN '$dari' AND '$sampai' " . $outlet;

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
			SELECT SUM(sub_total) AS total_pengeluaran
			FROM biaya
			WHERE status = 'PENGELUARAN' AND
			DATE(tanggal) BETWEEN '$dari' AND '$sampai' " . $outlet;

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
			SELECT SUM(sub_total) AS total_pengeluaran
			FROM biaya
			WHERE status = 'PEMASUKAN' AND
			DATE(tanggal) BETWEEN '$dari' AND '$sampai' " . $outlet;

        return $this->db->query($query)->row()->total_pengeluaran;
    }

    public function get_pembelian_bersih($dari, $sampai, $id_outlet, $id_produk)
    {
        $this->db->select('sum(total_harga) as total_pembelian');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        if ($id_produk != '') {
            $this->db->where('detail_pembelian.id_produk', $id_produk);
        }
        $this->db->join('detail_pembelian', 'faktur_pembelian');
        return $this->db->get('pembelian')->row()->total_pembelian ?? 0;
    }

    public function get_persediaan_awal($dari, $sampai, $id_outlet, $id_produk)
    {
        $this->db->select('sum(qty) as terjual');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        if ($id_produk != '') {
            $this->db->where('detail_penjualan.id_produk', $id_produk);
        }
        $this->db->group_by('id_produk');
        $this->db->join('detail_penjualan', 'id_penjualan');
        $terjual =  $this->db->get('penjualan')->row()->terjual ?? 0;

        if ($id_produk != '') {
            $this->db->where('id_produk', $id_produk);
            $this->db->select('sum(harga_pokok) as harga_pokok');
        } else {
            $this->db->select('sum(harga_pokok) as harga_pokok');
        }

        $hpp = $this->db->get('produk')->row()->harga_pokok;

        if ($id_produk != '') {
            $this->db->select('sum(stok) as stok');
            $this->db->where('id_produk', $id_produk);
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

    public function get_total_penjualan($dari, $sampai, $id_outlet, $id_produk)
    {
        $this->db->select('sum(total_harga) as total_penjualan');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        if ($id_produk != '') {
            $this->db->where('detail_penjualan.id_produk', $id_produk);
        }
        $this->db->join('detail_penjualan', 'id_penjualan');
        return $this->db->get('penjualan')->row()->total_penjualan ?? 0;
    }

    public function get_potongan_penjualan($dari, $sampai, $id_outlet)
    {
        $this->db->select('sum(potongan) as total_potongan');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        // $this->db->join('detail_penjualan', 'id_penjualan');
        // if ($id_produk != '') {
        // 	$this->db->where('id_produk', $id_produk);
        // }
        return $this->db->get('penjualan')->row()->total_potongan ?? 0;
    }

    public function get_diskon_penjualan($dari, $sampai, $id_outlet)
    {
        $this->db->select('sum(diskon) as total_diskon');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        // $this->db->join('detail_penjualan', 'id_penjualan');
        // if ($id_produk != '') {
        // 	$this->db->where('id_produk', $id_produk);
        // }
        return $this->db->get('penjualan')->row()->total_diskon ?? 0;
    }

    public function get_diskon_rupiah_penjualan($dari, $sampai, $id_outlet)
    {
        $this->db->select('sum(diskon_rupiah) as total_diskon');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        // $this->db->join('detail_penjualan', 'id_penjualan');
        // if ($id_produk != '') {
        // 	$this->db->where('id_produk', $id_produk);
        // }
        return $this->db->get('penjualan')->row()->total_diskon ?? 0;
    }

    public function get_penjualan_bersih($dari, $sampai, $id_outlet)
    {
        $this->db->select('sum(sub_total) as penjualan_bersih');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        if ($id_outlet != '') {
            $this->db->where('id_outlet', $id_outlet);
        }
        // $this->db->join('detail_penjualan', 'id_penjualan');
        // if ($id_produk != '') {
        // 	$this->db->where('id_produk', $id_produk);
        // }
        return $this->db->get('penjualan')->row()->penjualan_bersih ?? 0;
    }

    public function get_pembelian_list($dari, $sampai, $id_outlet, $id_produk)
    {
        $this->db->select('*, (total_harga/qty) as harga_beli, date(tanggal) as tgl');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        $this->db->join('detail_pembelian', 'faktur_pembelian');
        $this->db->join('produk', 'detail_pembelian.id_produk = produk.id_produk', 'left');
        if ($id_produk != '') {
            $this->db->where('detail_pembelian.id_produk', $id_produk);
        }
        return $this->db->get('pembelian')->result_array();
    }

    public function get_penjualan_list($dari, $sampai, $id_outlet, $id_produk)
    {
        $this->db->select('* ,(total_harga/qty) as harga_jual, date(tanggal) as tgl');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        $this->db->join('detail_penjualan', 'id_penjualan');
        $this->db->join('produk', 'detail_penjualan.id_produk = produk.id_produk', 'left');
        if ($id_produk != '') {
            $this->db->where('detail_penjualan.id_produk', $id_produk);
        }
        return $this->db->get('penjualan')->result_array();
    }

    public function get_profit($dari, $sampai, $id_outlet = '', $id_produk)
    {
        $this->db->select('sum(harga_pokok_produk * qty) as total_profit');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        if ($id_produk != '') {
            $this->db->where('detail_penjualan.id_produk', $id_produk);
        }
        $this->db->join('penjualan', 'id_penjualan');
        $harga_beli = $this->db->get('detail_penjualan')->row()->total_profit;

        $this->db->select('sum( (total_harga/qty) * qty) as total_harga');
        $this->db->where('DATE(tanggal) >=', $dari);
        $this->db->where('DATE(tanggal) <=', $sampai);
        if ($id_produk != '') {
            $this->db->where('detail_penjualan.id_produk', $id_produk);
        }
        $this->db->join('penjualan', 'id_penjualan');
        $harga_jual = $this->db->get('detail_penjualan')->row()->total_harga;

        return  $harga_jual - $harga_beli;
    }
}

	/* End of file penjualan_model.php */
	/* Location: ./application/modules/penjualan/models/penjualan_model.php */
