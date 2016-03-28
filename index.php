<?php

    @$file = file_get_contents("./php/score.json");
    @$var = json_decode($file, true);

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Scoreboard update.">

    <title>Scoreboard update</title>

    <link rel="stylesheet" href="css/pure/pure-min.css">
    <link rel="stylesheet" href="css/layouts/dashboard.css">
    <link rel="stylesheet" href="css/pure/grids-responsive-min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">

    <script src="js/jquery-2.2.0.min.js"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#btn-score-update").click(function(){
                $.post("php/score-update.php",
                {
                    'update-mode' : 'data',
                    'lights':  $('#lights').is(':checked'),
                    'score-red':  $('#score-red').val(),
                    'fouls-red':  $('#fouls-red').val(),
                    'score-blue': $('#score-blue').val(),
                    'fouls-blue': $('#fouls-blue').val(),
                    'led-mode': $('input[name=led-mode]:checked').val(),
                    'led-message': $('#led-message').val(),
                    'led-time': (parseInt($('#led-minutes').val()) * 60000) + (parseInt($('#led-seconds').val()) * 1000) + parseInt($('#led-millisecond').val()),
                    'games': $('#games').val()
                },
                function(data, status){
                    if(status != "success") {
                        alert("Data: " + data + "\nStatus: " + status);
                    }
                });
            });

            function sendState(data, value) {
                $.post("php/score-update.php",
                {
                    'update-mode' : 'state',
                    data:  data,
                    value:  value
                },
                function(data, status){
                    if(status != "success") {
                        alert("Data: " + data + "\nStatus: " + status);
                    }
                });
            }

            $("#lights").click(function() {
                if($('#lights i').hasClass('fa-toggle-off')) {
                    sendState('lights', true);
                    $('#lights i').removeClass('fa-toggle-off').addClass('fa-toggle-on');
                } else {
                    sendState('lights', false);
                    $('#lights i').removeClass('fa-toggle-on').addClass('fa-toggle-off');
                }
            });

            $("#btn-watch-start").click(function() {
                sendState('swatch-action', 'start');
            });

            $("#btn-watch-reset").click(function() {
                sendState('swatch-action', 'reset');
            });

            $("#btn-watch-pause").click(function() {
                sendState('swatch-action', 'pause');
            });

            $(".plus.pure-button").click(function() {
                steps = $(this).data('forsteps');
                steps = (steps)?steps:1;
                console.log(steps);
                elem = $( '#' + $(this).data('for') );
                elem.val(parseInt(elem.val()) + steps);
            });
            $(".minus.pure-button").click(function() {
                steps = $(this).data('forsteps');
                steps = (steps)?steps:1;
                elem = $( '#' + $(this).data('for') );
                n = parseInt(elem.val()) - steps
                elem.val( (n<0)?0:n );
            });
        })
    </script>
    
