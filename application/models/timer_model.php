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
		$query = $this->db->get_where('tasks', array('project_id' => $project_id));
		return $query->result();
	}
}