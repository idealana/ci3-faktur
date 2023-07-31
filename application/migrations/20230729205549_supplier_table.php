<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Supplier_table extends CI_Migration
{
	public function up()
	{
		$this->db->query("
			CREATE TABLE `m_supplier` (
			  `supplier_id` int UNSIGNED NOT NULL auto_increment,
			  `supplier_kode` char(5) NOT NULL,
			  `supplier_nama` varchar(30) NOT NULL,
			  `supplier_alamat` varchar(255) NOT NULL,
			  `supplier_up` varchar(30) NOT NULL,
			  `created_at` datetime DEFAULT NULL,
			  `updated_at` datetime DEFAULT NULL,
			  PRIMARY KEY(supplier_kode),
			  INDEX autonum (supplier_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		");
	}

	public function down()
	{
		$this->db->query("DROP TABLE IF EXISTS m_supplier");
	}
}
