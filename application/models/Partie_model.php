<?php

class Partie_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    /***** Fonctions principales *****/

    function setSessionInit($size){
        $this->session->set_userdata('idPartie', '');
        $this->session->set_userdata('datePartie', date('Y-m-d H:m:s'));
        $this->session->set_userdata('winner', '');
        $this->session->set_userdata('pierreJ1', 0);
        $this->session->set_userdata('pierreJ2', 0);
        $this->session->set_userdata('scoreJ1', 0);
        $this->session->set_userdata('scoreJ2', 0);
        $this->createGoban($size);
    }

    function createGoban($size){
        $array = array();
        for($i= 0; $i < $size; $i++){
            $array[$i] = array();
            for($j= 0; $j < $size; $j++){
                $array[$i][$j] = null;
            }
        }
        $this->session->set_userdata('goban', $array);
    }

    function updateScoreSession($variable, $value){
        $this->session->set_userdata($variable, $value);
    }


}