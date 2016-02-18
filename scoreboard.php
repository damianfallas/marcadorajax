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

            $("#flipcounter-score-red,#flipcounter-score-blue,#flipcounter-game").flipCounterInit();


            function getData() {

                $.getJSON( 'php/score.json?v=' + Math.floor((Math.random() * 9999) + 1000) , {
                })
                .done(function( data ) {

                    if(parseInt(data['stamp']) > parseInt(timestamp)) {
                        timestamp = data['stamp'];
                        
                        $("#flipcounter-score-red").flipCounterUpdate(data['score-red']);
                        $("#flipcounter-score-blue").flipCounterUpdate(data['score-blue']);

                        $('#fouls-red').val(data['fouls-red']);
                        $('#score-blue').val(data['score-blue']);
                        $('#fouls-blue').val(data['fouls-blue']);
                    }
              });
            }

        })
    </script>




        <script type="text/javascript">
        // Make the flip counter
        $("#flipcounter").flipCounterInit({'speed': 0.01});

        var startTime = new Date().getTime();

        // Update values
        function updateLoop() {
            var elapsedTime = new Date().getTime() - startTime;
            $("#flipcounter").flipCounterUpdate(elapsedTime);
            window.setTimeout(function() {
                updateLoop();
            }, 43);
        }

        // do it!
        updateLoop();
    </script>



    
</head>
<body>



    <div class="pure-g">
        <div class="pure-u-1-2">
            <div id="flipcounter-score-red" style="text-align: center;">0</div>
            REDs
        </div>
        <div class="pure-u-1-2">
            <div id="flipcounter-score-blue" style="text-align: center;">0</div>
            BlUEs
        </div>
    </div>
    <div class="pure-g">
        <div class="pure-u-1">
            <div id="flipcounter-game" style="text-align: center;">0</div>
            GAME
        </div>
    </div>

</body>
</html>
