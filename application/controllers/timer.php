<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Timer extends CI_Controller {
	public function __construct() {
	
		parent::__construct();
		$this->load->model(array('timer_model'));

		
	}
	
	public function index() {
		$this->load->view('header');
		$this->load->view('timer');
		$this->load->view('footer');
	}

	public function projects() {
		$data = $this->timer_model->getProjects();
		echo json_encode($data);

	}

	public function tasklist() {
		$data = $this->timer_model->getTaskList($this->input->post('project_id'));
		echo json_encode($data);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */