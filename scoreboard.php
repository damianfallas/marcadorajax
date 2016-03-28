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

    <script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
    <script type="text/javascript" src="js/jstween-1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.flipcounter.js"></script>
    <script type="text/javascript" src="js/jquery.runner-min.js"></script>
    <script type="text/javascript" src="js/jquery.newsTicker.js"></script>

    <script type="text/javascript">
        var timestamp = "0";

        $( document ).ready(function() {
            $.ajaxSetup({ cache:false });
            $("#flipcounter-score-red,#flipcounter-score-blue,#flipcounter-fouls-red,#flipcounter-fouls-blue").flipCounterInit({zeroFill: 2});
            $("#flipcounter-games").flipCounterInit();

            getData(true)
            setInterval(function(){ getData(false); }, 500);

            function getData(init) {

                $.getJSON( 'php/score.json?v=' + Math.floor((Math.random() * 9999) + 1000) , {
                })
                .done(function( data ) {
                    console.log(timestamp);

                    if(parseInt(data['stamp']) > parseInt(timestamp)) {
                        console.log(data['update-mode']);

                        timestamp = data['stamp'];

                        if ((data['update-mode'] == 'data' || init)) {
                            console.log('data update');
                            
                            $("#flipcounter-score-red").flipCounterUpdate(data['score-red']);
                            $("#flipcounter-score-blue").flipCounterUpdate(data['score-blue']);

                            $("#flipcounter-fouls-red").flipCounterUpdate(data['fouls-red']);
                            $("#flipcounter-fouls-blue").flipCounterUpdate(data['fouls-blue']);

                            $("#flipcounter-games").flipCounterUpdate(data['games']);

                            if(data['led-mode'] == "led-mode-message") {

                                var messages = data['led-message'].split("\n");
                                var ul = $('<ul />');
                                $.each(messages, function(i){
                                    //alert(messages[i]);
                                    $('<li/>').text(messages[i]).appendTo(ul);
                                });
                                $("#led-message").html(ul);
                                $("#led-message").show();


                                $("#led-message ul").newsTicker({
                                    row_height:  $("#led-message ul").height(),
                                    duration: 1000,
                                    max_rows: 1,
                                });


                                if($('#led-message ul li').length <= 1) {
                                    $("#led-message ul").newsTicker('stop');
                                } else {
                                    $("#led-message ul").newsTicker('start');
                                }

                                $("#led-watch").hide();

                            } if(data['led-mode'] == "led-mode-watch") {

                                $("#led-watch").remove();
                                $(".ledboard").append('<div id="led-watch"></div>');


                                $("#led-message").html(data['led-message']).hide();
                                $("#led-watch").show();
                                $('#led-watch').removeClass('blink');

                                $('#led-watch').runner({
                                    countdown: true,
                                    startAt: data['led-time'],
                                    autostart: false,
                                    stopAt: 30 * 1000,
                                    format: function(value) {
                                        var ms = value % 1000;
                                        value = (value - ms) / 1000;
                                        var secs = value % 60;
                                        value = (value - secs) / 60;
                                        var mins = value % 60;
                                        var hrs = (value - mins) / 60;
                                        ms = (ms > 99)? parseInt(ms/10) : ms;
                                        return pad2(hrs) + ':' + pad2(mins) + ':' + pad2(secs) + '.' + pad2(ms);
                                    }
                                }).on('runnerFinish', function(eventObject, info) {
                                    $('#led-watch').addClass('blink');
                                });

                            }

                            $('#fouls-red').val(data['fouls-red']);
                            $('#fouls-blue').val(data['fouls-blue']);

                        }
                        if (data['update-mode'] == 'state' || init) {
                            console.log('data:' + data['data']);
                            console.log('value:' +data['value']);

                            if (data['data']=='lights') {
                                if(data['value']!='true') {
                                    turnon();
                                } else {
                                    turnoff();
                                }
                            }

                            if (data['data']=='swatch-action') {
                                if(data['value']=='start') {
                                    $('#led-watch').runner('start');
                                }
                                if(data['value']=='pause') {
                                    $('#led-watch').runner('stop');
                                }
                                if(data['value']=='reset') {
                                    $('#led-watch').runner('reset');
                                }
                            }
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
            
            function pad2(number) { 
                return (number < 10 ? '0' : '') + number; 
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

        <div class="pure-u-1 ledboard">
            <div id="led-message"></div>
            <div id="led-watch"></div>
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