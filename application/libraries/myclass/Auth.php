<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Auth
{
	/**
	 * CI Session
	 */
	private $session;

	/**
	 * CI Main Model
	 */
	private $Model;

	/**
	 * CI uri
	 */
	private $uri;

	/**
	 * CI router
	 */
	private $router;

	/**
	 * Auth instance
	 */
	private static $instance;

	/**
	 * Auth user
	 */
	private $user;

	/**
	 * Create New Auth Instance
	 * @return Auth class
	 */
	private static function init()
	{
		if(FALSE === self::$instance instanceof Auth) {
			$CI =& get_instance();

			self::$instance = new self();
			self::$instance->session = $CI->session;
			self::$instance->Model = $CI->MainModel;
			self::$instance->uri = $CI->uri;
			self::$instance->router = $CI->router;
		}
		return self::$instance;
	}

	/**
	 * Set Session Userdata
	 * @param object $user
	 */
	public static function set_userdata($user)
	{
		$auth = self::init();
		$auth->session->set_userdata(array(
			'user_id'   => $user['user_id'],
			'logged_in' => true,
		));
	}

	/**
	 * Check User is Authenticated
	 * @return boolean
	 */
	public static function check()
	{
		return TRUE === self::init()->userdata('logged_in');
	}

	/**
	 * Check User is Unauthenticated and Send Response
	 * @return mix
	 */
	public static function authorization_check()
	{
		if(! empty(self::user()->user) && self::check()) return true;
		self::send_unauthorize_response();
	}

	/**
	 * Send Unathorize Response
	 * @return mix
	 */
	public static function send_unauthorize_response()
	{
		$CI =& get_instance();
		
		if($CI->input->is_ajax_request()) {
			$CI->output->set_content_type('application/json');
			$CI->output->set_status_header(401);
			echo json_encode(array(
				'message' => 'Unauthorize User',
				'title'   => 'Unauthorize',
			));
			exit;
		}

		$CI->session->set_flashdata(array(
  		'message' => 'Silahkan Login Terlebih Dahulu!',
  		'class'   => 'alert-info',
  	));
		return redirect('authentication/login');
	}

	/**
	 * Get Userdata by Key
	 * @return mix
	 */
	public function userdata($key)
	{
		return $this->session->userdata($key);
	}

	/**
	 * Create Object Auth User
	 * @return Auth class
	 */
	public static function user()
	{
		$auth = self::init();
		if(empty($auth->user)) {
			$auth->user = $auth->Model->findDataWhere('users', array('user_id' => $auth->userdata('user_id')));
		}

		return $auth;
	}

	/**
	 * Get User Property by Name
	 * @return mix
	 */
	public function get($name)
	{
		return $this->user[ $name ];
	}

	/**
	 * Get User Access Menu
	 * @return array
	 */
	public function get_access_menu()
	{
		return $this->Model->getUserAccessMenus($this->get('user_id'));
	}

	/**
	 * Check User Menu Authorization
	 * @param string $menu_uri, string $action_name
	 * @return boolean
	 */
	public function is_action_granted($menu_uri, $action_name)
	{
		$userMenus = $this->get_access_menu();
		$isGranted = false;

		foreach ($userMenus as $userMenu) {
			$userMenu = (array) $userMenu;

			if($menu_uri === $userMenu['menu_uri']) {
				$isGranted = 'granted' === $userMenu[ $action_name ];
				break;
			}
		}

		return $isGranted;
	}

	/**
	 * Check is Granted User Menu
	 * @param string $action_name
	 * @return boolean
	 */
	public function is_granted($action_name)
	{
		$route = $this->router->directory . $this->router->class;
		return $this->is_action_granted($route, $action_name);
	}

	/**
	 * Create User Log
	 * @param string $action, string $message
	 * @return Auth Class
	 */
	public function log($action, $message)
	{
		$this->Model->store('user_logs', array(
			'ul_username'   => $this->get('username'),
			'ul_ref_url'    => $this->uri->uri_string(),
			'ul_action'     => $action,
			'ul_message'    => $message,
			'ul_created_at' => date('Y-m-d H:i:s'),
		));
		return $this;
	}

	/**
	 * is Level User Greater
	 * @param string $user_role
	 * @return bool
	 */
	public function is_level_greater_than($user_role)
	{
		return Helper::get_user_role_level($user_role) > Helper::get_user_role_level($this->get('role'));
	}

	/**
	 * is Level User Greater Then Equal
	 * @param string $user_role
	 * @return bool
	 */
	public function is_level_greater_than_equal($user_role)
	{
		return Helper::get_user_role_level($user_role) >= Helper::get_user_role_level($this->get('role'));
	}

	/**
	 * Update User
	 * @return object
	 */
	public function update($data)
	{
		$this->Model->update('users', $data, array('user_id' => $this->get('user_id')));
		return $this;
	}

	/**
	 * is Super Admin role
	 * @return bool
	 */
	public function is_super_admin()
	{
		return 'super_admin' === $this->get('role');
	}

	/**
	 * is Admin role
	 * @return bool
	 */
	public function is_admin()
	{
		return 'admin' === $this->get('role');
	}

	/**
	 * is Pengelola role
	 * @return bool
	 */
	public function is_pengelola()
	{
		return 'pengelola' === $this->get('role');
	}

	/**
	 * is Operator role
	 * @return bool
	 */
	public function is_operator()
	{
		return 'operator' === $this->get('role');
	}

	/**
	 * get sekolah total siswa
	 * @return int
	 */
	public function get_sekolah_total_siswa()
	{
		if($this->is_operator()) {
			return $this->Model->get_total_siswa_by_nss($this->get('sekolah_nss'));
		}
		return 0;
	}

	/**
	 * get bidang jenjang
	 * @return array
	 */
	public function get_bidang_jenjang()
	{
		$bidang_jenjang = empty($this->get('bidang_jenjang')) ? array() : json_decode($this->get('bidang_jenjang'));
		return $bidang_jenjang;
	}
}
