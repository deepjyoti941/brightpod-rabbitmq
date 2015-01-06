<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Basecamp extends CI_Controller {
	public function __construct() {
		parent::__construct();

		$this->load->helper('file');
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
			$data = json_decode(json_encode($user->accounts[0]), true);

			$this->session->set_userdata($data);
			// echo "<pre>";
			// print_r($user);
			// echo "</pre>";
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
				$this->session->userdata('href').'/projects.json',
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
				$this->session->userdata('href').'/projects/' . $this->uri->segment(3) . '.json',
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
				$this->session->userdata('href').'/calendars.json',
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

			$data['calendars'] = $calendars;
			$this->load->view('header');
			$this->load->view('basecamp_calenders', $data);
			$this->load->view('footer');
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
				$this->session->userdata('href').'/people.json',
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
			// echo "<pre>";
			// print_r($new_array);
			// echo "</pre>";
			// echo "<br>";

			$data['people'] = $people;
			$this->load->view('header');
			$this->load->view('basecamp_people', $data);
			$this->load->view('footer');


		} else {
			print_r($this->client->error);
		}
	}

	public function exportProjects() {

		$dir = $_SERVER['DOCUMENT_ROOT'].'/exports/' .$this->session->userdata('id').'/projects';

		if (!is_dir($dir)) {
		$project_details = array();

		$success = $this->client->CallAPI(
			$this->session->userdata('href').'/projects.json',
			'GET',
			array(),
			array(
				'FailOnAccessError' => true,
			),
			$projects
		);

		$projects_array = json_decode(json_encode($projects), true);
		$project_details['project_list'] = $projects_array;

		if ($success) {
			$i = 0;
			foreach ($projects as $key=>$row) {
				$success = $this->client->CallAPI(
					$row->url,
					'GET',
					array(),
					array(
						'FailOnAccessError' => true,
					),
					$project
				);
				$project_array = json_decode(json_encode($project), true);
				$project_details['details'][$i] = $project_array;

				if ($success) {

					/* api call for accesses*/
					$this->client->CallAPI(
						$project->accesses->url,
						'GET',
						array(),
						array(
							'FailOnAccessError' => true,
						),
						$accesses
					);
					$accesses_array = json_decode(json_encode($accesses), true);
					$project_details['accesses'][$i]['project_id'] = $project->id;
					$project_details['accesses'][$i]['accesses_details'] = $accesses_array;

					/* api call for attachments*/
					$this->client->CallAPI(
						$project->attachments->url,
						'GET',
						array(),
						array(
							'FailOnAccessError' => true,
						),
						$attachments
					);
					$attachments_array = json_decode(json_encode($attachments), true);
					$project_details['attachments'][$i]['project_id'] = $project->id;
					$project_details['attachments'][$i]['attachments_details'] = $attachments_array;

					/* api call for calendar_events*/
					$this->client->CallAPI(
						$project->calendar_events->url,
						'GET',
						array(),
						array(
							'FailOnAccessError' => true,
						),
						$calendar_events
					);
					$calendar_events_array = json_decode(json_encode($calendar_events), true);
					$project_details['calendar_events'][$i]['project_id'] = $project->id;
					$project_details['calendar_events'][$i]['calendar_events_details'] = $calendar_events_array;

					/* api call for documents*/
					$this->client->CallAPI(
						$project->documents->url,
						'GET',
						array(),
						array(
							'FailOnAccessError' => true,
						),
						$documents
					);
					$documents_array = json_decode(json_encode($documents), true);
					$project_details['documents'][$i]['project_id'] = $project->id;
					$project_details['documents'][$i]['documents_details'] = $documents_array;

					/* api call for forwards*/
					$this->client->CallAPI(
						$project->forwards->url,
						'GET',
						array(),
						array(
							'FailOnAccessError' => true,
						),
						$forwards
					);
					$forwards_array = json_decode(json_encode($forwards), true);
					$project_details['forwards'][$i]['project_id'] = $project->id;
					$project_details['forwards'][$i]['forwards_details'] = $forwards_array;

					/* api call for topics*/
					$this->client->CallAPI(
						$project->topics->url,
						'GET',
						array(),
						array(
							'FailOnAccessError' => true,
						),
						$topics
					);
					$topics_array = json_decode(json_encode($topics), true);
					$project_details['topics'][$i]['project_id'] = $project->id;
					$project_details['topics'][$i]['topics_details'] = $topics_array;

					/* api call for todolists*/
					$this->client->CallAPI(
						$project->todolists->url,
						'GET',
						array(),
						array(
							'FailOnAccessError' => true,
						),
						$todolists
					);
					$todolists_array = json_decode(json_encode($todolists), true);
					$project_details['todolists'][$i]['project_id'] = $project->id;
					$project_details['todolists'][$i]['todolists_details'] = $todolists_array;

					/* api call for todolists content*/
					$j = 0;
					foreach ($todolists as $key=>$row) {
						$this->client->CallAPI(
							$row->url,
							'GET',
							array(),
							array(
								'FailOnAccessError' => true,
							),
							$todolists_content
						);
						$todolists_content_array = json_decode(json_encode($todolists_content), true);
						$project_details['todolists_content'][$j]['project_id'] = $project->id;
						$project_details['todolists_content'][$j]['todo_id'] = $todolists_content->id;
						$project_details['todolists_content'][$j]['todolists_content_details'] = $todolists_content_array;

						$j++;
					}

					$i++;

				} else {
					print_r($this->client->error);
				}
			}
		} else {
			print_r($this->client->error);
		}
			$json_string = json_encode($project_details, JSON_PRETTY_PRINT);

			if (!is_dir($dir)) {
			  mkdir($dir, 0777, TRUE);
			}

			$path = $_SERVER['DOCUMENT_ROOT'].'/exports/' .$this->session->userdata('id').'/projects/data.json';

			if ( ! write_file($path, print_r($json_string,true), 'w+')) {
				  $data = array(
	        "status" => false,
	        "message" => 'unable to write'
	      );
	      echo json_encode($data);
			}
			else {
				$data = array(
	        "status" => true,
	        "message" => 'project exported successfully',
	        "export_path" => '/exports/' .$this->session->userdata('id').'/projects/data.json'
	      );
	      echo json_encode($data);
			}

		} else {
			$data = array(
				"status" => "already_exported",
        "message" => 'Project already exported',
        "export_path"=> '/exports/' .$this->session->userdata('id').'/projects/data.json'
      );
      echo json_encode($data);
		}
	}

	public function exportSelectedProjects () {

		$this->basecamp_exporter->exportSelectedProjects($this->input->post('project_list'));

	}

	public function exportSelectedCalenders () {
		//print_r($this->input->post('calender_list'));
		$this->basecamp_exporter->exportSelectedCalenders($this->input->post('calender_list'));

	}

	public function exportSelectedPeople () {

		// $this->basecamp_exporter->exportSelectedProjects($this->input->post('project_list'));

	}

	public function exportCalenders() {

	}

	public function exportPeople() {

	}

	public function test() {

		if (strlen($this->client->authorization_error)) {
			$this->client->error = $this->client->authorization_error;
			$success             = false;
		} elseif (strlen($this->client->access_token)) {

			$success = $this->client->CallAPI(
				'https://basecamp.com/2820983/api/v1/calendars/1160277/calendar_events/past.json',
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
			echo "<pre>";
			print_r($people);
			echo "</pre>";
			echo "<br>";

		} else {
			print_r($this->client->error);
		}
	}


}
