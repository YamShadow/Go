<?php

require_once('Intersection_model.php');

class Groupe_model {
    /* Un groupe de pierres.
        Il a des libertés, etc.
        Un raccourci pour tuer les pierres qui sont comprises dedans.
    */
    
    private $pierres = array();
    private $libertes = array();

    public function __construct(Goban_model $goban, Intersection_model $stone = null) {
        if ($stone != null) {
            $this->pierres[] = $stone;
    
            $stone->setGroup($this);
    
            $libs = $stone->getLiberties($goban);
            foreach ($libs as $lib) {
                $this->libertes[] = $lib->getPosition();
            }
        }
    }

    public function merge(Groupe_model $g) {
        if ($g == null) return false;
        // Permet de fusionner avec un autre groupe
        foreach($g->getStones() as $stone) {
            $stone->setGroup($this);
        }
        
        $this->pierres = array_unique(array_merge($this->pierres, $g->getStones()), SORT_REGULAR);
        $this->libertes = array_unique(array_merge($this->libertes, $g->getLiberties()), SORT_REGULAR);

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

    public function updateLiberties(Goban_model $goban) {
        foreach ($this->pierres as $stone) {
            $libs = $stone->getLiberties($goban);
            foreach ($libs as $lib) {
                $this->libertes[] = $lib->getPosition();
            }
            $this->libertes = array_unique($this->libertes, SORT_REGULAR);
        }
    }

    public function isInGroupe($position) {
        foreach ($this->pierres as $pierre) {
            if ($pierre->hasPosition($position)) return true;
        }
        return false;
    }

    public function hasInLiberties($position) {
        foreach ($this->libertes as $pierre) {
            if ($pierre == $position) return true;
        }
        return false;
    }

    public function unsetKoo() {
        foreach ($this->pierres as $stone) {
            if ($stone->unsetKoo()) return true;
        }
    }

    public function die() {
        foreach ($this->pierres as $p) {
            $p->die();
        }
    }
}