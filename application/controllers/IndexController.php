<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends CI_Controller {
	public function index()
	{
		$this->load->view('base', array(
            'header' => array(
                'css' => array(

                )
            ),
            'body' => 'goban_choice',
            'footer' => array(
                'js' => array(
                    'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js'
                )
            )
        ));
	}
}
