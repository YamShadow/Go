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
Il faut faire le calback de réception de l'AJAX. 
Il faut, si possible, cacher les bords du goban.

### Pour le Back
Créer les classes et la logique

Il faudra faire attention, car dans les modèles, les méthodes sont implémentées en prenant un paramètre $position. Or, ne sachant quelle forme prendrait ce paramètre, je ne l'ai pas parsé. Il faudra donc le faire lorsque le format aura été posé.
Pour le moment : $position = array('x' => $x, 'y' => $y);

PENSER A COMMENTER LE CODE