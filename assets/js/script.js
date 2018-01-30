$(function () {
    var player = true;

    $('.case').on('click', function (e) {
        play(e.currentTarget.id);
    });

    function play(pos) {
        // CALL AJAX
        var data = {
            pos: pos,
            player: (player) ? 'black' : 'white'
        }

        $.ajax({
            url: base_url+'index.php/AjaxController/index',
            type: 'POST',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: data,
            success: function(data) {
                console.log(data);        
            },
            error: function(statut, erreur) {
                $('#error').html('Error');
            }   
        });
        // On success :
            // Si pas erreur : playStone
            // Si erreur : rien

        // Si on doit supprimer des pierres :
            // On boucle sur l'ensemble des pierres à supprimer
            // removeStone 


        playStone(pos);

        // RETOUR DE AJAX :
            /*
                Envoi :
                {
                    pos: '@int_@int',
                    player: 'black' / 'white'
                }

                Réception :
                {
                    etat: 'ok' / 'nok',
                    message: 'ok' / @error,
                    put: {
                        x: @int,
                        y: @int
                    },
                    remove: [
                        {
                            x: @int,
                            y: @int
                        },
                        {
                            @@ BIS REPETITAM @@
                        }
                    ],
                    count_white: @int,
                    count_black: @int
                }



            */

        // Ecrire les pierres mangées par chaque joueur
        
        // On change de joueur
        switchPlayer();

        // On error :
            // Rien
    }

    // function playStone(x, y) {
    //     var pos = '#'+x+'_'+y;

    //     $(pos).toggleClass('pre-stone').toggleClass('stone');
    // }

    function playStone(pos) {
        $('#'+pos+' i').toggleClass('pre-stone stone');
        // $('#'+pos+' i').toggleClass('stone');
    }

    // function removeStone(x, y) {
    //     var pos = '#'+x+'_'+y;

    //     $(pos).toggleClass('pre-stone stone');
    //     $(pos).removeClass('black').removeClass('white');

    //     if (player)
    //         $(pos).addClass('black');
    //     else
    //         $(pos).addClass('white');
    // }

    function removeStone(pos) {
        $('#'+pos).toggleClass('pre-stone').toggleClass('stone');
        $('#'+pos).removeClass('black').removeClass('white');

        if (player)
            $('#'+pos).addClass('black');
        else
            $('#'+pos).addClass('white');
    }

    function switchPlayer() {
        player = !player;
        $('.pre-stone').toggleClass('black').toggleClass('white');
    }
});