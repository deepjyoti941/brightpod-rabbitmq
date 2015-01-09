<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cli extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
        $this->load->model(array('basecamp_exporter'));

        // load gearman library
        //$this->load->spark('codeigniter-gearman/1.0.0');
    }

    // public static function doSendEmail($job) {
    //     $data = unserialize($job->workload());
    //     print_r($data);
    //     sleep(2);
    //     echo "Email sending is done really.\n\n";
    // }

    // public static function doResizeImage($job) {
    //     $data = unserialize($job->workload());
    //     print_r($data);
    //     sleep(2);
    //     echo "Image resizing is really done.\n\n";
    // }

    public static function doExportProjects($job) {
        $data = unserialize($job->workload());
        print_r($data);
        //$this->basecamp_exporter->exportSelectedProjects($this->input->post('project_list'));

      $json_string = json_encode($data, JSON_PRETTY_PRINT);
      $dir = $_SERVER['DOCUMENT_ROOT'].'/gearman-log/log.json';

      if ( ! write_file($dir, print_r($json_string,true), 'w+')) {
          $data = array(
          "status" => false,
          "message" => 'unable to write'
        );
        echo json_encode($data);
      }
      else {

      }

    }

    public function client() {
        $this->lib_gearman->gearman_client();

        $data = array(
          'user_email' => $this->input->post('user_email'),
          'project_list' => $this->input->post('project_list')
          );

        $this->lib_gearman->do_job_background('exportProjects', serialize($data));

        // $emailData = array(
        //     'name'  => 'web',
        //     'email' => 'member@example.com',
        // );
        // $imageData = array(
        //     'image' => '/var/www/pub/image/test.png',
        // );

        // $this->lib_gearman->do_job_background('sendEmail', serialize($emailData));
        // echo "Email sending is done.\n";
        // $this->lib_gearman->do_job_background('resizeImage', serialize($imageData));
        // echo "Image resizing is done.\n";
    }

    public function worker() {
        $worker = $this->lib_gearman->gearman_worker();

        // $this->lib_gearman->add_worker_function('sendEmail', 'Cli::doSendEmail');
        // $this->lib_gearman->add_worker_function('resizeImage', 'Cli::doResizeImage');
        $this->lib_gearman->add_worker_function('exportProjects', 'Cli::doExportProjects');

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
