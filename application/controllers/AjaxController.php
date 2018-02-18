<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxController extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model('Goban_model', 'goban');
		$this->load->model('Partie_model', 'partie');
    }
	
	public function index() {
		// Appeler play avec $pos et $color
		$pos = $this->input->post('pos', true);
		$color = $this->input->post('player', true);

		var_dump($this->session->userdata('goban'));
		if ($pos != null && $color != null)
			$ret = $this->session->userdata('goban')->play($pos, $color);
		else
			$ret = array(
				'etat' => 'nok', 
				'message' => 'Erreur dans le call AJAX'
			);

		// Faire un retour en json
		header('Content-Type: application/json');
		$options = 0;
		echo json_encode($ret, $options);
	}


}
