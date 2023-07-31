<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

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
		$title = 'Master Supplier';
		$data_supplier = $this->MainModel->getDataWhere('m_supplier');

		return $this->load->view('templates/backend', array(
			'title'   => $title,
			'content' => 'backend/supplier',
			'data' => array(
				'supplier' => $data_supplier,
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

			$this->MainModel->store('m_supplier', array(
				'supplier_kode' => $this->MainModel->generateSupplierCode(),
				'supplier_nama' => $this->input->post('supplier_nama', true),
				'supplier_alamat' => $this->input->post('supplier_alamat', true),
				'supplier_up' => $this->input->post('supplier_up', true),
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

	public function update($kode = null)
	{
		try {
			$now = date('Y-m-d H:i:s');
			$where = array('supplier_kode' => $kode);

			$this->MainModel->update('m_supplier', array(
				'supplier_nama' => $this->input->post('supplier_nama', true),
				'supplier_alamat' => $this->input->post('supplier_alamat', true),
				'supplier_up' => $this->input->post('supplier_up', true),
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

	public function delete($kode = null)
	{
		try {
			$where = array('supplier_kode' => $kode);

			$this->MainModel
				->query_supplier_delete()
				->delete_wheres('m_supplier', $where);

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
