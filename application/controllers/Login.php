<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Admin_Controller
{

	/**
	 * constructor method
	 */
	public function __construct()
	{

		parent::__construct();
		$this->load->model("user_model");
		$this->load->model("user_m");
		//$this->lang->load("users", 'english');
		//$this->lang->load("system", 'english');

		//$this->output->enable_profiler(TRUE);
	}
	//---------------------------------------------------------------


	/**
	 * Default action to be called
	 */
	public function index()
	{

		//$this->data['captcha'] = $this->captcha(); 
		//check if the user is already logedin
		if ($this->user_m->loggedIn() == TRUE) {

			$homepage_path = $this->session->userdata('role_homepage_uri');
			redirect($homepage_path);
		}


		$this->data['title'] = "Login to dashboard";
		$this->load->view(ADMIN_DIR . "login/login", $this->data);
	}
}
