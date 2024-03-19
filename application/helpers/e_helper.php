<?php

function cek_login()
{
    $ci = get_instance();
    if (!$ci->session->userdata('login')) {
        redirect('login');
    } else {

        $id_role = $ci->session->userdata('id_role');
        $menu = $ci->db->get_where('menu', ['url' => $ci->uri->segment(1)])->row_array();
        $submenu = $ci->db->get_where('menu', ['url' => $ci->uri->segment(1) . '/' . $ci->uri->segment(2)])->row_array();

        if ($menu) {

            $userAccessMenu = $ci->db->get_where('akses_role', [
                'id_role' => $id_role,
                'id_menu' => $menu['id_menu']
            ])->row_array();

            if ($userAccessMenu) {

                if ($submenu) {
                    $userAccessSubmenu = $ci->db->get_where('akses_role', [
                        'id_role' => $id_role,
                        'id_menu' => $submenu['id_menu']
                    ])->row_array();

                    if (!$userAccessSubmenu) die('401 Unauthorized');
                }
            } else {
                die('401 Unauthorized');
            }
        }
    }
}

function cek_akses_role($id_role, $id_menu, $akses)
{
    $ci = get_instance();

    $ci->db->select($akses);
    $ci->db->where('id_menu', $id_menu);
    $ci->db->where('id_role', $id_role);
    $access = $ci->db->get('akses_role')->row_array()[$akses];

    if (!$access) die('401 Unauthorized');
}

function cek_akses($access)
{
    $ci = get_instance();

    $menu = $ci->uri->segment(1);
    $id_menu = $ci->db->get_where('menu', ['url' => $menu])->row_array()['id_menu'];
    $id_role = $ci->session->userdata('id_role');

    cek_akses_role($id_role, $id_menu, $access);
}


function check_menu($id_menu, $id_role)
{
    $ci = &get_instance();

    $ci->db->where('id_menu', $id_menu);
    $ci->db->where('id_role', $id_role);
    $result = $ci->db->get('akses_role')->row_array();

    if ($result) return "checked='checked'";
}

function check_crud_menu($id_menu, $id_role, $column)
{
    $ci = &get_instance();

    $ci->db->select($column);
    $ci->db->where('id_menu', $id_menu);
    $ci->db->where('id_role', $id_role);
    $result = $ci->db->get('akses_role')->row_array();

    if ($result) {
        if ($result[$column]) {
            return "checked='checked'";
        }
    }
}

function _upload($name, $url, $path)
{
    $ci = &get_instance();
    $config['upload_path'] = './assets/img/' . $path . '/';
    $config['allowed_types'] = 'pdf|jpg|png|jpeg|ico';
    $config['max_size']  = '4048';

    $ci->load->library('upload', $config);

    if (!$ci->upload->do_upload($name)) {
        $ci->session->set_flashdata('error', $ci->upload->display_errors());
        redirect($url, 'refresh');
    }
    return $ci->upload->data('file_name');
}

function delImage($table, $id, $column = 'gambar')
{
    $ci = &get_instance();
    $gambar_lama = $ci->db->get_where($table, ['id_' . $table => $id])->row_array()[$column];
    $path = 'assets/img/' . $table . '/' . $gambar_lama;

    if ($gambar_lama != 'default.png') {
        if (file_exists(FCPATH . $path)) {
            if (!is_dir($path)) {
                unlink(FCPATH . $path);
            }
        }
    }
}

function add_log($table, $id, $aksi, $keterangan = null)
{
    $ci = &get_instance();
    $ci->db->insert('log_aktivitas', [
        'id_user' => $ci->session->userdata('id_user'),
        'tablename' => $table,
        'table_id' => $id,
        'aksi' => $aksi,
        'keterangan' => $keterangan
    ]);
}

function autoID($str, $table)
{
    // PLG00001
    $ci = &get_instance();
    $kode = $ci->db->query("SELECT MAX(id_" . $table . ") as kode from $table")->row()->kode;
    $kode_baru = substr($kode, 3, 5) + 1;
    return $str . sprintf("%05s", $kode_baru);
}

function no_invoice($pembelian = false, $reseller = false)
{
    if ($pembelian == true) {
        $ci = &get_instance();
        $kode = $ci->db->query("SELECT MAX(id_pembelian) as kode from pembelian")->row()->kode;
        return "RP" . sprintf("%07s", $kode + 1);
    } else {
        $ci = &get_instance();
        if ($reseller == true) {
            $penjualan = $ci->db->query("SELECT nomor_invoice as kode from penjualan WHERE sl = 1 ORDER BY id_penjualan DESC")->row();
            if ($penjualan) {
                $kode = $penjualan->kode;
                $kode_baru = substr($kode, 2, 7) + 1;
            }else{
                $kode_baru = 1;
            }
            return "SL" . sprintf("%07s", $kode_baru);
        } else {
            $penjualan = $ci->db->query("SELECT nomor_invoice as kode from penjualan WHERE sl = 0 ORDER BY id_penjualan DESC")->row();
            if ($penjualan) {
                $kode = $penjualan->kode;
                $kode_baru = substr($kode, 2, 7) + 1;
            } else {
                $kode_baru = 1;
            }
            return "RP" . sprintf("%07s", $kode_baru);
        }
    }
}

function acak($length)
{
    $random = "";
    srand((float)microtime() * 1000000);
    $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
    $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
    $data .= "0FGH45OP89";
    for ($i = 0; $i < $length; $i++) {
        $random .= substr($data, (rand() % (strlen($data))), 1);
    }
    return strtoupper($random);
}

function rrmdir($dir)
{
    if (is_dir($dir)) {
        $objects = scandir($dir);
        foreach ($objects as $object) {
            if ($object != "." && $object != "..") {
                if (is_dir($dir . DIRECTORY_SEPARATOR . $object) && !is_link($dir . "/" . $object))
                    rrmdir($dir . DIRECTORY_SEPARATOR . $object);
                else
                    unlink($dir . DIRECTORY_SEPARATOR . $object);
            }
        }
        rmdir($dir);
    }
}
