$(function () {
    var player = true;

    $(document).on('click', '.pre-stone', function () {
        var pos = $(this).closest('.case').attr('id');
        play(pos);
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
            dataType: 'json',
            success: function(data) {
                if (data.etat == 'ok') {
                    removeKoo();
                    var msg = '';

                    if ('message' in data) 
                        msg += data.message+'<br>';

                    if ('put' in data) {
                        playStone(data.put.x, data.put.y);
                        msg += 'Played: ('+data.put.x+', '+data.put.y+')<br>';
                    }

                    if ('remove' in data) {
                        for (var stone of data.remove) {
                            msg += 'Removed: ('+stone.x+', '+stone.y+')<br>';
                            removeStone(stone.x, stone.y);
                        }
                    }

                    if ('koo' in data) {
                        isKoo(data.koo.x, data.koo.y);
                    }

                    if('count_black' in data) {
                        $('#score-j1').html(data.count_black);
                    } 
                    if('count_white' in data) {
                        $('#score-j2').html(data.count_white);
                    }

                    putSuccess(msg);
                    switchPlayer();
                } else 
                    putError(data);

                    putInfo(data);
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
            // Ne rien faire 
    }

    function playStone(x, y) {
        var pos = '#'+x+'_'+y+' i';
        $(pos).toggleClass('pre-stone stone');
    }
    
    function removeStone(x, y) {
        var pos = '#'+x+'_'+y+' i';
        $(pos).toggleClass('pre-stone stone');
        $(pos).removeClass('black white');
        
        if (player)
            $(pos).addClass('black');
        else
            $(pos).addClass('white');
    }

    function isKoo(x, y) {
        var pos = '#'+x+'_'+y+' i';
        $(pos).toggleClass('pre-stone koo');
        $(pos).toggleClass('fa-circle fa-square');
    }

    function removeKoo() {
        $('.koo').toggleClass('koo fa-square pre-stone fa-circle');
        $(pos).removeClass('black white');
        
        if (player)
            $(pos).addClass('black');
        else
            $(pos).addClass('white');
    }

    function switchPlayer() {
        player = !player;
        $('.pre-stone').toggleClass('black white');
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