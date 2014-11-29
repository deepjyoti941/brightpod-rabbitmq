<?php if (!defined("BASEPATH")) exit("No direct script access allowed");

require_once __DIR__ . '/../third_party/PhpAmqpLib/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Rabbitmq {
    /**
     * Confirguration
     * Default configuration intialized from queue config file
     */
    var $host = '';
    var $port = '';
    var $user = '';
    var $pass = '';
    
    /**
     * Connection
     */
    var $connection = null;
    
    /**
     * Channel
     */
    var $channel = null;
     
    
    /**
     * Constructor with configuration array
     *
     * @param array $config
     */
    public function __construct($config=array()) {
	    
	    // Configuration
		if ( ! empty($config) ) {
			$this->initialize($config);
		}
		
		// Connecting to message server
		$this->connection = new AMQPConnection($this->host, $this->port, $this->user, $this->pass);
		$this->channel = $this->connection->channel();
	    
    }
    
    /**
     * Initialize with configuration array
     *
     * @param array $config
     */
    public function initialize($config=array()) {
	    foreach ($config as $key=>$value) {
		     $this->{$key} = $value;
	    }
    }

    public function add_to_queue($data=array()) {

      $this->channel->queue_declare('email_queue', false, true, false, false);
      
      $data = json_encode($data);

      $message = new AMQPMessage($data, array('delivery_mode' => 2));
    
      $this->channel->basic_publish($message, '', 'email_queue'); 
    }
    
}