</head>
<body>

    <div class="l-content">

        <div class="pure-menu pure-menu-horizontal">
            <ul class="pure-menu-list">
                <li class="pure-menu-item"><a href="scoreboard.php" class="pure-menu-link" target="_blank">Scoreboard</a></li>
            </ul>
        </div>

        <form class="pure-form pure-form-aligned">
            <fieldset class="red">
                <div class="pure-control-group">
                    <label for="score-red">Score Red</label>
                    <input id="score-red" type="number" placeholder="" value="<?php echo $var['score-red']; ?>">
                    <button type="button" data-for="score-red" class="plus pure-button pure-button-primary"><i class="fa fa-plus"></i></button>
                    <button type="button" data-for="score-red" class="minus pure-button pure-button-primary"><i class="fa fa-minus"></i></i></button>
                </div>

                <div class="pure-control-group">
                    <label for="fouls-red">Fouls Red</label>
                    <input id="fouls-red" type="number" placeholder="" value="<?php echo $var['fouls-red']; ?>">
                    <button type="button" data-for="fouls-red" class="plus pure-button pure-button-primary"><i class="fa fa-plus"></i></button>
                    <button type="button" data-for="fouls-red" class="minus pure-button pure-button-primary"><i class="fa fa-minus"></i></i></button>
                </div>
            </fieldset>

            <fieldset class="blue">
                <div class="pure-control-group">
                    <label for="score-blue">Score Blue</label>
                    <input id="score-blue" type="number" placeholder="" value="<?php echo $var['score-blue']; ?>">
                    <button type="button" data-for="score-blue" class="plus pure-button pure-button-primary"><i class="fa fa-plus"></i></button>
                    <button type="button" data-for="score-blue" class="minus pure-button pure-button-primary"><i class="fa fa-minus"></i></i></button>
                </div>

                <div class="pure-control-group">
                    <label for="fouls-blue">Fouls Blue</label>
                    <input id="fouls-blue" type="number" placeholder="" value="<?php echo $var['fouls-blue']; ?>">
                    <button type="button" data-for="fouls-blue" class="plus pure-button pure-button-primary"><i class="fa fa-plus"></i></button>
                    <button type="button" data-for="fouls-blue" class="minus pure-button pure-button-primary"><i class="fa fa-minus"></i></i></button>
                </div>
            </fieldset>

            <fieldset class="">
                <div class="pure-control-group">
                    <label for="led-mode">LED board Mode</label>
                    <label for="led-mode-message" class="pure-radio">
                        <input id="led-mode-message" type="radio" name="led-mode" value="led-mode-message" checked>Text Scroll
                    </label>
                    <label for="led-mode-watch" class="pure-radio">
                        <input id="led-mode-watch" type="radio" name="led-mode" value="led-mode-watch">Stop Watch
                    </label>
                </div>
            </fieldset>

            <fieldset class="">
                <div class="pure-control-group">
                    <label for="led-message">LED board Message</label>
                    <textarea id="led-message" class="pure-input-1-4"><?php echo $var['led-message']; ?></textarea>
                </div>
            </fieldset>

            <fieldset class="">
                <div class="pure-control-group">
                    <label for="led-message">LED board Time</label>
                    <div class="pure-u-1-5">
                        <input id="led-minutes" type="number" placeholder="" value="00">
                        <button type="button" data-for="led-minutes" class="plus pure-button pure-button-primary"><i class="fa fa-plus"></i></button>
                        <button type="button" data-for="led-minutes" class="minus pure-button pure-button-primary"><i class="fa fa-minus"></i></i></button>
                    </div>
                    <div class="pure-u-1-5">
                        <input id="led-seconds" type="number" placeholder="" value="00">
                        <button type="button" data-for="led-seconds" class="plus pure-button pure-button-primary"><i class="fa fa-plus"></i></button>
                        <button type="button" data-for="led-seconds" class="minus pure-button pure-button-primary"><i class="fa fa-minus"></i></i></button>
                    </div>
                    <div class="pure-u-1-5">
                        <input id="led-millisecond" type="number" placeholder="" value="00">
                        <button type="button" data-for="led-millisecond" class="plus pure-button pure-button-primary"><i class="fa fa-plus"></i></button>
                        <button type="button" data-for="led-millisecond" class="minus pure-button pure-button-primary"><i class="fa fa-minus"></i></i></button>
                    </div>
                </div>
                <div class="pure-control-group">
                    <label for=""></label>
                    <button id="btn-watch-start" type="button" class="pure-button pure-button-primary"><i class="fa fa-play"></i></button>
                    <button id="btn-watch-pause" type="button" class="pure-button pure-button-primary"><i class="fa fa-pause"></i></button>
                    <button id="btn-watch-reset" type="button" class="pure-button pure-button-primary"><i class="fa fa-undo"></i></button>
                </div>
            </fieldset>

            <fieldset>
                <div class="pure-control-group">
                    <label for="games">Games</label>
                    <input id="games" type="number" placeholder="" value="<?php echo $var['games']; ?>">
                </div>
            </fieldset>

            <fieldset>
                <div class="pure-control-group">
                    <label for="lights">Light Switch</label>
                    <button id="lights" type="button" class="pure-button pure-button-primary pure-button-active"><i class="fa fa-toggle-on"></i></button>
                </div>
            </fieldset>

            <fieldset>
                <div class="pure-controls">
                    <button id="btn-score-update" type="button" class="pure-button pure-button-primary">Submit</button>
                </div>
            </fieldset>
        </form>


    </div> <!-- end l-content -->

</body>
</html>
