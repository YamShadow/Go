<?php

class Goban_model extends CI_Model {

        /* Contient une collection de groupes de pierres.
            Il faut pouvoir en appeler, en supprimer, en merge, ...
        */

    private $groupes = array();
    private $goban = array();

    public function __construct() {
        $cpt = func_num_args();
        $args = func_get_args();
        switch($cpt){
                case '0':
                    parent::__construct();
                    break;
                case '1':
                    parent::__construct();
                    $this->goban = $args[0];
                    break;
            }
    }

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
        // Renvoie les groupes qui comptent $position comme une de leurs libertés
        $ret = array();

        foreach ($groupes as $groupe) {
            if ($groupe->hasInLiberties($position)) $ret[] = $groupe;
        }

        return $ret;
    }

    public function unsetKoo() {
        foreach ($groupes as $groupe) {
            if ($groupe->unsetKoo()) return;
        }
    }

    public function addGroupe($stone) {
        $this->groupes[] = new Groupe_model($stone);
    }

    public function play($pos, $color) {
        // On reçoit la position sous form 'x_y', donc on doit la parser
        $regex = '#(\d+)_(\d+)#';
        $matches = array();

        $n = preg_match($regex, $ops, $matches);

        $position = array(
            'x' => $matches[1],
            'y' => $matches[2]
        );

        // On joue la pierre
        $ret = $goban[$position['x']][$position['y']]->play($color);

        return $ret;
    }
}