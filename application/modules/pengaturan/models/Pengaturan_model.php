<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class pengaturan_model extends CI_Model {

	public function get_pengaturan()
	{
		return $this->db->get('pengaturan')->row_array();
	}

	public function update($post)
	{

		$data = [
			'nama_aplikasi' => $post['nama_aplikasi'],
			'smtp_host' => $post['smtp_host'],
			'smtp_port' => $post['smtp_port'],
			'smtp_username' => $post['smtp_username'],
			'smtp_email' => $post['smtp_email'],
			'smtp_password' => $post['smtp_password']
		];

		if ($_FILES['logo']['name']) {
			$data['logo'] = _upload('logo', 'pengaturan', 'pengaturan');
			delImage('pengaturan', 1, 'logo');
		}

		if ($_FILES['favicon']['name']) {
			$data['favicon'] = _upload('favicon', 'pengaturan', 'pengaturan');
			delImage('pengaturan', 1, 'favicon');
		}

		$this->db->update('pengaturan', $data);
	}

}

/* End of file pengaturan_model.php */
/* Location: ./application/modules/pengaturan/models/pengaturan_model.php */
