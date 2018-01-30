<main>
    <div>
        <p>
            <i class="fa fa-circle black" aria-hidden="true"></i> Pierres capturées : <span id="score-j1">0</span>
        </p>
    </div>

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
    </div>

    <div>
        <p>
            <i class="fa fa-circle white" aria-hidden="true"></i> Pierre capturées : <span id="score-j2">0</span>
        </p>
    </div>
</main>
<div id="error"></div>

<script>
    var base_url = "<?php echo base_url(); ?>";
</script>