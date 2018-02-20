<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Methode log qui permet de crée un log
 * * @param $message
*/
function logGo($message){

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