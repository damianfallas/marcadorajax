<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Scoreboard update.">

    <title>Scoreboard</title>

    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/layouts/scoreboard.css">
    <link rel="stylesheet" href="css/jquery.flipcounter.css">

    <script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
    <script type="text/javascript" src="js/jstween-1.1.min.js"></script>
    <script type="text/javascript" src="js/jquery.flipcounter.js"></script>
    <script type="text/javascript" src="js/jquery.runner-min.js"></script>
    <script type="text/javascript" src="js/jquery.newsTicker.js"></script>
    <script type='text/javascript' src='js/jquery.marquee.min.js'></script>

    <script type="text/javascript">
        var timestamp = "0";

        $( document ).ready(function() {
            $.ajaxSetup({ cache:false });
            $("#flipcounter-score-red,#flipcounter-score-blue,#flipcounter-fouls-red,#flipcounter-fouls-blue").flipCounterInit({zeroFill: 2});
            $("#flipcounter-games").flipCounterInit();
            $('#led-message').marquee();

            getData(true);
            setInterval(function(){ getData(false); }, 500);

            function getData(init) {

                $.getJSON( 'php/score.json', {
                })
                .done(function( data ) {
                    //console.log(timestamp);

                    if(parseInt(data['stamp']) > parseInt(timestamp)) {
                        console.log(data['update-mode']);

                        timestamp = data['stamp'];

                        //SCORE PANELS
                        if ((data['update-mode'] == 'score-update' || init)) {
                            $("#flipcounter-score-red").flipCounterUpdate(data['score-red']);
                            $("#flipcounter-score-blue").flipCounterUpdate(data['score-blue']);
                            $("#flipcounter-fouls-red").flipCounterUpdate(data['fouls-red']);
                            $("#flipcounter-fouls-blue").flipCounterUpdate(data['fouls-blue']);
                            $("#flipcounter-games").flipCounterUpdate(data['games']);
                        }

                        //LED MESSAGE
                        if (data['update-mode'] == 'led-message-update' || init) {

                            $("#led-message").html(data['led-message']);
                            $("#led-watch").hide();
                            $("#led-message").show();
                            $("#led-message").marquee();

                            /*
                            var messages = data['led-message'].split("\n");
                            //console.log(data['stamp']);
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
                            

                            $("#led-watch").hide();*/
                        }

                        //UPDATE TIME
                        if (data['update-mode'] == 'led-time-update' || init) {
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
                                    return pad2(mins) + ':' + pad2(secs) + '.' + pad2(ms);
                                }
                            }).on('runnerFinish', function(eventObject, info) {
                                $('#led-watch').addClass('blink');
                            });
                        } 

                        //DINAMIC
                        if (data['update-mode'] == 'state' || init) {
                            //console.log('data:' + data['data']);
                            //console.log('value:' +data['value']);

                            if (data['data']=='lights') {
                                if(data['value']!='true') {
                                    turnon();
                                } else {
                                    turnoff();
                                }
                            }

                            if (data['data']=='lights-logo') {
                                if(data['value']!='true') {
                                    turnlogoon();
                                } else {
                                    turnlogooff();
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

            function turnlogoon() {
                $('.light-logo').fadeIn();
            }

            function turnlogooff() {
                $('.light-logo').fadeOut();
            }
            
            
            function pad2(number) { 
                return (number < 10 ? '0' : '') + number; 
            }

        })
    </script>
    
</head>
<body>
    <div class="light" style="display: none;"></div>
    <div class="light-logo" style="display: none;"></div>
    <div class="container-fluid">

        <div class="row row-eq-height">
            
            <!-- SCORES -->
            <div class="col-xs-4 red">
                <div id="flipcounter-score-red">00</div>
                <p>ROJO</p>
            </div>
            <div class="col-xs-4">
                <p class="centertitle">MATCH DE IMPROVISACI&Oacute;N</p>
                <div class="ledboard">
                    <div id="led-message" data-duplicated='true'></div>
                    <div id="led-watch"></div>
                </div>
            </div>
            <div class="col-xs-4 blue">
                <div id="flipcounter-score-blue">00</div>
                <p>AZUL</p>
            </div>

            <!-- TEXT and games -->
            <div class="col-xs-4 top">
                <div id="flipcounter-fouls-red">00</div>
                <p>FALTAS</p>
            </div>
            <div class="col-xs-4 top">
                <div id="flipcounter-games">0</div>
                <p>JUEGOS</p>
            </div>
            <div class="col-xs-4 top">
                <div id="flipcounter-fouls-blue">00</div>
                <p>FALTAS</p>
            </div>

        </div>
    </div>
</body>
</html>