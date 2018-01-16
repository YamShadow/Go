<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jeu de Go</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div id="goban">
        <table>
            <?php
                $str = '';
                
                for ($i = 0 ; $i<19 ; $i++) {
                    $str .= '<tr>';
                    for ($j = 0 ; $j<19 ; $j++) {
                        $str .= '<td id="'.$i.'.'.$j.'"></td>';
                    }
                    $str .= '</tr>';
                }

                echo $str;
            ?>
        </table>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/script.js"></script>
</body>
</html>