<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Timer extends CI_Controller {
	public function __construct() {
	
		parent::__construct();
		$this->load->model(array('timer_model'));

		
	}
	
	public function index() {
		$data['projects'] = $this->timer_model->getProjects();
		$data['tasks'] = $this->timer_model->getTasks();
		
		$this->load->view('header');
		$this->load->view('timer', $data);
		$this->load->view('footer');
	}

	public function timerPopup() {
		$data['projects'] = $this->timer_model->getProjects();
		$data['tasks'] = $this->timer_model->getTasks();
		
		$this->load->view('pop_up_header');
		$this->load->view('timer_popup', $data);
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

	public function getTasks() {
		$data = $this->timer_model->getTasks();
		echo json_encode($data);
	}

	public function saveTask() {
		$this->timer_model->saveTask($this->input->post('task_name'), $this->input->post('timer'), $this->input->post('timer_duration'), $this->input->post('project_id'), $this->input->post('created_date'), $this->input->post('task_list_id'));

	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */