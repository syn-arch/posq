<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Laporan_model extends CI_Model
{
    function get_laporan_penjualan($dari, $sampai)
    {
        $this->db->select('*, SUM(qty) AS terjual');
        $this->db->group_by('id_produk');
        return $this->db->get('detail_penjualan')->result_array();
    }
}
