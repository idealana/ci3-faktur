<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Barang extends CI_Controller {

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
		$title = 'Master Barang';
		$data_barang = $this->MainModel->getDataBarang();
		$data_satuan = $this->MainModel->getDataWhere('m_satuan');

		return $this->load->view('templates/backend', array(
			'title'   => $title,
			'content' => 'backend/barang',
			'data' => array(
				'barang' => $data_barang,
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
			$now = date('Y-m-d H:i:s');

			$this->MainModel->store('m_barang', array(
				'barang_kode' => $this->MainModel->generateCodeItem(),
				'barang_nama' => $this->input->post('barang_nama', true),
				'satuan_id' => $this->input->post('satuan_id', true),
				'barang_harga' => $this->input->post('barang_harga', true),
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

	public function update($barang_kode = null)
	{
		try {
			$now = date('Y-m-d H:i:s');
			$where = array('barang_kode' => $barang_kode);

			$this->MainModel->update('m_barang', array(
				'barang_nama' => $this->input->post('barang_nama', true),
				'satuan_id' => $this->input->post('satuan_id', true),
				'barang_harga' => $this->input->post('barang_harga', true),
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

	public function delete($barang_kode = null)
	{
		try {
			$where = array('barang_kode' => $barang_kode);

			$this->MainModel
				->query_barang_delete()
				->delete_wheres('m_barang', $where);

			if($this->db->affected_rows() < 1){
				Helper::send_404_response('Data tidak dapat dihapus. Pastikan data tidak digunakan di Transaksi');
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
