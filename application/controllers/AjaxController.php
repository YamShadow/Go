<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxController extends CI_Controller {

	function __construct() {
        parent::__construct();
    }
	
	public function index($json) {
		var_dump($json);
	}


}
