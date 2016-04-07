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

    $mins = str_pad($mins, 2, "0", STR_PAD_LEFT);
    $secs = str_pad($secs, 2, "0", STR_PAD_LEFT);
    $ms = str_pad($ms, 2, "0", STR_PAD_LEFT);

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
            // store the currently selected tab in the hash value
            $("ul.nav-tabs > li > a").on("shown.bs.tab", function(e) {
              var id = $(e.target).attr("href").substr(1);
              window.location.hash = id;
            });

            // on load of the page: switch to the currently selected tab
            var hash = window.location.hash;
            $('a[href="' + hash + '"]').tab('show');
        });
    </script>

    <script src="js/js-dashboard.js"></script>
    
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
                                        <input class="col-md-12" type="text" name="range-minutes" id="range-minutes" data-provide="slider" data-slider-min="0" data-slider-max="20" data-slider-step="1" data-slider-value="<?php echo (int) $mins; ?>" data-slider-tooltip="show">
                                        <button type="button" data-for="range-minutes" class="plus-slider btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" data-for="range-minutes" class="minus-slider btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                        <label for="range-seconds">Seconds<br /></label>
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                        <input class="col-md-12" type="text" name="range-seconds" id="range-seconds" data-provide="slider" data-slider-min="0" data-slider-max="59" data-slider-step="1" data-slider-value="<?php echo (int) $secs; ?>" data-slider-tooltip="show">
                                        <button type="button" data-for="range-seconds" class="plus-slider btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" data-for="range-seconds" class="minus-slider btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                        <label for="range-seconds">Milliseconds<br /></label>
                                    </div>
                                    <div class="col-xs-12 col-md-12">
                                         <input class="col-md-12" type="text" name="range-milliseconds" id="range-milliseconds" data-provide="slider" data-slider-min="0" data-slider-max="99" data-slider-step="1" data-slider-value="<?php echo (int) $ms; ?>" data-slider-tooltip="show">
                                         <button type="button" data-for="range-milliseconds" class="plus-slider btn btn-default"><i class="glyphicon glyphicon-plus"></i></button>
                                        <button type="button" data-for="range-milliseconds" class="minus-slider btn btn-default"><i class="glyphicon glyphicon-minus"></i></button>
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
