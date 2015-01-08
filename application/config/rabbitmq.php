<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
|  Development Rabbitmq Server Configuration
| -------------------------------------------------------------------------
| This determine your message broker (server) configuration
|
*/

// $config['host'] = 'localhost';
// $config['port'] = '15672';
// $config['user'] = 'guest';
// $config['pass'] = 'guest';
// $config['connection_timeout'] =10;

/*
| -------------------------------------------------------------------------
| Production cloudamqp Server Configuration
| -------------------------------------------------------------------------
|
*/
$config['host'] = 'tiger.cloudamqp.com';
$config['port'] = '5672';
$config['user'] = 'wzbqrcmt';
$config['pass'] = 'h1mM28SFMXtkJWJA1H1ivj5JHSijgFBU';
$config['path'] = 'wzbqrcmt';

/* End of file rabbitmq.php */
/* Location: ./application/config/rabbitmq.php */
