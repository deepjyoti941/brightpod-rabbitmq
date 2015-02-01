<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Timer_model extends CI_Model {

	function __construct() {
		parent::__construct();

	}

	public function getProjects() {
		$query = $this->db->get('projects');
		return $query->result();
	}

	public function getTaskList($project_id = 0) {
		$query = $this->db->get_where('task_lists', array('project_id' => $project_id));
		return $query->result();
	}

	public function getTasks() {
		$this->db->select('*');
		$this->db->from('tasks');
		$this->db->join('projects', 'projects.project_id = tasks.project_id');
		$this->db->order_by('tasks.task_id', 'desc'); 
		$query = $this->db->get();
		return $query->result();
	}

	public function saveTask($task_name=0, $timer=0, $task_total_duration=0, $project_id=0, $created_date=0, $task_list_id=0) {
		$data = array(
			'list_id'     				=> $task_list_id,
			'project_id' 					=> $project_id,
			'client_id'  					=> 2,
			'task_name'   				=> $task_name,
			'task_date'   				=> $created_date,
			'task_total_duration' => $task_total_duration,
			'task_time'						=> $timer
		);

		$this->db->insert('tasks', $data);
	}
}