<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Touch {

	private $_CI;

	public function __construct(){
    	$this->_CI = &get_instance();
    }

	public function go_deep($data){

		$this->_CI->load->database();

		$this->_CI->db->insert('testable', array('teststr' => 'dfsfdfsdf'));

	}
}
