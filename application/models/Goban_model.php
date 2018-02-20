<?php

require_once('Groupe_model.php');

class Goban_model extends CI_model {

        /* Contient une collection de groupes de pierres.
            Il faut pouvoir en appeler, en supprimer, en merge, ...
        */

    private $groupes = array();
    private $goban = array();

    public function __construct($arrayGoban, $arrayGroupes) {
        $this->load->library('session');

        // On recrée le goban à partir de $arrayGoban
        foreach($arrayGoban as $i => $iitem) {
            foreach ($iitem as $j => $jitem) {
                $this->goban[$i][$j] = new Intersection_model($jitem['position'], $jitem['color']);
            }
        }

        // On recrée les groupes à partir de $arrayGroupes
        foreach($arrayGroupes as $i => $groupe) {
            $this->groupes[$i] = new Groupe_model($this);
            foreach($groupe as $stone) {
                // Pour chaque $stone qui est dans chaque $groupe (en vrai $stone = une position)
                // On crée un groupe et on merge avec ce qu'on a déjà
                $this->merge($this->groupes[$i], new Groupe_model($this, $this->getStone($stone)));
            }
        }

        logGo(sizeof($this->groupes));
    }

    public function merge(Groupe_model $g1, Groupe_model $g2) {
        // Permet de fusionner $g1 et $g2
        $g1->merge($g2);
    }

    public function getStone($position) {
        if (isset($this->goban[$position['x']][$position['y']]))
            return $this->goban[$position['x']][$position['y']];
        else return false;
    }

    public function putStone($position, $color) {
        if (isset($goban[$position['x']][$position['y']]))
            $goban[$position['x']][$position['y']]->setColor($color);
        else return false;
    }

    public function arroundIsOk($position, $color) {
        // Renvoie si une pierre de couleur $color avec plus d'une liberté entoure $position
        if (   (($s1 = $this->getStone(['x' => ($position['x']-1), 'y' => $position['y']])) && $s1->isStone($color) && (sizeof($s1->getLiberties($this)) > 1))
            || (($s2 = $this->getStone(['x' => ($position['x']+1), 'y' => $position['y']])) && $s2->isStone($color) && (sizeof($s2->getLiberties($this)) > 1))
            || (($s3 = $this->getStone(['x' => $position['x'], 'y' => ($position['y']-1)])) && $s3->isStone($color) && (sizeof($s3->getLiberties($this)) > 1))
            || (($s4 = $this->getStone(['x' => $position['x'], 'y' => ($position['y']+1)])) && $s4->isStone($color) && (sizeof($s4->getLiberties($this)) > 1))
           )
            return true;
        else return false;
    }

    public function getGroupeFromPos($position) {
        // Renvoie le groupe associé à l'intersection qui se trouve à $position
        foreach ($groupes as $groupe) {
            if ($groupe->isInGroupe($position)) return $groupe;
        }
        return null;
    }

    public function getGroupesFromLiberty($position, $color = null) {
        // Renvoie les groupes (de couleur $color si fourni) qui comptent $position comme une de leurs libertés
        $ret = array();

        foreach ($this->groupes as $groupe) {
            if ((($color == null) || ($groupe->getStones()[0]->isStone($color))) && $groupe->hasInLiberties($position)) {
                $ret[] = $groupe;
            }
        }

        return $ret;
    }

    public function updateLiberties() {
        foreach ($this->groupes as $groupe) {
            $groupe->updateLiberties($this);
        }
    }

    public function unsetKoo() {
        foreach ($this->groupes as $groupe) {
            if ($groupe->unsetKoo()) return;
        }
    }

    public function addGroupe($stone) {
        $this->groupes[] = new Groupe_model($this, $stone);
    }

    public function play($pos, $color) {
        // On reçoit la position sous form 'x_y', donc on doit la parser
        $regex = '#(\d+)_(\d+)#';
        $matches = array();

        $n = preg_match($regex, $pos, $matches);

        $position = array(
            'x' => $matches[1],
            'y' => $matches[2]
        );

        // On joue la pierre
        logGo(strtoupper($color).': Coup en ('.$position['x'].', '.$position['y'].')');
        $ret = $this->goban[$position['x']][$position['y']]->play($this, $color);

        if (!empty($this->groupes))
            $_SESSION['groupes'] = $this->getExportGroupes();
        
        if (isset($ret['put'])) {
            $_SESSION['goban'][$ret['put']['x']][$ret['put']['y']]['color'] = $color;
        }

        if (isset($ret['remove'])) {
            foreach($ret['remove'] as $remove) {
                $_SESSION['goban'][$remove['x']][$remove['y']]['color'] = null;
            }
        }

        return $ret;
    }

    public function getExportGroupes() {
        // Retourne un array contenant tous les groupes pour être stocké en session
        $ret = array();
        
        foreach ($this->groupes as $i => $groupe) {
            $ret[$i] = array();

            foreach($groupe->getStones() as $stone) {
                $ret[$i][]= $stone->getPosition();
            }
        }
        
        return $ret;
    }

    public function deleteGroupe(Groupe_model $groupe) {
        $groupe->die();
        unset($this->groupes[array_search($groupe, $this->groupes)]);
    }
}