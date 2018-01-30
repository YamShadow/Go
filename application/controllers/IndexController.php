<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class IndexController extends CI_Controller {


    /**
     * Controlleur d'IndexController
     */
    function __construct(){
        parent::__construct();
        $this->load->model('Partie_model', 'partie');
    }

    /**
     * Methode index
     *
     * @return void
     */
	public function index()
	{

        $this->go->log('test');
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
    
    /**
     * renderGoban qui permet de faire le rendu du Goban
     *
     * @param [integer] $size
     * @return void
     */
    public function renderGoban($size = null) {
        if (isset($size) && in_array($size, ['9', '13']))
            $renderSize = $size;
        else $renderSize = 19;
        $this->partie->setSessionInit($renderSize);

        var_dump($this->session);

		$this->load->view('base', array(
            'header' => array(
                'css' => array(
                    'https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css',
                    'css/style.css'
                )
            ),
            'body' => 'go_board',
            'footer' => array(
                'js' => array(
                    'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js',
                    'js/script.js'
                )
            ),
            'size_goban' => $renderSize
        ));
    }
}
