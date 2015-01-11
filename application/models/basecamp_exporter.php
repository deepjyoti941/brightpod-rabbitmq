<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Basecamp_exporter extends CI_Model {

	function __construct() {
		parent::__construct();

	}

	// function defination to convert array to xml
	public function arrayToXml($student_info, &$xml_student_info) {
    foreach($student_info as $key => $value) {
      if(is_array($value)) {
        if(!is_numeric($key)) {
          $subnode = $xml_student_info->addChild("$key");
          $this->array_to_xml($value, $subnode);
        }
        else{
          $subnode = $xml_student_info->addChild("item$key");
          $this->array_to_xml($value, $subnode);
        }
      }
      else {
        $xml_student_info->addChild("$key",htmlspecialchars("$value"));
      }
    }
	}

  public function exportSelectedProjects ($data) {

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
          "message" => 'unable to write',
          "data"=> $json_string
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

  }

  public function exportSelectedCalenders ($calender_list) {

    foreach ($calender_list as $calender) {
      $calender_id_ = $calender;
      $calender_details = array();
      $success = $this->client->CallAPI(
        $this->session->userdata('href').'/calendars/'.$calender.'.json',
        'GET',
        array(),
        array(
          'FailOnAccessError' => true,
        ),
        $calender
      );

      $calender_array = json_decode(json_encode($calender), true);
      $calender_details['basic_details']= $calender_array;


      /* api call for accesses for calender*/
      $this->client->CallAPI(
        $calender->accesses->url,
        'GET',
        array(),
        array(
          'FailOnAccessError' => true,
        ),
        $accesses
      );
      $accesses_array = json_decode(json_encode($accesses), true);
      $calender_details['accesses']['calender_id'] = $calender->id;
      $calender_details['accesses']['accesses_details'] = $accesses_array;

      /* api call for upcoming calender events*/
      $this->client->CallAPI(
        $calender->calendar_events->urls->upcoming,
        'GET',
        array(),
        array(
          'FailOnAccessError' => true,
        ),
        $upcoming_event
      );
      $upcoming_array = json_decode(json_encode($upcoming_event), true);
      $calender_details['upcoming_calender_event']['calender_id'] = $calender->id;
      $calender_details['upcoming_calender_event']['upcoming_details'] = $upcoming_array;

      /* api call for upcoming calender events full details*/
      $j = 0;
      foreach ($upcoming_event as $key=>$row) {
        $this->client->CallAPI(
          $row->url,
          'GET',
          array(),
          array(
            'FailOnAccessError' => true,
          ),
          $upcoming_event_full
        );
        $upcoming_event_full_array = json_decode(json_encode($upcoming_event_full), true);
        $calender_details['upcoming_calender_event_details'][$j]['calender_id'] = $calender->id;
        $calender_details['upcoming_calender_event_details'][$j]['upcoming_event_id'] = $upcoming_event_full->id;
        $calender_details['upcoming_calender_event_details'][$j]['upcoming_event_content'] = $upcoming_event_full_array;

        $j++;
      }

      /* api call for past calender events*/
      $this->client->CallAPI(
        $calender->calendar_events->urls->past,
        'GET',
        array(),
        array(
          'FailOnAccessError' => true,
        ),
        $past_event
      );
      $past_array = json_decode(json_encode($past_event), true);
      $calender_details['past_calender_event']['calender_id'] = $calender->id;
      $calender_details['past_calender_event']['past_details'] = $past_array;


      /* api call for past calender events full details*/
      $k = 0;
      foreach ($past_event as $key=>$row) {
        $this->client->CallAPI(
          $row->url,
          'GET',
          array(),
          array(
            'FailOnAccessError' => true,
          ),
          $past_event_full
        );
        $past_event_full_array = json_decode(json_encode($past_event_full), true);
        $calender_details['past_calender_event_details'][$k]['calender_id'] = $calender->id;
        $calender_details['past_calender_event_details'][$k]['past_event_id'] = $past_event_full->id;
        $calender_details['past_calender_event_details'][$k]['past_event_content'] = $past_event_full_array;

        $k++;
      }

      $json_string = json_encode($calender_details, JSON_PRETTY_PRINT);
      // echo "<pre>";
      // print_r($calender_details);
      // echo "</pre>";

      $dir = $_SERVER['DOCUMENT_ROOT'].'/exports/' .$this->session->userdata('id').'/calenders/';
      if (!is_dir($dir)) {
        mkdir($dir,0777, TRUE);
      }
      $path = $dir.$calender_id_.'.json';
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
          "message" => 'calenders exported successfully',
          "export_path" => '/exports/' .$this->session->userdata('id').'/calenders'
        );
        echo json_encode($data);
      }

    }
  }

}
