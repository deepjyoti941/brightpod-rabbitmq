<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Queue Server Configuration
| -------------------------------------------------------------------------
| This determine your message broker (server) configuration
|
*/

$config['host'] = 'localhost';
$config['port'] = '5672';
$config['user'] = 'guest';
$config['pass'] = 'guest';
$config['connection_timeout'] =10;

/* End of file rabbitmq.php */
/* Location: ./application/config/rabbitmq.php */