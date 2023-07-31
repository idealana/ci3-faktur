<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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

	/**
	 * Dashboard Page
	 */
	public function index()
	{
		$data_counts = array(
			array(
				'label' => 'Barang',
				'total' => $this->db->count_all_results('m_barang'),
				'border_type' => 'border-primary',
			),
			array(
				'label' => 'Supplier',
				'total' => $this->db->count_all_results('m_supplier'),
				'border_type' => 'border-success',
			),
			array(
				'label' => 'Transaksi Pending',
				'total' => $this->db->where('tr_status', 'Pending')->count_all_results('transaksi'),
				'border_type' => 'border-warning',
			),
			array(
				'label' => 'Transaksi Approve',
				'total' => $this->db->where('tr_status', 'Approve')->count_all_results('transaksi'),
				'border_type' => 'border-info',
			),
			array(
				'label' => 'Transaksi Reject',
				'total' => $this->db->where('tr_status', 'Reject')->count_all_results('transaksi'),
				'border_type' => 'border-danger',
			),
		);

		return $this->load->view('templates/backend', array(
			'title'   => 'Dashboard',
			'content' => 'backend/dashboard',
			'data' => array(
    			'data_counts' => $data_counts,
    		),
		));
	}
}
