<?php
/*
==========================================================================
          _--_
        .'    '.
        |      |
        |      |
         '.  .'
          |""|
          |  |
          |  |
          |  |
        |""""""|
        |      |
  ___.""""""""""""._.----._
 /                   """"  \
/_ __ __ __ ____ __ __ ___  ;
\                           ;
 \_________________________/  
==========================================================================

Version 0.1

 */
class Go_model extends CI_Model {

    function __construct(){
        parent::__construct();
    }

    /***** Fonctions principales *****/

   /**
     * Methode log qui permet de crée un log
     * @param $message
     */
    function log($message){
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) 
			$ip = $_SERVER['HTTP_CLIENT_IP'];
        elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) 
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else
			$ip = $_SERVER['REMOTE_ADDR'];
    
        $date = new DateTime('now', new DateTimeZone('Europe/Paris'));
        if(!is_dir(BASEPATH.'../logs/'))
			mkdir(BASEPATH.'../logs/', '750');
        $log = fopen(BASEPATH.'../logs/logs-'.date('dmY').'.txt', 'a+');
        $prepare = "[".$date->format('Y-m-d H:i:s')."] ".$ip." à l'adresse ".$_SERVER['PHP_SELF']."  - ".$message."\r\n";
        fputs($log, $prepare);
        fclose($log);

    }
}