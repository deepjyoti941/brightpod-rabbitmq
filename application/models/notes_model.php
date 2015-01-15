<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Notes_model extends CI_Model {

	function __construct() {
		parent::__construct();

	}

	/*
	 * save notes with parmas created on timestamp, last modified timestamp, link to project id, link to task id,
	 * notes creator id, notes name, notes description
	 */
	public function createNotes($name, $description, $channel) {
		$data = array(
			'user_id'     => $this->session->userdata('user_id'),
			'user_name'   => $this->session->userdata('username'),
			'project_id'  => 1,
			'task_id'     => 1,
			'name'        => $name,
			'description' => $description,
			'channel'     => $channel,
		);

		$this->db->insert('notes', $data);
		return $this->db->insert_id();

	}

	public function getNotes() {
		$query = $this->db->get('notes');
		return $query->result();
	}

	public function getNotesById($id = 0) {
		$query = $this->db->get_where('notes', array('id' => $id));
		return $query->row_array();
	}

	public function updateNotes($id, $name, $description) {
		$query = "UPDATE notes SET user_id = ? , user_name= ?, name = ? , description = ? WHERE id = ?";
		return $this->db->query($query, array(
			'user_id'     => $this->session->userdata('user_id'),
			'user_name'   => $this->session->userdata('username'),
			'name'        => $name,
			'description' => $description,
			'id'          => $id,
		));
	}
}