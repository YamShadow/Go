<?php

class Intersection_model extends CI_model {

        /* Représente la pierre en elle-même.
            Elle sait ce qu'elle est.
            Elle sait si elle doit mourir, et renvoie les infos nécessaires à goban qui l'appelle.
            Elle possède un Groupe, qui est de type Groupe_model.
        */
        
    private $position;      // Un array contenant x et y (int)
    private $color = null;
    private $isKoo = false;
    private $groupe = null;

    public function __construct($position, $color) {
        $this->load->library('session');
        $this->position = $position;
        $this->color = $color;
    }

    public function play($color) {
        // Toute la logique de pose de pierre
        $ret = array();
        $goban = new Goban_Model($this->session->goban);

        if ($this->color == null) {     // Si aucune pierre n'est posée ici
            if (!$this->isKoo) {        // Si on est pas en kô
                
                // La pierre est affectée à un groupe vide
                $goban->addGroupe($this);
                
                if (!empty($this->getLiberties()) || !empty($this->canKill())) {        // Si on a une liberté en jouant ici ou si on tue
                    $kills = $this->canKill();

                    // La pierre est jouée
                    $ret['put'] = $this->position;
                    $this->color = $color;

                    // On merge la pierre avec les autres groupes qui l'entourent et qui ont la même couleur
                    // On cherche les groupes autour de la pierre par rapport à sa position
                    if (($s = $goban->getStone(['x' => ($this->position['x']-1), 'y' => $this->position['y']])) && $s->isStone($color)) 
                        $goban->merge($this->groupe, $s->getGroup());

                    if (($s = $goban->getStone(['x' => ($this->position['x']+1), 'y' => $this->position['y']])) && $s->isStone($color))
                        $goban->merge($this->groupe, $s->getGroup());

                    if (($s = $goban->getStone(['x' => $this->position['x'], 'y' => ($this->position['y']-1)])) && $s->isStone($color))
                        $goban->merge($this->groupe, $s->getGroup());
                    
                    if (($s = $goban->getStone(['x' => $this->position['x'], 'y' => ($this->position['y']+1)])) && $s->isStone($color))
                        $goban->merge($this->groupe, $s->getGroup());


                    // On a posé la pierre, donc on tue les groupes (et on compte les pierres mortes)
                    $deathCounter = 0;
                    $ret['remove'] = array();
                    foreach ($kills as $groupToKill) {
                        $deathCounter += $groupToKill->getStoneNbr();
                        $ret['remove'] = array_merge($ret['remove'], $groupToKill->getAllPositions());
                        $groupToKill->die();
                    }

                    // Virer tous les autres kô précédents s'il y avait
                    $goban->unsetKoo();

                    // Puis si notre pierre n'a tué qu'une pierre et est à présent un groupe unitaire avec une seule liberté, c'est qu'on est en kô
                    if (($deathCounter == 1) && ($this->groupe->getStoneNbr() == 1) && ($this->groupe->getLibertyNbr() == 1)) {
                        $this->getLiberties()[0]->setKoo();
                        $ret['koo'] = $this->getLiberties()[0]->getPosition();
                    }

                    // Ajouter les pierres tuées au compteur du joueur
                    if ($color == 'blanc')
                        $_SESSION['pierreJ2'] += $deathCounter;
                    else
                        $_SESSION['pierreJ1'] += $deathCounter;

                    $ret['count_black'] = $_SESSION['pierreJ1'];
                    $ret['count_white'] = $_SESSION['pierreJ2'];
                    
                    
                    // Sauvegarder le coup dans la BDD
                    $this->partie->saveCoup($this->position['x'], $this->position['y']);
                    
                    $ret['etat'] = 'ok';

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

    public function isStone($color = null) {
        if ($color == null)
            return $this->color != null;
        else 
            return $this->color == $color;
    }

    public function setKoo() {
        $this->isKoo = true;
    }

    public function unsetKoo() {
        if ($this->isKoo) {
            $this->isKoo = false;
            return true;
        }
    }

    public function getLiberties() {
        $libertes = array();
        $goban = new Goban_Model($this->session->goban);

        // On cherche les libertés de la pierre par rapport à sa position
        if (($s = $goban->getStone(['x' => ($this->position['x']-1), 'y' => $this->position['y']])) && !$s->isStone())
            $libertes[] = $s->getPosition();

        if (($s = $goban->getStone(['x' => ($this->position['x']+1), 'y' => $this->position['y']])) && !$s->isStone())
            $libertes[] = $s->getPosition();

        if (($s = $goban->getStone(['x' => $this->position['x'], 'y' => ($this->position['y']-1)])) && !$s->isStone())
            $libertes[] = $s->getPosition();
        
        if (($s = $goban->getStone(['x' => $this->position['x'], 'y' => ($this->position['y']+1)])) && !$s->isStone())
            $libertes[] = $s->getPosition();

        return $libertes;
    }

    public function canKill() {
        // Renvoie les groupes que peut tuer la pierre en étant jouée ici
        $ret = array();
        $goban = new Goban_Model($this->session->goban);

        $groupesWithThatLiberty = $goban->getGroupesFromLiberty($this);

        foreach($groupesWithThatLiberty as $groupe) {
            // Si le groupe n'a qu'une liberté, c'est que c'est celle-ci donc que ça peut tuer
            if (sizeof($groupe->getLiberties()) == 1) $ret[] = $groupe;
        }

        return $ret;
    }

    public function die() {
        $this->color = null;
        $this->groupe = null;
    }

    public function setColor($color) {
        $this->color = $color;
    }

    public function setGroup(Groupe_model $groupe) {
        $this->groupe = $groupe;
    }

    public function getGroup() {
        return $this->groupe;
    }
}