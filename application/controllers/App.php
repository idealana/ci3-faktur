<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class App extends CI_Controller {

	public function index()
	{
		return redirect('authentication/login');
	}
}
