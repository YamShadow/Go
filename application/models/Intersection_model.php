<?php

class Intersection_model extends CI_Model {

        /* Représente la pierre en elle-même.
            Elle sait ce qu'elle est.
            Elle sait si elle doit mourir, et renvoie les infos nécessaires à goban qui l'appelle.
            Elle possède un Groupe, qui est de type Groupe_model.
        */
        
    private $position;
    private $color = null;
    private $isKoo = false;
    private $groupe = array();
    private $libertes = array();

    public function __construct($position) {
        $this->position = $position;
    }

    public function play($color) {
        // Toute la logique de pose de pierre

        if ($this->color == null) {     // Si aucune pierre n'est posée ici
            if (!$this->isKoo) {        // Si on est pas en kô
                // Reste de la logique
            } else {
                $ret = array(
                    'etat' => 'nok',
                    'message' => 'Case en kô.'
                );
                return $ret;
            }
        } else {
            $ret = array(
                'etat' => 'nok',
                'message' => 'Case occupée.'
            );
            return $ret;
        }
    }
    
    public function hasPosition($position) {
        return $this->position == $position;
    }

    public function setKoo() {
        $this->isKoo = true;
    }
    
    public function unsetKoo() {
        $this->isKoo = false;
    }

    public function die() {
        $this->color = null;
    }
}