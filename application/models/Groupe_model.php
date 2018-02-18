<?php

//require_once('Intersection_model.php');

class Groupe_model extends CI_Model {
    /* Un groupe de pierres.
        Il a des libertés, etc.
        Un raccourci pour tuer les pierres qui sont comprises dedans.
    */
    
    private $pierres = array();
    private $libertes = array();

    public function __construct() {
        $cpt = func_num_args();
        $args = func_get_args();
        switch($cpt){
                case '0':
                    parent::__construct();
                    break;
                case '1':
                    parent::__construct();
                    $this->pierres[] = $args[0];

                    $args[0]->setGroup($this);

                    $this->libertes = $args[0]->getLiberties();
                    break;
            }
    }

    public function merge(Groupe_model $g) {
        if ($g == null) return false;
        // Permet de fusionner avec un autre groupe
        $this->pierres = array_unique(array_merge($this->getStones(), $g->getStones()));
        $this->libertes = array_unique(array_merge($this->getLiberties(), $g->getLiberties()));

        foreach($g->getStones() as $stone) {
            $stone->setGroup($this);
        }

        unset($g);
    }

    public function getStones() {
        return $this->pierres;
    }

    public function getStoneNbr() {
        return sizeof($this->pierres);
    }

    public function getAllPositions() {
        $ret = array();
        foreach ($this->pierres as $stone) {
            $ret[] = $stone->getPosition();
        }
        return $ret;
    }

    public function getLiberties() {
        return $this->libertes;
    }

    public function getLibertyNbr(){
        return sizeof($this->libertes);
    }

    public function isInGroupe($position) {
        foreach ($pierres as $pierre) {
            if ($pierre->hasPosition($position)) return true;
        }
        return false;
    }

    public function hasInLiberties($position) {
        foreach ($libertes as $pierre) {
            if ($pierre->hasPosition($position)) return true;
        }
        return false;
    }

    public function unsetKoo() {
        foreach ($this->pierres as $stone) {
            if ($stone->unsetKoo()) return true;
        }
    }

    public function die() {
        foreach ($pierres as $p) {
            $p->die();
        }
        $this->__destruct();
    }
}