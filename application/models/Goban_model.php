<?php

require_once('Groupe_model.php');

class Goban_model extends CI_Model {

        /* Contient une collection de groupes de pierres.
            Il faut pouvoir en appeler, en supprimer, en merge, ...
        */

    private $groupes = array();
    private $goban = array();

    public function merge(Groupe_model $g1, Group_model $g2) {
        // Permet de fusionner $g1 et $g2
        $g1->merge($g2);
    }

    public function getStone($position) {
        if (isset($goban[$position['x']][$position['y']]))
            return $goban[$position['x']][$position['y']];
        else return false;
    }

    public function putStone($position, $color) {
        if (isset($goban[$position['x']][$position['y']]))
            $goban[$position['x']][$position['y']]->setColor($color);
        else return false;
    }

    public function getGroupeFromPos($position) {
        // Renvoie le groupe associé à l'intersection qui se trouve à $position
        foreach ($groupes as $groupe) {
            if ($groupe->isInGroupe($position)) return $groupe;
        }
    }

    public function getGroupesFromLiberty($position) {
        // Renvoie le groupe associé à l'intersection qui se trouve à $position
        $ret = array();

        foreach ($groupes as $groupe) {
            if ($groupe->hasInLiberties($position)) $ret[] = $groupe;
        }

        return $ret;
    }

    public function unsetKoo() {
        foreach ($goban as $pierre) {
            $pierre->unsetKoo();
        }
    }
}