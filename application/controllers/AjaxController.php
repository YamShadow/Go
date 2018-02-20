<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AjaxController extends CI_Controller {
	

	/**
	 * Cnstructeur de la class
	 */
	function __construct() {
		parent::__construct();
    }
	
	public function index() {
		// Appeler play avec $pos et $color
		$pos = $this->input->post('pos', true);
		logGo('[AJAX] position du coup '.$pos);
		$color = $this->input->post('player', true);
		logGo('[AJAX] Joué par '.$color);

		if ($pos != null && $color != null)
			$ret = $this->partie->play($pos, $color);
		else{
			$ret = array(
				'etat' => 'nok', 
				'message' => 'Erreur dans le call AJAX'
			);
			logGo('[AJAX] Erreur dans le call.');
		}

		// Faire un retour en json
		header('Content-Type: application/json');
		$options = 0;
		echo json_encode($ret, $options);
	}


}
