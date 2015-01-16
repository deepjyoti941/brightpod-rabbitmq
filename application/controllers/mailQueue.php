<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class MailQueue extends CI_Controller {
	public function __construct() {
	
		parent::__construct();
		
	}

	public function index() {
		$this->load->view('header');
		$this->load->view('mail_queue');
		$this->load->view('footer');
	}

}