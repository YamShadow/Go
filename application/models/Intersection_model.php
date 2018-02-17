<?php
require_once('Groupe_model.php');

class Intersection_model extends CI_Model {

        /* Représente la pierre en elle-même.
            Elle sait ce qu'elle est.
            Elle sait si elle doit mourir, et renvoie les infos nécessaires à goban qui l'appelle.
            Elle possède un Groupe, qui est de type Groupe_model.
        */
        
    private $position;      // Un array contenant x et y (int)
    private $color = null;
    private $isKoo = false;
    private $groupe = null;

    public function __construct($position) {
        $this->position = $position;
    }

    public function play($color) {
        // Toute la logique de pose de pierre
        $ret = array();
        $goban = $this->load->session('goban');

        if ($this->color == null) {     // Si aucune pierre n'est posée ici
            if (!$this->isKoo) {        // Si on est pas en kô
                if (!empty($this->getLiberties()) || !empty($this->canKill())) {        // Si on a une liberté en jouant ici ou si on tue
                    $ret['put'] = $this->position;
                    $this->color = $color;

                    // Suite du traitement

                    // On a posé la pierre, donc on va tuer les groupes
                    // Puis si notre pierre n'a tué qu'une pierre et est à présent un groupe unitaire avec une seule liberté
                    // C'est qu'on est en kô

                    // Il faut donc tuer les pierres, compter le kô (en virant tous les autres kô précédent s'il y avait)
                    // Ajouter les pierres tuées au compteur du joueur
                    // Sauvegarder le coup dans la BDD

                    // Et faire le return en AJAX

                } else {
                    $ret['etat'] = 'nok';
                    $ret['message'] = 'Coup suicidaire.';
                }

            } else {
                $ret['etat'] = 'nok';
                $ret['message'] = 'Case en kô.';
            }

        } else {
            $ret['etat'] = 'nok';
            $ret['message'] = 'Case occupée.';
        }

        return $ret;
    }
    
    public function hasPosition($position) {
        return (($this->position['x'] == $position['x']) && ($this->position['y'] == $position['y']));
    }

    public function getPosition() {
        return $this->position;
    }

    public function isStone() {
        return !($this->color == null);
    }

    public function setKoo() {
        $this->isKoo = true;
    }
    
    public function unsetKoo() {
        $this->isKoo = false;
    }

    public function getLiberties() {
        $libertes = array();
        $goban = $this->load->session('goban');

        // On cherche les libertés de la pierre par rapport à sa position
        if ($goban->getStone(['x' => ($this->position['x']-1), 'y' => $this->position['y']])->isStone())
            $libertes[] = ['x' => ($this->position['x']-1), 'y' => $this->position['y']];

        if ($goban->getStone(['x' => ($this->position['x']+1), 'y' => $this->position['y']])->isStone())
            $libertes[] = ['x' => ($this->position['x']+1), 'y' => $this->position['y']];

        if ($goban->getStone(['x' => $this->position['x'], 'y' => ($this->position['y']-1)])->isStone())
            $libertes[] = ['x' => $this->position['x'], 'y' => ($this->position['y']-1)];
        
        if ($goban->getStone(['x' => $this->position['x'], 'y' => ($this->position['y']+1)])->isStone())
            $libertes[] = ['x' => $this->position['x'], 'y' => ($this->position['y']+1)];

        return $libertes;
    }

    public function canKill() {
        // Renvoie les groupes que peut tuer la pierre en étant jouée ici
        $ret = array();
        $goban = $this->load->session('goban');

        $groupesWithThatLiberty = $goban->hasInLiberties();

        foreach($groupesWithThatLiberty as $groupe) {
            // Si le groupe n'a qu'une liberté, c'est que c'est celle-ci donc que ça peut tuer
            if (sizeof($groupe->getLiberties) == 1) $ret[] = $groupe;
        }

        return $ret;
    }

    public function die() {
        $this->color = null;
    }

    public function setColor($color) {
        $this->color = $color;
    }
}