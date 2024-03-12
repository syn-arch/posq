<?php
defined('BASEPATH') or exit('No direct script access allowed');

class user_model extends CI_Model
{

    public function get_user_json()
    {
        $this->datatables->select('id_user, nama_user, jk, alamat, telepon, email, user.gambar, nama_role, nama_marketplace');
        $this->datatables->from('user');
        $this->datatables->join('role', 'id_role', 'left');
        $this->datatables->join('marketplace', 'id_marketplace', 'left');
        return $this->datatables->generate();
    }

    function get_all()
    {
        return $this->db->get('user')->result();
    }

    public function get_user($id = '')
    {
        if ($id == '') {
            $this->db->join('role', 'id_role', 'left');
            return $this->db->get('user')->result_array();
        } else {
            $this->db->join('role', 'id_role', 'left');
            $this->db->where('id_user', $id);
            return $this->db->get('user')->row_array();
        }
    }

    public function delete($id)
    {
        delImage('user', $id);
        $this->db->delete('user', ['id_user' => $id]);
    }

    public function insert($post)
    {
        $data = [
            'id_user' => htmlspecialchars($post['id_user']),
            'id_marketplace' => htmlspecialchars($post['id_marketplace']),
            'nama_user' => htmlspecialchars($post['nama_user']),
            'jk' => htmlspecialchars($post['jk']),
            'alamat' => htmlspecialchars($post['alamat']),
            'telepon' => htmlspecialchars($post['telepon']),
            'email' => htmlspecialchars($post['email']),
            'password' => password_hash(htmlspecialchars($post['pw1']), PASSWORD_DEFAULT),
            'id_role' => htmlspecialchars($post['id_role'])
        ];

        if ($_FILES['gambar']['name']) {
            $data['gambar'] = _upload('gambar', 'user/tambah', 'user');
        }

        $this->db->insert('user', $data);
    }

    public function update($id, $post)
    {
        $data = [
            'nama_user' => htmlspecialchars($post['nama_user']),
            'jk' => htmlspecialchars($post['jk']),
            'alamat' => htmlspecialchars($post['alamat']),
            'email' => htmlspecialchars($post['email']),
            'telepon' => htmlspecialchars($post['telepon']),
            'id_role' => htmlspecialchars($post['id_role']),
            'id_marketplace' => htmlspecialchars($post['id_marketplace']),
        ];

        if ($_FILES['gambar']['name']) {
            $data['gambar'] = _upload('gambar', 'user/ubah/' . $id, 'user');
            delImage('user', $id);
        }

        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
    }
}

/* End of file user_model.php */
/* Location: ./application/modules/user/models/user_model.php */
