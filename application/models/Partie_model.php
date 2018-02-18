<?php

require_once('Goban_model.php');

class Partie_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    /***** Fonctions principales *****/

    function setSessionInit($size){
        $idPartie = $this->initPartieBDD();
        $this->session->set_userdata('idPartie', $idPartie);
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
        $this->session->set_userdata('goban', new Goban_model($array));
    }

    function updateScoreSession($variable, $value){
        $this->session->set_userdata($variable, $value);
    }

    function initPartieBDD() {
        $data = array(
            'winner' => '',
            'pierreJ1' => 0,
            'pierreJ1' => 0,
            'scoreJ1' => 0,
            'scoreJ2' => 0
        );

        $this->db->insert('partie', $data);
        $insert_id = $this->db->insert_id();

        return  $insert_id;
    }

    function saveCoup($x, $y) {
        $data = array(
            'idPartie' => $this->session->userdata('idPartie'),
            'positionX' => $x,
            'positionY' => $y,
        );

        $this->db->insert('historique_coups', $data);
    }

    function savePartie() {
        $data = array(
            'winner' => $this->session->userdata('winner'),
            'pierreJ1' => $this->session->userdata('pierreJ1'),
            'pierreJ2' => $this->session->userdata('pierreJ2'),
            'scoreJ1' => $this->session->userdata('scoreJ1'),
            'scoreJ2' => $this->session->userdata('scoreJ2')
        );
        
        $this->db->where('id', $this->session->userdata('idPartie'))
            ->update('partie', $data);
    }

}