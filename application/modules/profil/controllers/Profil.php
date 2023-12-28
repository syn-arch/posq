<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class profil extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		cek_login();
		$this->load->model('profil/profil_model');
		$this->load->model('user/user_model');
	}

	public function index()
	{
		$data['judul'] = "Profil Saya";
		$data['profil'] = $this->db->get_where('user', ['id_user' => $this->session->userdata('id_user')])->row_array();

		$this->load->view('templates/header', $data, FALSE);
		$this->load->view('profil/index', $data, FALSE);
		$this->load->view('templates/footer', $data, FALSE);
	}

	public function ubah_profil_action()
	{
		$valid = $this->form_validation;

		$valid->set_rules('nama_user', 'nama user', 'required');
		$valid->set_rules('jk', 'jenis kelamin', 'required');
		$valid->set_rules('id_user', 'ID user', 'required');
		$valid->set_rules('alamat', 'alamat', 'required');
		$valid->set_rules('telepon', 'telepon', 'required');
		$valid->set_rules('email', 'email', 'required');

		if ($valid->run()) {
			$this->profil_model->ubah_profil($this->input->post());
			$this->session->set_flashdata('success', 'diubah');
			redirect('profil','refresh');
		}else{
			$this->index();
		}
	}

	public function ubah_gambar_action()
	{
		delImage('user', $this->session->userdata('id_user'));
		$this->db->set('gambar', _upload('gambar', 'profil', 'user'));
		$this->db->where('id_user', $this->session->userdata('id_user'));
		$this->db->update('user');

		$this->session->set_flashdata('success', 'diubah');
		redirect('profil','refresh');
	}

	public function ubah_password_action()
	{
		$valid = $this->form_validation;

		$valid->set_rules('pw_sekarang', 'password sekarang', 'required');
		$valid->set_rules('pw1', 'password baru', 'required|matches[pw2]');
		$valid->set_rules('pw2', 'konfirmasi password baru', 'required|matches[pw1]');

		if ($valid->run()) {

			$post = $this->input->post();

			$hash = $this->user_model->get_user($this->session->userdata('id_user'))['password'];

			if (password_verify($post['pw_sekarang'], $hash)) {

				$this->db->set('password', password_hash($post['pw1'], PASSWORD_DEFAULT));
				$this->db->where('id_user', $this->session->userdata('id_user'));
				$this->db->update('user');
				
				$this->session->set_flashdata('success', 'diubah');
				redirect('profil','refresh');
			}else{
				$this->session->set_flashdata('error', 'Password sekarang salah');
				redirect('profil','refresh');
			}
			
		}else{
			$this->index();
		}
	}

}

/* End of file profil.php */
/* Location: ./application/modules/profil/controllers/profil.php */ ?>
