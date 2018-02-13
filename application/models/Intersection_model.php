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

        // Vérifier si c'est un kô, si il y a déjà une pierre, etc
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