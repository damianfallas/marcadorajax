<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Scoreboard update.">

    <title>Scoreboard</title>

    <link rel="stylesheet" href="css/pure/pure-min.css">
    <link rel="stylesheet" href="css/layouts/scoreboard.css">
    <link rel="stylesheet" href="css/pure/grids-responsive-min.css">
    <link rel="stylesheet" href="css/jquery.flipcounter.css">

    <script src="js/jquery-2.2.0.min.js"></script>
    <script type="text/javascript" src="js/jstween-1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.flipcounter.js"></script>

    <script type="text/javascript">
        var timestamp = "0";

        $( document ).ready(function() {
            getData()
            setInterval(function(){ getData(); }, 500);

            $("#flipcounter-score-red,#flipcounter-score-blue,#flipcounter-fouls-red,#flipcounter-fouls-blue").flipCounterInit({zeroFill: 2});
            $("#flipcounter-games").flipCounterInit();

            function getData() {

                $.getJSON( 'php/score.json?v=' + Math.floor((Math.random() * 9999) + 1000) , {
                })
                .done(function( data ) {

                    if(parseInt(data['stamp']) > parseInt(timestamp)) {
                        timestamp = data['stamp'];
                        
                        $("#flipcounter-score-red").flipCounterUpdate(data['score-red']);
                        $("#flipcounter-score-blue").flipCounterUpdate(data['score-blue']);

                        $("#flipcounter-fouls-red").flipCounterUpdate(data['fouls-red']);
                        $("#flipcounter-fouls-blue").flipCounterUpdate(data['fouls-blue']);

                        $("#flipcounter-games").flipCounterUpdate(data['games']);

                        $('#fouls-red').val(data['fouls-red']);
                        $('#fouls-blue').val(data['fouls-blue']);

                        console.log(data['lights']);

                        if (data['lights']=='true') {
                            turnoff();
                        } else {
                            turnon();
                        }
                    }
              });
            }

            function turnon() {
                $('.light').fadeIn();
            }

            function turnoff() {
                $('.light').fadeOut();
            }

        })
    </script>
    
</head>
<body>
    <div class="light" style="display: none;"></div>
    <div class="pure-g">

        <!-- SCORES -->
        <div class="pure-u-1-3 red">
            <div id="flipcounter-score-red" style="text-align: center;">00</div>
        </div>
        <div class="pure-u-1-3">
            <img class="logolti" src="images/logolti.png">
        </div>
        <div class="pure-u-1-3">
            <div id="flipcounter-score-blue" style="text-align: center;">00</div>
        </div>


        <!-- TEXT and games -->
        <div class="pure-u-1-3 red">
            Rojo
        </div>
        <div class="pure-u-1-3">
            <div id="flipcounter-games" style="text-align: center;">0</div>
        </div>
        <div class="pure-u-1-3 blue">
            Azul
        </div>


        <!-- FOULS -->
        <div class="pure-u-1-4">
        </div>
        <div class="pure-u-1-2 fouls-panel">
            <div class="center">
                <div id="flipcounter-fouls-red" style="text-align: center;">00</div>
                <img src="images/kazoo.png" class="kazoo" />
                <div id="flipcounter-fouls-blue" style="text-align: center;">00</div>
            </div>
        </div>
        <div class="pure-u-1-4">
        </div>
    </div>
</body>
</html>