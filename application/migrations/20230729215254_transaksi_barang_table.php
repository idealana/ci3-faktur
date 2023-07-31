<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Transaksi_barang_table extends CI_Migration
{
	public function up()
	{
		$this->db->query("
			CREATE TABLE `transaksi_barang` (
			  `trb_id` int UNSIGNED NOT NULL auto_increment,
			  `tr_kode` char(6) NOT NULL,
			  `barang_kode` char(4) NOT NULL,
			  `jumlah` int(3) NOT NULL,
			  `harga` int NOT NULL,
			  `total_harga` int NOT NULL,
			  `created_at` datetime DEFAULT NULL,
			  `updated_at` datetime DEFAULT NULL,
			  PRIMARY KEY(trb_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		");
	}

	public function down()
	{
		$this->db->query("DROP TABLE IF EXISTS transaksi_barang");
	}
}
