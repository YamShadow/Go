<?php

class Goban_model extends CI_Model {

        /* Contient une collection de groupes de pierres.
            Il faut pouvoir en appeler, en supprimer, en merge, ...
        */

    private $groupes = array();

    public function merge(Groupe_model $g1, Group_model $g2) {
        // Permet de fusionner $g1 et $g2
    }

    public function getGroupe($position) {
        // Renvoie le groupe associé à l'intersection qui se trouve à $position
    }
}