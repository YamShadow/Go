<?php

class Groupe_model extends CI_Model {
    /* Un groupe de pierres.
        Il a des libertés, etc.
        Un raccourci pour tuer les pierres qui sont comprises dedans.
    */
    private $pierres = array();

    public function merge() {
        // Permet de fusionner avec un autre groupe
    }

    public function die() {
        foreach ($pierres as $p) {
            $p->die();
        }
    }
}