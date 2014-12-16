<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


class Notes extends CI_Controller {
	public function __construct() {

		parent::__construct();
		$this->load->library('pusher');
		$this->load->model(array('notes_model'));

	}

	public function index() {
		$this->load->view('header');
		$this->load->view('login');
		$this->load->view('footer');
	}

	public function createNotes() {
		if ($this->session->userdata('logged_in') == TRUE) {

			$channel = $this->input->post('note_title');
			$channel = (explode(" ", $channel));
			$channel = implode("_",$channel);

			$notes_id = $this->notes_model->createNotes($this->input->post('note_title'), $this->input->post('note_content'), $channel);
			$data = array(
				"status" => true,
				"notes_id" => $notes_id
				);
			echo json_encode($data);
		} else {

		}
	}

	public function updateNote() {
		if ($this->session->userdata('logged_in') == TRUE) {

			$res = $this->notes_model->updateNotes($this->input->post('note_id'), $this->input->post('note_title'), $this->input->post('update_note_content'));
			if ($res == 1) {
				$data = array(
					"status" => true,
					"message" => 'Notes Updated Successfully'
					);
				echo json_encode($data);
			}else {
				$data = array(
					"status" => false,
					"message" => 'Some Error occured'
					);
				echo json_encode($data);
			}
		} else {

		}
	}

	public function listing() {
		if ($this->session->userdata('logged_in') == TRUE) {
			$data['notes'] = $this->notes_model->getNotes();
			$this->load->view('header');
			$this->load->view('notes_list', $data);
			$this->load->view('footer');

		} else {
			redirect(base_url().'notes');
		}

	}

	public function notes_by_id() {
		if ($this->session->userdata('logged_in') == TRUE) {
			$data['note'] = $this->notes_model->getNotesById($this->uri->segment(2));
			$this->load->view('header');
			$this->load->view('note_details', $data);
			$this->load->view('footer');
			$this->load->view('socket_view', $data);

		} else {
			redirect(base_url().'notes');
		}

	}

	public function session() {
		$username = $this->input->post('username');
		$user_id = $this->input->post('user_id');
		$username = trim(filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES));
		$data = array(
			'username'     => $username,
			'user_id'			 =>	$user_id,
			'logged_in' => TRUE
			);
		$this->session->set_userdata($data);
		echo json_encode(array('success' => true));
		exit();
	}

	public function auth() {

		$socket_id = $this->input->post('socket_id');
		$channel_name = $this->input->post('channel_name');

		$presence_data = array(
			'username' => $this->session->userdata('username')
			);

		echo $this->pusher->presence_auth(
			$channel_name,
			$socket_id,
			$this->session->userdata('session_id'),
			$presence_data 
			);
	}

	public function whoisEditing() {

		$channel_name = $this->input->post('channel_name');

		$message = $this->session->userdata('username')." is Editing...";
		 
		$this->pusher->trigger($channel_name, 'whos_editing', array('message' => $message));
 
		echo json_encode(array(
	    'message' => $message,
	    'success' => true
		));

	}
}
