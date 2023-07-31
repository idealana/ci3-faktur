<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Barang_table extends CI_Migration
{
	public function up()
	{
		$this->db->query("
			CREATE TABLE `m_barang` (
			  `barang_id` int UNSIGNED NOT NULL auto_increment,
			  `barang_kode` char(4) NOT NULL,
			  `barang_nama` varchar(20) NOT NULL,
			  `barang_harga` int NOT NULL,
			  `barang_stok` int(3) DEFAULT 0,
			  `satuan_id` int NOT NULL,
			  `created_at` datetime DEFAULT NULL,
			  `updated_at` datetime DEFAULT NULL,
			  PRIMARY KEY(barang_kode),
			  INDEX autonum (barang_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		");
	}

	public function down()
	{
		$this->db->query("DROP TABLE IF EXISTS m_barang");
	}
}
