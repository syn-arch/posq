<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil_model extends CI_Model {

	public function ubah_profil($post)
	{
		$data = [
			'nama_user' => $post['nama_user'],
			'jk' => $post['jk'],
			'alamat' => $post['alamat'],
			'telepon' => $post['telepon'],
			'email' => $post['email'],
			'telepon' => $post['telepon']
		];

		$this->db->where('id_user', $this->session->userdata('id_user'));
		$this->db->update('user', $data);
	}
}

/* End of file user_model.php */
/* Location: ./application/modules/user/models/user_model.php */ ?>
