<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class menu_model extends CI_Model {

	public function getMainMenu()
	{
		return $this->db->get_where('menu', ['submenu' => 0])->result_array();
	}

	public function getMenu($id)
	{
		return $this->db->get_where('menu', ['id_menu' => $id])->row_array();
	}

	public function delete($id_menu)
	{
		$this->db->delete('menu', ['id_menu' => $id_menu]);
		$this->db->delete('akses_role', ['id_menu' => $id_menu]);
	}

	public function insert($post)
	{

		if ($post['ada_submenu'] == '1') {
			$menu_utama = $this->db->get_where('menu', ['submenu' => 0])->num_rows();	
			$urutan = $menu_utama + 1;
		}else{
			$submenu = $this->db->get_where('menu', ['submenu' => $post['submenu']])->num_rows();
			$urutan = $submenu + 1;
		}

		$data = [
			'nama_menu' => ucwords($post['nama_menu']),
			'icon' => $post['icon'],
			'ada_submenu' => $post['ada_submenu'],
			'submenu' => $post['submenu'],
			'url' => $post['url'],
			'crudable' => $post['crudable'],
			'urutan' => $urutan
		];

		$this->db->insert('menu', $data);
	}

	public function update($post)
	{
		$data = [
			'nama_menu' => $post['nama_menu'],
			'icon' => $post['icon'],
			'ada_submenu' => $post['ada_submenu'],
			'submenu' => $post['submenu'],
			'crudable' => $post['crudable'],
			'url' => $post['url'],
		];

		$this->db->where('id_menu', $post['id_menu']);
		$this->db->update('menu', $data);
	}

	public function orderMenu($post)
	{
		for ($i=0; $i < count($post['menu']); $i++) { 
			$j = $i;

			$id_menu = $post['menu'][$i]['id'];

			if (isset($post['menu'][$i]['children'])) {

				$children = $post['menu'][$i]['children'];

				for ($k=0; $k < count($children); $k++) { 

					$id_sub_menu = $post['menu'][$i]['children'][$k]['id'];

					$l = $k;

					$this->db->set('urutan', $l += 1);
					$this->db->set('ada_submenu', 0);
					$this->db->set('submenu', $id_menu);
					$this->db->where('id_menu', $id_sub_menu);
					$this->db->update('menu');
				}

				$ada_submenu = 1;

			}else{

				$ada_submenu = 0;

			}

			$this->db->set('urutan', $j += 1);
			$this->db->set('ada_submenu', $ada_submenu);
			$this->db->set('submenu', 0);
			$this->db->where('id_menu', $id_menu);
			$this->db->update('menu');

		}
	}



}

/* End of file menu_model.php */
/* Location: ./application/modules/menu/models/menu_model.php */
