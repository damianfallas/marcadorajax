<!doctype html>
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
                    'score-red':  $('#score-red').val(),
                    'fouls-red':  $('#fouls-red').val(),
                    'score-blue': $('#score-blue').val(),
                    'fouls-blue': $('#fouls-blue').val(),
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

        <form class="pure-form pure-form-aligned">
            <fieldset>
                <div class="pure-control-group">
                    <label for="score-red">Score Red</label>
                    <input id="score-red" type="number" placeholder="" value="0">
                </div>

                <div class="pure-control-group">
                    <label for="fouls-red">Fouls Red</label>
                    <input id="fouls-red" type="number" placeholder="" value="0">
                </div>
            </fieldset>

            <fieldset>
                <div class="pure-control-group">
                    <label for="score-blue">Score Blue</label>
                    <input id="score-blue" type="number" placeholder="" value="0">
                </div>

                <div class="pure-control-group">
                    <label for="fouls-blue">Fouls Blue</label>
                    <input id="fouls-blue" type="number" placeholder="" value="0">
                </div>
            </fieldset>

            <fieldset>
                <div class="pure-control-group">
                    <label for="games">Games</label>
                    <input id="games" type="number" placeholder="" value="0">
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
