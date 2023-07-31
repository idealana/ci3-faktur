<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_User_seeder extends CI_Migration
{
	public function up()
	{
		$password = password_hash("passWORD", PASSWORD_DEFAULT);
		$now = date('Y-m-d H:i:s');

		$this->db->query("INSERT INTO `users` (`user_id`, `full_name`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES (1, 'Super Admin', 'superadmin', '$password', 'super_admin', '$now', '$now')");
	}

	public function down()
	{
		$this->db->query("DELETE FROM `users` WHERE 'user_id'=1");
	}
}
