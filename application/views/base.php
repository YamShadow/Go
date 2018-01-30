<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jeu de Go</title>

    <?php 
        function toAbsolute($link) {
            $regex = '#^https?:\/\/#i';

            if (preg_match($regex, $link)) return $link;
            else return base_url('assets/'.$link);
        }

        if (isset($header['css'])) {
            foreach ($header['css'] as $css) {
                
                echo '<link rel="stylesheet" href="'.toAbsolute($css).'">';
            }
        }

        if (isset($header['js'])) {
            foreach ($header['js'] as $js) {
                echo '<script src="'.toAbsolute($js).'"></script>';
            }
        }
    ?>
</head>
<body>
    <?php 

        if (isset($body)) {
            include($body.'.php');
        }

        if (isset($footer['js'])) {
            foreach ($footer['js'] as $js) {
                echo '<script src="'.toAbsolute($js).'"></script>';
            }
        }
    ?>
</body>
</html>