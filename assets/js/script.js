$(function () {
    var player = true;

    $('.case').on('click', function (e) {
        play(e.currentTarget.id);
    });

    function play(pos) {
        // CALL AJAX
        var dataSent = {
            pos: pos,
            player: (player) ? 'black' : 'white'
        }
        
        $.ajax({
            url: base_url+'index.php/AjaxController/index',
            type: 'POST',
            contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
            data: dataSent,
            // dataType: 'json',
            success: function(data) {
                if (data.etat == 'ok') {
                    putInfo(data);
                    playStone(pos);
                    switchPlayer();
                } else 
                    putError(data);
            },
            error: function(statut, erreur) {
                putError(erreur);
            }   
        });
        // On success :
            // Si pas erreur : playStone
            // Si erreur : rien

        // Si on doit supprimer des pierres :
            // On boucle sur l'ensemble des pierres à supprimer
            // removeStone 



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
                    message: 'ok' / @string,
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
                    koo: {
                        x: @int,
                        y: @int
                    },
                    count_white: @int,
                    count_black: @int
                }



            */

        // Ecrire les pierres mangées par chaque joueur
        

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

    function putError(msg) {
        $('#msg').html(msg);
        $('#msg').removeClass('success info');
        $('#msg').addClass('error');
    }

    function putInfo(msg) {
        $('#msg').html(msg);
        $('#msg').removeClass('success error');
        $('#msg').addClass('info');
    }

    function putSuccess(msg) {
        $('#msg').html(msg);
        $('#msg').removeClass('info error');
        $('#msg').addClass('success');
    }
});