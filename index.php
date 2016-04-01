<?php

    @$file = file_get_contents("./php/score.json");
    @$var = json_decode($file, true);

            
    $stamp = $var['led-time'];
    $ms = $stamp % 1000;
    $stamp = ($stamp - $ms) / 1000;
    $secs = $stamp % 60;
    $stamp = ($stamp - $secs) / 60;
    $mins = $stamp % 60;
    $hrs = ($stamp - $mins) / 60;
    $ms = ($ms > 99)? parseInt($ms/10) : $ms;

    // $mins = str_pad($mins, 2, "0", STR_PAD_LEFT);
    // $secs = str_pad($secs, 2, "0", STR_PAD_LEFT);
    // $ms = str_pad($ms, 2, "0", STR_PAD_LEFT);

?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Scoreboard update.">

    <title>Scoreboard update</title>

    <link rel="stylesheet" href="css/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/layouts/dashboard.css">
    <link rel="stylesheet" href="css/bootstrap-slider.min.css">

    <script src="js/jquery-2.2.0.min.js"></script>
    <script src="css/bootstrap/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-slider.min.js"></script>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script type="text/javascript">
        $( document ).ready(function() {

            //SCORE UPDATE
            $("#btn-score-update").click(function(){
                $.post("php/score-update.php",
                {
                    'update-mode' : 'score-update',
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

            //L3D msg
            $("#btn-led-message-update").click(function(){
                $.post("php/score-update.php",
                {
                    'update-mode' : 'led-message-update',
                    'led-message': $('#led-message').val(),
                },
                function(data, status){
                    if(status != "success") {
                        alert("Data: " + data + "\nStatus: " + status);
                    }
                });
            });


            //L3D watch
            $("#btn-led-time-update").click(function(){
                $.post("php/score-update.php",
                {
                    'update-mode' : 'led-time-update',
                    'led-time': getTime(),
                },
                function(data, status){
                    if(status != "success") {
                        alert("Data: " + data + "\nStatus: " + status);
                    }
                });
            });


            $("#btn-score-pend").click(function(){
                $.post("php/score-update.php",
                {
                    'update-mode' : 'score-update',
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
                if($('#lights i').hasClass('glyphicon-eye-close')) {
                    sendState('lights', true);
                    $('#lights i').removeClass('glyphicon-eye-close').addClass('glyphicon-eye-open');
                } else {
                    sendState('lights', false);
                    $('#lights i').removeClass('glyphicon-eye-open').addClass('glyphicon-eye-close');
                }
            });

            $("#lights-logo").click(function() {
                if($('#lights-logo i').hasClass('glyphicon-record')) {
                    sendState('lights-logo', true);
                    $('#lights-logo i').removeClass('glyphicon-record').addClass('glyphicon-asterisk');
                } else {
                    sendState('lights-logo', false);
                    $('#lights-logo i').removeClass('glyphicon-asterisk').addClass('glyphicon-record');
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

            $(".plus.btn").click(function() {
                steps = $(this).data('forsteps');
                steps = (steps)?steps:1;
                elem = $( '#' + $(this).data('for') );
                elem.val(parseInt(elem.val()) + steps);
            });
            $(".minus.btn").click(function() {
                steps = $(this).data('forsteps');
                steps = (steps)?steps:1;
                elem = $( '#' + $(this).data('for') );
                n = parseInt(elem.val()) - steps
                elem.val( (n<0)?0:n );
            });

            $("#range-minutes, #range-milliseconds, #range-seconds").on("change", function() {

                min = $('#range-minutes').val();
                mil = $('#range-milliseconds').val();
                sec = $('#range-seconds').val();

                $('#time').val(pad2(min) + ':' + pad2(sec) + '.' + pad2(mil));
            });

            $('*[data-watchbtn]').click(function() {
                n = $(this).data('watchbtn');
                time = $('#time').val().replace(':', '').replace('.', '').substring(1,6);
                $('#time').val(time[0] + time[1] + ":" + time[2] + time[3] + "." + time[4] + n)
            });

            function getTime() {
                time =$('#time').val();
                min = time[0] + time[1];
                sen = time[3] + time[4];
                mis = time[6] + time[7];
                return (parseInt(min) * 60 * 1000) + (parseInt(sen) * 1000) + parseInt(mis);
            }

            function pad2(number) { 
                return (number < 10 ? '0' : '') + number; 
            }
        })
    </script>
    
</head>
<body>

    <nav class="navbar navbar-default">
        <div class="container-fluid"> 
            <div class="navbar-header">
                <p class="navbar-brand">Scoreboard <sup>DASH</sup></p>
            </div> 
            <div class="nav navbar-nav navbar-right">
                <a class="btn btn-default navbar-btn" href="scoreboard.php" target="blank"><i class="glyphicon glyphicon-modal-window"></i></a>
                <button id="lights-logo" class="btn btn-default navbar-btn" type="button"><i class="glyphicon glyphicon-asterisk"></i></button>
                <button id="lights" class="btn btn-default navbar-btn" type="button"><i class="glyphicon glyphicon-eye-open"></i></button>
            </div> 
        </div>
    </nav>

    <div class="container">
        <div class="row">
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active"><a href="#score" role="tab" data-toggle="tab">Score</a></li>
                <li role="presentation"><a href="#message" role="tab" data-toggle="tab">LED Message</a></li>
                <li role="presentation"><a href="#watch" role="tab" data-toggle="tab">LED Watch</a></li>
            </ul>

            <!-- Tab panes -->
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="score">

                    <div class="form-group">
                        <div class="input-group">
                            <span class="input-group-addon">Games</span>
                            <input id="games" class="form-control" type="number" placeholder="" value="<?php echo $var['games']; ?>">
                            <div class="input-group-btn">
                                <button type="button" data-for="games" class="plus btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                <button type="button" data-for="games" class="minus btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            <h3 class="panel-title">Red</h3>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Score</span>
                                    <input id="score-red" class="form-control" type="number" placeholder="" value="<?php echo $var['score-red']; ?>">
                                    <div class="input-group-btn">
                                        <button type="button" data-for="score-red" class="plus btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" data-for="score-red" class="minus btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Fouls</span>
                                    <input id="fouls-red" class="form-control" type="number" placeholder="" value="<?php echo $var['fouls-red']; ?>">
                                    <div class="input-group-btn">
                                        <button type="button" data-for="fouls-red" class="plus btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" data-for="fouls-red" class="minus btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">Blue</h3>
                        </div>
                        <div class="panel-body">

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Score</span>
                                    <input id="score-blue" class="form-control" type="number" placeholder="" value="<?php echo $var['score-blue']; ?>">
                                    <div class="input-group-btn">
                                        <button type="button" data-for="score-blue" class="plus btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" data-for="score-blue" class="minus btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">Fouls</span>
                                    <input id="fouls-blue" class="form-control" type="number" placeholder="" value="<?php echo $var['fouls-blue']; ?>">
                                    <div class="input-group-btn">
                                        <button type="button" data-for="fouls-blue" class="plus btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" data-for="fouls-blue" class="minus btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12">
                                <button id="btn-score-update" type="button" class="btn btn-primary btn-lg col-xs-12 btn-success"><i class="glyphicon glyphicon-send"></i> Submit</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- MESSAGE  L3D -->

                <div role="tabpanel" class="tab-pane" id="message">
                    <div class="form-group">
                        <div class="input-group">
                            <div class="pure-control-group">
                                <label for="led-message">LED board Message</label>
                                <textarea id="led-message" class="form-control"><?php echo $var['led-message']; ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-12">
                                <button id="btn-led-message-update" type="button" class="btn btn-primary btn-lg col-xs-12 btn-success"><i class="glyphicon glyphicon-send"></i> Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="watch">

                    <div class="panel panel-default">
                        <div class="panel-body">

                            <div class="form-group form-group-lg">
                                <div class="input-group">
                                    <input id="time" class="form-control" type="text" value="<?php echo "$mins:$secs.$ms"; ?>" disabled>
                                    <div class="input-group-btn">
                                        <button id="btn-led-time-update" type="button" class="btn btn-primary btn-lg btn-success"><i class="glyphicon glyphicon-send"></i></button>
                                        <button id="btn-watch-start" type="button" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-play"></i></button>
                                        <button id="btn-watch-pause" type="button" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-pause"></i></button>
                                        <button id="btn-watch-reset" type="button" class="btn btn-primary btn-lg"><i class="glyphicon glyphicon-stop"></i></button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-12 col-md-12">
                                        <label for="range-minutes">Minutes<br /></label>
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                        <input class="col-md-12" type="text" name="range-minutes" id="range-minutes" data-provide="slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="<?php echo $mins; ?>" data-slider-tooltip="show">
                                        <button type="button" data-for="range-minutes" class="plus btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" data-for="range-minutes" class="minus btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                        <label for="range-seconds">Seconds<br /></label>
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                        <input class="col-md-12" type="text" name="range-seconds" id="range-seconds" data-provide="slider" data-slider-min="0" data-slider-max="59" data-slider-step="1" data-slider-value="<?php echo $secs; ?>" data-slider-tooltip="show">
                                        <button type="button" data-for="range-seconds" class="plus btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" data-for="range-seconds" class="minus btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                        <label for="range-seconds">Milliseconds<br /></label>
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                         <input class="col-md-12" type="text" name="range-milliseconds" id="range-milliseconds" data-provide="slider" data-slider-min="0" data-slider-max="99" data-slider-step="1" data-slider-value="<?php echo $ms; ?>" data-slider-tooltip="show">
                                         <button type="button" data-for="range-milliseconds" class="plus btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" data-for="range-milliseconds" class="minus btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                </div>
                            </div>                           
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $('.nav-tabs a').click(function (e) {
          e.preventDefault()
          $(this).tab('show')
        })
    </script>

</body>
</html>
