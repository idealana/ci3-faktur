<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan extends CI_Controller {

	/**
	 * @var string
	 */
	private $_base_route;

	public function __construct()
	{
		parent::__construct();

		// Login Check
		Auth::authorization_check();

		$this->_base_route = $this->router->directory . $this->router->class;
	}

	public function index()
	{
		$base_route = base_url($this->_base_route);
		$title = 'Master Satuan';
		$data_satuan = $this->MainModel->getDataWhere('m_satuan');

		return $this->load->view('templates/backend', array(
			'title'   => $title,
			'content' => 'backend/satuan',
			'data' => array(
				'satuan' => $data_satuan,
			),
			'breadcrumbs' => array(
  			array('title' => 'Dashboard', 'link' => site_url('dashboard')),
  			array('title' => $title, 'link' => '#'),
  		),
  		'assets' => array(
  			'css' => array(
	  			'plugins/datatables-bs4/css/dataTables.bootstrap4.min.css',
  			),
  			'js' => array(
	  			'plugins/datatables/jquery.dataTables.min.js',
	  			'plugins/datatables-bs4/js/dataTables.bootstrap4.min.js',
  			),
  		),
		));
	}

	public function store()
	{
		try {
			$satuan_nama = $this->input->post('satuan_nama', true);
			$now = date('Y-m-d H:i:s');

			$this->MainModel->store('m_satuan', array(
				'satuan_nama' => $satuan_nama,
				'created_at' => $now,
				'updated_at' => $now,
			));

			echo json_encode(array(
				'message' => 'Data berhasil disimpan',
				'title' => 'Sukses',
			));

		} catch(\Exception $error) {
			Helper::error_handler($error);
		}
	}

	public function update($id = null)
	{
		try {
			$satuan_nama = $this->input->post('satuan_nama', true);
			$now = date('Y-m-d H:i:s');

			$where = array('satuan_id' => $id);

			$this->MainModel->update('m_satuan', array(
				'satuan_nama' => $satuan_nama,
				'updated_at' => $now,
			), $where);

			echo json_encode(array(
				'message' => 'Data berhasil disimpan',
				'title' => 'Sukses',
			));

		} catch(\Exception $error) {
			Helper::error_handler($error);
		}
	}

	public function delete($id = null)
	{
		try {
			$where = array('satuan_id' => $id);

			$this->MainModel
				->query_satuan_delete()
				->delete_wheres('m_satuan', $where);

			if($this->db->affected_rows() < 1){
				Helper::send_404_response('Data tidak dapat dihapus. Pastikan data tidak digunakan di Master Barang');
			}

			echo json_encode(array(
				'message' => 'Data berhasil dihapus',
				'title' => 'Sukses',
			));

		} catch(\Exception $error) {
			Helper::error_handler($error);
		}
	}
}
