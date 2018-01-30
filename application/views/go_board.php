<div id="goban">
    <table>
        <?php
            $str = '';
            
            for ($i = 0 ; $i<$size_goban ; $i++) {
                $str .= '<tr>';
                for ($j = 0 ; $j<$size_goban ; $j++) {
                    $str .= '<td id="'.$i.'_'.$j.'" class="case"><i class="fa fa-lg fa-circle pre-stone black"></i></td>';
                }
                $str .= '</tr>';
            }
            echo $str;
        ?>
    </table>

    <div id="error"></div>
</div>

<script>
    var base_url = "<?php echo base_url(); ?>";
</script>