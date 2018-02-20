# Go
Projet du cours de POO en PHP.

Intervenant : Laurent Desjardins.

Groupe :
- Florian RAMBUR
- Mathieu NIBAS
- Jordan JUVENTIN

## Getting Started
PHP 7.x requis.  
Créer une base de données nommée \`go\`. (Un dump sous format SQL se trouve dans `/dump`)  
Modifier le fichier `/surcouche/data/client.json` (notamment pour les paramètres BDD et le `base_url/git`).  
  
Voir les règles du go : https://fr.wikipedia.org/wiki/R%C3%A8gles_du_go.  
  
On a utilisé le Design pas terne MVC à travers le framework CodeIgniter.  
On s'est inspiré de Observer aussi, notamment pour le transit des infos au sein de la logique.  
On a cependant dû improviser au vu de l'impossibilité de stocker un objet en session PHP.

## Précisions sur le rendu
Vous vous rendrez sûrement compte, en testant le code, que tout ne fonctionne pas.  
Néanmoins, toute la logique est implémentée dans le code. Le bug n'est pas fatal, il manque simplement la fonctionnalité.  
  
J'ai dû procéder à une arnaque pour contourner le problème d'objets en session en faisant, simplement, une nouvelle instance de Goban à chaque appel AJAX à partir de 2 arrays qui, leux, sont stockés en mémoire. C'est moche, niveau algorithmique, mais ça fonctionne =P  
  
De fait, on passe, pour récupérer le goban, de :  
	`$goban = $this->session->goban;`  
à :  
	`$goban = new Goban_Model($this->session->goban, $this->session->groupes);`

## TODO
### Pour le Front
Il faudrait cacher les bords du goban.

### Pour le Back

Il manque l'algo pour calculer les points (je l'ai déjà en tête, mais je ne peux pas l'écrire maintenant puisque plus assez de temps). Je vais de fait l'écrire en français ici :  
  
```
On va, pour chaque groupe, parcourir ses libertés une à une.  
Pour chaque liberté que l'on croise, on initialise un compteur. On va parcourir les intersections adjacentes et :  
 - Si on tombe sur la couleur du groupe, on ne fait rien,
 - Si on tombe sur la couleur adverse, on break avec le compteur à 0.
 - Si on tombe sur une autre liberté, on incrémente le compteur et on fait le même traitement sur cette liberté.
  
On va sauter les libertés qui ont déjà été parcourues avec ces appels et retourner la somme des compteurs obtenus.  
  
A la fin de cet algorithme, on aura :
 - Des compteurs qui donneront le nombres de points de territoire tenus par le groupe sur lequel il s'applique (il n'y a qu'à faire les sommes par couleur)
 - Des territoires qui n'ont pas de couleur parce qu'ils sont bordés par noir ET blanc (seki)
```