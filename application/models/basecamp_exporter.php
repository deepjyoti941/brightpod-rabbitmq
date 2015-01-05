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

  public function exportSelectedProjects ($project_list) {

    $i = 0;
    foreach ($project_list as $project) {
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
      $project_details['accesses'][$i]['project_id'] = $project->id;
      $project_details['accesses'][$i]['accesses_details'] = $accesses_array;


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

  }

}
