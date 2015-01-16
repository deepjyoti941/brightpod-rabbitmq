<?php defined('BASEPATH') OR exit('No direct script access allowed');

require_once __DIR__ . '/../third_party/PhpAmqpLib/vendor/autoload.php';

class Cli extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->helper('file');
    $this->load->library('oauth','lib_gearman');

    $this->CI = get_instance();
    $this->CI->load->config('oauth');

  }

  public static function doSendEmail($job) {
    $data = unserialize($job->workload());
    $from       = 'Deepjyoti Khakhlary';
    $from_email = 'avirajsaikia@gmail.com';
    $to_email   = $data['email'];
    $subject    = 'Brightpod mail queue testing';
    $message    = 'Just testing mail queue in Brightpod';

    $transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
    ->setUsername('avirajsaikia@gmail.com')
    ->setPassword('');

    $mailer  = Swift_Mailer::newInstance($transporter);
    $message = Swift_Message::newInstance($transporter)
    ->setSubject($subject)
    ->setFrom(array($from_email => $from))
    ->setTo(array($to_email))
    ->setBody($message);

    $mailer->send($message);
  }


  public static function doExportProject($job) {
    $data = unserialize($job->workload());
    try {
      foreach ($data['project_list'] as $project) {
        $project_id_ = $project;
        $project_details = array();
        
        $session_project = curl_init();
        curl_setopt($session_project, CURLOPT_URL,$data['account_url'].'/projects/'.$project.'.json');
        curl_setopt($session_project, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
        curl_setopt($session_project, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session_project, CURLOPT_HTTPGET, 1);
        
        $project = curl_exec($session_project);
        curl_close($session_project);
        $project = json_decode($project);
        $project_array = json_decode(json_encode($project), true);
        $project_details['basic_details']= $project_array;     

        /* api call for accesses*/

        $session_accesses = curl_init();
        curl_setopt($session_accesses, CURLOPT_URL,$project->accesses->url);
        curl_setopt($session_accesses, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
        curl_setopt($session_accesses, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session_accesses, CURLOPT_HTTPGET, 1);
        
        $accesses = curl_exec($session_accesses);
        curl_close($session_accesses);
        $accesses = json_decode($accesses);

        $accesses_array = json_decode(json_encode($accesses), true);
        $project_details['accesses']['project_id'] = $project->id;
        $project_details['accesses']['accesses_details'] = $accesses_array;

        /* api call for people associated with project*/
        $j = 0;
        foreach ($accesses as $key=>$row) {

          $session_people = curl_init();
          curl_setopt($session_people, CURLOPT_URL,$row->url);
          curl_setopt($session_people, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
          curl_setopt($session_people, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($session_people, CURLOPT_HTTPGET, 1);
          $people = curl_exec($session_people);
          curl_close($session_people);
          $people = json_decode($people);        
          $people_array = json_decode(json_encode($people), true);
          $project_details['people_details'][$j]['project_id'] = $project->id;
          $project_details['people_details'][$j]['people_id'] = $people->id;
          $project_details['people_details'][$j]['people_full_details'] = $people_array;

          $j++;
        }

        /* api call for attachments*/
        $session_attachments = curl_init();
        curl_setopt($session_attachments, CURLOPT_URL,$project->accesses->url);
        curl_setopt($session_attachments, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
        curl_setopt($session_attachments, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session_attachments, CURLOPT_HTTPGET, 1);
        
        $attachments = curl_exec($session_attachments);
        curl_close($session_attachments);
        $attachments = json_decode($attachments);

        $attachments_array = json_decode(json_encode($attachments), true);
        $project_details['attachments']['project_id'] = $project->id;
        $project_details['attachments']['attachments_details'] = $attachments_array;

        /* api call for calendar_events*/
        $session_calender_events = curl_init();
        curl_setopt($session_calender_events, CURLOPT_URL,$project->calendar_events->url);
        curl_setopt($session_calender_events, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
        curl_setopt($session_calender_events, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session_calender_events, CURLOPT_HTTPGET, 1);
        
        $calendar_events = curl_exec($session_calender_events);
        curl_close($session_calender_events);
        $calendar_events = json_decode($calendar_events);

        $calendar_events_array = json_decode(json_encode($calendar_events), true);
        $project_details['calendar_events']['project_id'] = $project->id;
        $project_details['calendar_events']['calendar_events_details'] = $calendar_events_array;

        
        /* api call for documents*/
        $session_documents = curl_init();
        curl_setopt($session_documents, CURLOPT_URL,$project->documents->url);
        curl_setopt($session_documents, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
        curl_setopt($session_documents, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session_documents, CURLOPT_HTTPGET, 1);
        
        $documents = curl_exec($session_documents);
        curl_close($session_documents);
        $documents = json_decode($documents);

        $documents_array = json_decode(json_encode($documents), true);
        $project_details['documents']['project_id'] = $project->id;
        $project_details['documents']['documents_details'] = $documents_array;

        
        /* api call for document details*/
        $p = 0;
        foreach ($documents as $key=>$row) {

          $session_document_details = curl_init();
          curl_setopt($session_document_details, CURLOPT_URL,$row->url);
          curl_setopt($session_document_details, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
          curl_setopt($session_document_details, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($session_document_details, CURLOPT_HTTPGET, 1);
          
          $document = curl_exec($session_document_details);
          curl_close($session_document_details);
          $document = json_decode($document);


          $document_array = json_decode(json_encode($document), true);
          $project_details['document_details'][$p]['project_id'] = $project->id;
          $project_details['document_details'][$p]['document_id'] = $document->id;
          $project_details['document_details'][$p]['document_full_details'] = $document_array;

          $p++;
        }

        /* api call for forwards*/
        $session_forwards = curl_init();
        curl_setopt($session_forwards, CURLOPT_URL,$project->forwards->url);
        curl_setopt($session_forwards, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
        curl_setopt($session_forwards, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session_forwards, CURLOPT_HTTPGET, 1);
        
        $forwards = curl_exec($session_forwards);
        curl_close($session_forwards);
        $forwards = json_decode($forwards);

        $forwards_array = json_decode(json_encode($forwards), true);
        $project_details['forwards']['project_id'] = $project->id;
        $project_details['forwards']['forwards_details'] = $forwards_array;


        /* api call for topics*/
        $session_topics = curl_init();
        curl_setopt($session_topics, CURLOPT_URL,$project->topics->url);
        curl_setopt($session_topics, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
        curl_setopt($session_topics, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session_topics, CURLOPT_HTTPGET, 1);
        
        $topics = curl_exec($session_topics);
        curl_close($session_topics);
        $topics = json_decode($topics);

        $topics_array = json_decode(json_encode($topics), true);
        $project_details['topics']['project_id'] = $project->id;
        $project_details['topics']['topics_details'] = $topics_array;
        

        /* api call for todolists*/
        $session_todolists = curl_init();
        curl_setopt($session_todolists, CURLOPT_URL,$project->todolists->url);
        curl_setopt($session_todolists, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
        curl_setopt($session_todolists, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($session_todolists, CURLOPT_HTTPGET, 1);
        
        $todolists = curl_exec($session_todolists);
        curl_close($session_todolists);
        $todolists = json_decode($todolists);

        $todolists_array = json_decode(json_encode($todolists), true);
        $project_details['todolists']['project_id'] = $project->id;
        $project_details['todolists']['todolists_details'] = $todolists_array;


        /* api call for todolists content*/
        $k = 0;
        foreach ($todolists as $key=>$row) {

          $session_todolists_content = curl_init();
          curl_setopt($session_todolists_content, CURLOPT_URL,$row->url);
          curl_setopt($session_todolists_content, CURLOPT_HTTPHEADER, array('Authorization: Bearer '.$data['access_token'], 'User-Agent: myapp (deepjyoti941@gmail.com)'));
          curl_setopt($session_todolists_content, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($session_todolists_content, CURLOPT_HTTPGET, 1);
          
          $todolists_content = curl_exec($session_todolists_content);
          curl_close($session_todolists_content);
          $todolists_content = json_decode($todolists_content);

          $todolists_content_array = json_decode(json_encode($todolists_content), true);
          $project_details['todolists_content'][$k]['project_id'] = $project->id;
          $project_details['todolists_content'][$k]['todo_id'] = $todolists_content->id;
          $project_details['todolists_content'][$k]['todolists_content_details'] = $todolists_content_array;

          $k++;
        }

        $json_string = json_encode($project_details, JSON_PRETTY_PRINT);

        $dir = $data['project_dir'];

        if (!is_dir($dir)) {
          mkdir($dir,0777, TRUE);
        }

        $path = $dir.$project_id_.'.json';

        if (file_put_contents($path, print_r($json_string,true))) {
          echo 'file saved';

        } else {
          echo 'error in saving';
        }
      }

      sleep(2);

      $from       = 'Deepjyoti Khakhlary';
      $from_email = 'avirajsaikia@gmail.com';
      $to_email   = $data['user_email'];
      $subject    = 'Project export status';
      $message    = 'Your project export is done successfully ';

      $transporter = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, 'ssl')
      ->setUsername('avirajsaikia@gmail.com')
      ->setPassword('');

      $mailer  = Swift_Mailer::newInstance($transporter);
      $message = Swift_Message::newInstance($transporter)
      ->setSubject($subject)
      ->setFrom(array($from_email => $from))
      ->setTo(array($to_email))
      ->setBody($message);

      $mailer->send($message);
      echo "exporting is really done.\n\n";     
    } catch (Exception $e) {
      print_r($e->getMessage());
    }

  }
  public function clientMailSend() {
    $this->lib_gearman->gearman_client();

    $emailData = array(
      'name'  => $this->input->post('name'),
      'email' => $this->input->post('email'),
      );

    $this->lib_gearman->do_job_background('sendEmail', serialize($emailData));
    echo "Email sending is done.\n";
  }

  public function client() {
    $this->lib_gearman->gearman_client();

    $exportData = array(
      'user_email'   => $this->input->post('user_email'),
      'project_list' => $this->input->post('project_list'),
      'access_token' => $this->session->userdata('access_token'),
      'account_url'  => $this->session->userdata('href'),
      'project_dir'  => $dir = $_SERVER['DOCUMENT_ROOT'].'/exports/' .$this->session->userdata('id').'/projects/'
      );


    $this->lib_gearman->do_job_background('exportProject', serialize($exportData));
    echo "exporting project is done.\n";

  }

  public function worker() {
    $worker = $this->lib_gearman->gearman_worker();

    $this->lib_gearman->add_worker_function('sendEmail', 'Cli::doSendEmail');
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