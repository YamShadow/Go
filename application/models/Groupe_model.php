<?php

require_once('Intersection_model.php');

class Groupe_model extends CI_Model {
    /* Un groupe de pierres.
        Il a des libertés, etc.
        Un raccourci pour tuer les pierres qui sont comprises dedans.
    */
    
    private $pierres = array();

    public function merge(Groupe_model $g) {
        // Permet de fusionner avec un autre groupe
        $this->pierres = array_merge($this->getStones(), $g->getStones());
        unset($g);
    }

    public function getStones() {
        return $this->pierres;
    }

    public function isInGroupe($position) {
        foreach ($pierres as $pierre) {
            if ($pierre->hasPosition($position)) return true;
        }
        return false;
    }

    public function die() {
        foreach ($pierres as $p) {
            $p->die();
        }
    }
}