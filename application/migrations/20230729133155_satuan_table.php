<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Satuan_table extends CI_Migration
{
	public function up()
	{
		$this->db->query("
			CREATE TABLE `m_satuan` (
			  `satuan_id` int UNSIGNED NOT NULL auto_increment,
			  `satuan_nama` varchar(10) NOT NULL,
			  `created_at` datetime DEFAULT NULL,
			  `updated_at` datetime DEFAULT NULL,
			  PRIMARY KEY(satuan_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		");
	}

	public function down()
	{
		$this->db->query("DROP TABLE IF EXISTS m_satuan");
	}
}
