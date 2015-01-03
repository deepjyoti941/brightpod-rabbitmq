<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

require_once __DIR__ . '/../third_party/PhpAmqpLib/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Worker extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->connection = new AMQPConnection($this->config->item('host'), $this->config->item('port'), $this->config->item('user'), $this->config->item('pass'), $this->config->item('path'));
		$this->channel    = $this->connection->channel();
	}

	public function index() {
		$this->channel->queue_declare('email_queue', false, true, false, false);
		echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

		$callback = function ($msg) {
			$data = json_decode($msg->body, true);
			echo "sending mail to: " . $data['email'], "\n";
			$from       = 'Deepjyoti Khakhlary';
			$from_email = 'avirajsaikia@gmail.com';
			$to_email   = $data['email'];
			$subject    = 'testing rabbitmq queue';
			$message    = 'testing message - rabbitmq mail queuing ';

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
			echo " * Message was sent", "\n";
			$msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
		};

		$this->channel->basic_qos(null, 1, null);
		$this->channel->basic_consume('email_queue', '', false, false, false, false, $callback);
		while (count($this->channel->callbacks)) {
			$this->channel->wait();
		}
		// $this->channel->close();
		// $this->connection->close();
	}
}
