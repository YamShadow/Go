<?php

require_once('Goban_model.php');

class Partie_model extends CI_model {
    /***** Fonctions principales *****/

    private $goban = null;

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Fonction d'initiatialisation de la partie. Elle permet de crée une instance de Partie en BDD ainsi que toute les variables de sessions. Ceci comprendre la génération d'un Goban en cache.
     *
     * @param [int] $size
     * @return void
     */
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

    /**
     * Permet la création d'un goban et son stockage en session
     *
     * @param [int] $size
     * @return void
     */
    function createGoban($size){
        $array = array();
        for($i= 0; $i < $size; $i++){
            $array[$i] = array();
            for($j= 0; $j < $size; $j++){
                $array[$i][$j] = array(
                    'position' => ['x' => $i, 'y' => $j], 
                    'color' => null);
            }
        }

        $this->session->set_userdata('goban', $array);
    }

    public function play($pos, $color) {
        $this->goban = new Goban_Model($this->session->goban);
        return $this->goban->play($pos, $color);
    }

    /**
     * Methode qui permet de mettre a jour une variable de session
     *
     * @param [String] $variable
     * @param [type] $value
     * @return void
     */
    function updateScoreSession($variable, $value){
        $this->session->set_userdata($variable, $value);
    }

    /**
     * Methode d'insert de partie en BDD
     *
     * @return void
     */
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

    /**
     * Methode qui permet de sauvegarder un coup en BDD
     *
     * @param [int] $x
     * @param [int] $y
     * @return void
     */
    function saveCoup($x, $y) {
        $data = array(
            'idPartie' => $this->session->userdata('idPartie'),
            'positionX' => $x,
            'positionY' => $y,
        );

        $this->db->insert('historique_coups', $data);
    }

    /**
     * Methode qui permet de mettre a jour les scores finaux de la partie 
     *
     * @return void
     */
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