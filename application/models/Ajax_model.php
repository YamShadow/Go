<?php

class Ajax_model extends CI_Model {

    function __construct(){
        $cpt = func_num_args();
        $args = func_get_args();
        switch($cpt){
                case '0':
                    parent::__construct();
                    break;
                case '1':
                    parent::__construct();
                    break;
            }
    }
            
    /***** Fonctions principales *****/

}