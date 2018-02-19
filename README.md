# Go
Groupe :
- Florian RAMBUR
- Mathieu NIBAS
- Jordan JUVENTIN

## Getting Started
PHP 7.x requis.
Créer une base de données nommée `go`.
Modifier le fichier /surcouche/data/client.json (notamment pour les paramètres BDD et le base_url/git).

Voir les règles du go : https://fr.wikipedia.org/wiki/R%C3%A8gles_du_go.

On a utilisé le Design pas terne MVC. On s'est inspiré de Observer aussi, notamment pour le transit des infos au sein de la logique.

## TODO
### Pour le Front
Il faut modifier le calback de réception de l'AJAX pour qu'il prenne en compte le format convenu (dans les commentaires).
Il faut, si possible, cacher les bords du goban.
Il faut afficher un kô. Il s'agirait de mettre un triangle sur la case concernée et de virer la class .pre-stone pour que le hover ainsi que l'event listener ne fonctionnent pas.
Il faut, de fait, prévoir de pouvoir supprimer un kô.


### Pour le Back

L'arnaque moldave a fonctionné. J'ai contourné le problème d'objet en session en faisant, simplement, une nouvelle instance de Goban à chaque appel AJAX partir d'un array qui, lui, est stocké en mémoire. C'est moche, niveau algorithmique, mais ça fonctionne =P

De fait, on passe, pour récupérer le goban, de :
	`$goban = $this->session->goban;`
à :
	`$goban = new Goban_Model($this->session->goban);`



Débugger pour la fonction play().
Il faudra faire l'algo, lorsque tout ça sera réglé, pour calculer les points (je l'ai déjà en tête, mais je ne peux pas l'écrire atm puisque bug).


PENSER A COMMENTER LE CODE