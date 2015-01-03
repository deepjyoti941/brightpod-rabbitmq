<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Basecamp extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->model(array('basecamp_exporter'));

		$this->load->library('oauth');
		$this->CI = get_instance();
		$this->CI->load->config('oauth');

		$this->client               = new Oauth;
		$this->client->server       = '37Signals';
		$this->client->debug        = false;
		$this->client->debug_http   = true;
		$this->client->redirect_uri = $this->CI->config->item('redirect_uri');

		$this->client->client_id     = $this->CI->config->item('client_id');
		$application_line            = __LINE__;
		$this->client->client_secret = $this->CI->config->item('client_secret');
		$this->client->scope         = '';
		$this->client->Initialize();
		$success = $this->client->Process();
	}

	public function index() {

		if (strlen($this->client->client_id) == 0 || strlen($this->client->client_secret) == 0) {
			die('Please go to 37Signals Integrate new application page ' .
				'https://integrate.37signals.com/apps/new and in the line ' . $application_line .
				' set the client_id to Client ID and client_secret with Client secret. ' .
				'The site domain must have the same domain of ' . $client->redirect_uri);
		}

		/* API permissions
		 */

		if (strlen($this->client->authorization_error)) {
			$this->client->error = $this->client->authorization_error;
			$success             = false;
		} elseif (strlen($this->client->access_token)) {

			$success = $this->client->CallAPI(
				'https://launchpad.37signals.com/authorization.json',
				'GET', array(), array('FailOnAccessError' => true), $user);

		}

		$success = $this->client->Finalize($success);
		if ($this->client->exit) {
			exit;
		}

		if ($success) {
			$data['user'] = $user;
			$this->load->view('header');
			$this->load->view('basecamp_resource_list', $data);
			$this->load->view('footer');
		} else {
			print_r($this->client->error);
		}

	}

	public function projects() {

		if (strlen($this->client->authorization_error)) {
			$this->client->error = $this->client->authorization_error;
			$success             = false;
		} elseif (strlen($this->client->access_token)) {

			$success = $this->client->CallAPI(
				'https://basecamp.com/2820983/api/v1/projects.json',
				'GET',
				array(),
				array(
					'FailOnAccessError' => true,
				),
				$projects
			);

		}

		$success = $this->client->Finalize($success);
		if ($this->client->exit) {
			exit;
		}
		if ($success) {
			$data['projects'] = $projects;
			$this->load->view('header');
			$this->load->view('basecamp_projects', $data);
			$this->load->view('footer');
		} else {
			print_r($this->client->error);
		}
	}


	public function project_by_id() {

		if (strlen($this->client->authorization_error)) {
			$this->client->error = $this->client->authorization_error;
			$success             = false;
		} elseif (strlen($this->client->access_token)) {

			$success = $this->client->CallAPI(
				'https://basecamp.com/2820983/api/v1/projects/' . $this->uri->segment(3) . '.json',
				'GET',
				array(),
				array(
					'FailOnAccessError' => true,
				),
				$project
			);

		}

		$success = $this->client->Finalize($success);
		if ($this->client->exit) {
			exit;
		}
		if ($success) {
			// echo "<pre>";
			// print_r($project);
			// echo "</pre>";
			$data['project'] = $project;
			$this->load->view('header');
			$this->load->view('basecamp_project_details', $data);
			$this->load->view('footer');
		} else {
			print_r($this->client->error);
		}
	}

	public function calenders() {

		if (strlen($this->client->authorization_error)) {
			$this->client->error = $this->client->authorization_error;
			$success             = false;
		} elseif (strlen($this->client->access_token)) {

			$success = $this->client->CallAPI(
				'https://basecamp.com/2820983/api/v1/calendars.json',
				'GET',
				array(),
				array(
					'FailOnAccessError' => true,
				),
				$calendars
			);

		}

		$success = $this->client->Finalize($success);
		if ($this->client->exit) {
			exit;
		}
		if ($success) {

			$new_array = json_decode(json_encode($calendars), true);
			echo "<pre>";
			print_r($new_array);
			echo "</pre>";
			echo "<br>";

			// $data['people'] = $people;
			// $this->load->view('header');
			// $this->load->view('basecamp_people', $data);
			// $this->load->view('footer');

			$student_info = array($new_array);

			// creating object of SimpleXMLElement
			$xml_student_info = new SimpleXMLElement("<?xml version=\"1.0\"?><calender></calender>");

			// function call to convert array to xml
			$this->basecamp_exporter->array_to_xml($student_info,$xml_student_info);

			//saving generated xml file
			$path = $_SERVER['DOCUMENT_ROOT'].'/exports/calender1.xml';
			$xml_student_info->asXML($path);

			// echo "<pre>";
			// print_r($calendars);
			// echo "</pre>";
			// $data['calendars'] = $calendars;
			// $this->load->view('header');
			// $this->load->view('basecamp_calenders', $data);
			// $this->load->view('footer');
		} else {
			print_r($this->client->error);
		}
	}

	public function people() {

		if (strlen($this->client->authorization_error)) {
			$this->client->error = $this->client->authorization_error;
			$success             = false;
		} elseif (strlen($this->client->access_token)) {

			$success = $this->client->CallAPI(
				'https://basecamp.com/2820983/api/v1/people.json',
				'GET',
				array(),
				array(
					'FailOnAccessError' => true,
				),
				$people
			);

		}

		$success = $this->client->Finalize($success);
		if ($this->client->exit) {
			exit;
		}
		if ($success) {

			$new_array = json_decode(json_encode($people), true);
			echo "<pre>";
			print_r($new_array);
			echo "</pre>";
			echo "<br>";

			// $data['people'] = $people;
			// $this->load->view('header');
			// $this->load->view('basecamp_people', $data);
			// $this->load->view('footer');

			$student_info = array($new_array);

			// creating object of SimpleXMLElement
			$xml_student_info = new SimpleXMLElement("<?xml version=\"1.0\"?><student_info></student_info>");

			// function call to convert array to xml
			$this->basecamp_exporter->array_to_xml($student_info,$xml_student_info);

			//saving generated xml file
			$path = $_SERVER['DOCUMENT_ROOT'].'/exports/myfile3.xml';
			$xml_student_info->asXML($path);


		} else {
			print_r($this->client->error);
		}
	}
}
