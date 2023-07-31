<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication extends CI_Controller {
	
	public function __construct()
	{
    parent::__construct();
    
    $uriString = $this->uri->uri_string();
    $uriExcepts = array(
      'authentication/logout',
      'authentication/change_password',
    );

    if(Auth::check() && ! in_array($uriString, $uriExcepts)) {
    	return redirect('dashboard');
    }
	}

	public function login()
	{
		if('post' === $this->input->method()){
			$username = $this->input->post('username', TRUE);
    	$password = $this->input->post('password', TRUE);

    	$findUser = $this->MainModel->findDataWhere('users', array('username' => $username));

    	if($findUser && password_verify($password, $findUser['password'])) {
    		Auth::set_userdata($findUser);
    		return redirect('dashboard');
    	}

    	$this->session->set_flashdata(array(
    		'message' => 'Username atau Password anda salah!',
    		'class'   => 'alert-danger',
    	));

    	return redirect('authentication/login');
		}

		return $this->load->view('public/login', array(
			'title' => 'Login',
		));
	}

	public function logout()
	{
		$this->session->sess_destroy();
		return redirect('authentication/login');
	}
}
