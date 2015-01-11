<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cli extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
        //$this->load->model(array('basecamp_exporter'));
    }

    public static function doSendEmail($job)
    {
        $data = unserialize($job->workload());
        print_r($data);
        sleep(2);
        echo "Email sending is done really.\n\n";
    }

    public static function doResizeImage($job)
    {
        $data = unserialize($job->workload());
        print_r($data);
        sleep(2);
        echo "Image resizing is really done.\n\n";
    }

    public static function doExportProject($job) {
        $data = unserialize($job->workload());
        print_r($data);

    $i = 0;
    foreach ($data['project_list'] as $project) {
      $project_id_ = $project;
      $project_details = array();
      $success = $this->client->CallAPI(
        $this->session->userdata('href').'/projects/'.$project.'.json',
        'GET',
        array(),
        array(
          'FailOnAccessError' => true,
        ),
        $project
      );

      $project_array = json_decode(json_encode($project), true);
      $project_details['basic_details']= $project_array;

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
      $project_details['accesses']['project_id'] = $project->id;
      $project_details['accesses']['accesses_details'] = $accesses_array;


      /* api call for people associated with project*/

      $j = 0;
      foreach ($accesses as $key=>$row) {
        $this->client->CallAPI(
          $row->url,
          'GET',
          array(),
          array(
            'FailOnAccessError' => true,
          ),
          $people
        );
        $people_array = json_decode(json_encode($people), true);
        $project_details['people_details'][$j]['project_id'] = $project->id;
        $project_details['people_details'][$j]['people_id'] = $people->id;
        $project_details['people_details'][$j]['people_full_details'] = $people_array;

        $j++;
      }


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
      $project_details['attachments']['project_id'] = $project->id;
      $project_details['attachments']['attachments_details'] = $attachments_array;


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
      $project_details['calendar_events']['project_id'] = $project->id;
      $project_details['calendar_events']['calendar_events_details'] = $calendar_events_array;

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
      $project_details['documents']['project_id'] = $project->id;
      $project_details['documents']['documents_details'] = $documents_array;

      /* api call for document details*/
      $p = 0;
      foreach ($documents as $key=>$row) {
        $this->client->CallAPI(
          $row->url,
          'GET',
          array(),
          array(
            'FailOnAccessError' => true,
          ),
          $document
        );
        $document_array = json_decode(json_encode($document), true);
        $project_details['document_details'][$p]['project_id'] = $project->id;
        $project_details['document_details'][$p]['document_id'] = $document->id;
        $project_details['document_details'][$p]['document_full_details'] = $document_array;

        $p++;
      }

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
      $project_details['forwards']['project_id'] = $project->id;
      $project_details['forwards']['forwards_details'] = $forwards_array;

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
      $project_details['topics']['project_id'] = $project->id;
      $project_details['topics']['topics_details'] = $topics_array;

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
      $project_details['todolists']['project_id'] = $project->id;
      $project_details['todolists']['todolists_details'] = $todolists_array;

      /* api call for todolists content*/
      $k = 0;
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
        $project_details['todolists_content'][$k]['project_id'] = $project->id;
        $project_details['todolists_content'][$k]['todo_id'] = $todolists_content->id;
        $project_details['todolists_content'][$k]['todolists_content_details'] = $todolists_content_array;

        $k++;
      }

      $i++;

      $json_string = json_encode($project_details, JSON_PRETTY_PRINT);


      $dir = $_SERVER['DOCUMENT_ROOT'].'/exports/' .$this->session->userdata('id').'/projects/';
      if (!is_dir($dir)) {
        mkdir($dir,0777, TRUE);
      }
      $path = $dir.$project_id_.'.json';
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
          "export_path" => '/exports/' .$this->session->userdata('id').'/projects'
        );
        echo json_encode($data);
      }

    }

        // $this->basecamp_exporter->exportSelectedProjects($data);
        sleep(2);
        echo "exporting is really done.\n\n";
    }

    public function client()
    {
        $this->lib_gearman->gearman_client();

        $emailData = array(
            'name'  => 'web',
            'email' => 'member@example.com',
        );
        $imageData = array(
            'image' => '/var/www/pub/image/test.png',
        );

        $exportData = array(
          'user_email' => $this->input->post('user_email'),
          'project_list' => $this->input->post('project_list')
          );

        $this->lib_gearman->do_job_background('exportProject', serialize($exportData));
        echo "exporting project is done.\n";

        $this->lib_gearman->do_job_background('sendEmail', serialize($emailData));
        echo "Email sending is done.\n";

        $this->lib_gearman->do_job_background('resizeImage', serialize($imageData));
        echo "Image resizing is done.\n";
    }

    public function worker()
    {
        $worker = $this->lib_gearman->gearman_worker();

        $this->lib_gearman->add_worker_function('sendEmail', 'Cli::doSendEmail');
        $this->lib_gearman->add_worker_function('resizeImage', 'Cli::doResizeImage');
        $this->lib_gearman->add_worker_function('exportProject', 'Cli::doExportProject');

        while ($this->lib_gearman->work()) {
            if (!$worker->returnCode()) {
                echo "worker done successfully \n";
            }
            if ($worker->returnCode() != GEARMAN_SUCCESS) {
                echo "return_code: " . $this->lib_gearman->current('worker')->returnCode() . "\n";
                break;
            }
        }
    }
}