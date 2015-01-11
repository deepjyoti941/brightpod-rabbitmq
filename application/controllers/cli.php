<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Cli extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // load gearman library
        //$this->load->spark('codeigniter-gearman/1.0.0');
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
        //$this->basecamp_exporter->exportSelectedProjects($data);
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