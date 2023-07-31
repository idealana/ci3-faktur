<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_User_table extends CI_Migration
{
	public function up()
	{
		$this->db->query("
			CREATE TABLE `users` (
			  `user_id` int UNSIGNED NOT NULL auto_increment,
			  `full_name` varchar(50) NOT NULL,
			  `username` varchar(25) NOT NULL,
			  `password` varchar(255) NOT NULL,
			  `role` varchar(20) DEFAULT NULL,
			  `created_at` datetime DEFAULT NULL,
			  `updated_at` datetime DEFAULT NULL,
			  PRIMARY KEY(user_id)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8
		");
	}

	public function down()
	{
		$this->db->query("DROP TABLE IF EXISTS users");
	}
}
