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

    <script src="js/jquery-2.2.0.min.js"></script>

    <script type="text/javascript">
        $( document ).ready(function() {
            $("#btn-score-update").click(function(){
                $.post("php/score-update.php",
                {
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
                </div>

                <div class="pure-control-group">
                    <label for="fouls-red">Fouls Red</label>
                    <input id="fouls-red" type="number" placeholder="" value="<?php echo $var['fouls-red']; ?>">
                </div>
            </fieldset>

            <fieldset class="blue">
                <div class="pure-control-group">
                    <label for="score-blue">Score Blue</label>
                    <input id="score-blue" type="number" placeholder="" value="<?php echo $var['score-blue']; ?>">
                </div>

                <div class="pure-control-group">
                    <label for="fouls-blue">Fouls Blue</label>
                    <input id="fouls-blue" type="number" placeholder="" value="<?php echo $var['fouls-blue']; ?>">
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
                    <input id="led-message" type="text" placeholder="" value="<?php echo $var['led-message']; ?>">
                </div>
            </fieldset>

            <fieldset class="">
                <div class="pure-control-group">
                    <label for="led-message">LED board Time</label>
                    <input id="led-minutes" type="number" placeholder="" value="00">
                    <input id="led-seconds" type="number" placeholder="" value="00">
                    <input id="led-millisecond" type="number" placeholder="" value="00">
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
                    <input id="lights" type="checkbox" checked="<?php echo $var['lights']; ?>">
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
