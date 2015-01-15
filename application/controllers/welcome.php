<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Welcome extends CI_Controller {
	public function __construct() {
	
		parent::__construct();
		//$this->load->library('rabbitmq');	
		
	}
	public function index() {
		$this->load->view('header');
		$this->load->view('welcome_message');
		$this->load->view('footer');
	}

	public function queue() {
		$this->rabbitmq->add_to_queue($this->input->post());
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */