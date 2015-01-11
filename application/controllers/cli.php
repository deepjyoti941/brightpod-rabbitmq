<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cli extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('file');
        $this->load->model(array('basecamp_exporter'));
    }

     public static function doSendEmail($job) {
       $data = unserialize($job->workload());
       print_r($data);
       sleep(2);
       echo "Email sending is done really.\n\n";
    }

    public static function doExportProjects($job) {
        $data = unserialize($job->workload());
        //print_r($data['project_list']);
        $this->basecamp_exporter->exportSelectedProjects($data);

    }

    public function client() {
        $this->lib_gearman->gearman_client();

        $data = array(
          'user_email' => $this->input->post('user_email'),
          'project_list' => $this->input->post('project_list')
          );

        $this->lib_gearman->do_job_background('exportProjects', serialize($data));

    }

    public function worker() {
        $worker = $this->lib_gearman->gearman_worker();

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
