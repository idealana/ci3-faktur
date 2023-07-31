<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Transaksi_table extends CI_Migration
{
	public function up()
	{
		$this->db->query("
			CREATE TABLE `transaksi` (
			  `tr_id` int UNSIGNED NOT NULL auto_increment,
			  `tr_kode` char(6) NOT NULL,
			  `tr_no_faktur` varchar(30) NOT NULL,
			  `tr_tanggal` date NOT NULL,
			  `tr_status` enum('Pending', 'Approve', 'Reject') DEFAULT 'Pending',
			  `supplier_kode` char(5) NOT NULL,
			  `created_at` datetime DEFAULT NULL,
			  `updated_at` datetime DEFAULT NULL,
			  PRIMARY KEY(tr_kode),
			  INDEX autonum (tr_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		");
	}

	public function down()
	{
		$this->db->query("DROP TABLE IF EXISTS transaksi");
	}
}
