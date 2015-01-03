<?php if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

class Basecamp_exporter extends CI_Model {

	function __construct() {
		parent::__construct();

	}

	// function defination to convert array to xml
	public function array_to_xml($student_info, &$xml_student_info) {
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

}
