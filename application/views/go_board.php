<div id="goban">
    <table>
        <?php
            $str = '';
            
            for ($i = 0 ; $i<$size_goban ; $i++) {
                $str .= '<tr>';
                for ($j = 0 ; $j<$size_goban ; $j++) {
                    $str .= '<td id="'.$i.'.'.$j.'"></td>';
                }
                $str .= '</tr>';
            }
            echo $str;
        ?>
    </table>
</div>