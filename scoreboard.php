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
    <script type="text/javascript" src="js/jquery.runner-min.js"></script>
    <script type='text/javascript' src='js/jquery.marquee.min.js'></script>
    <script type='text/javascript' src='js/js-scoreboard.js'></script>
    
</head>
<body>
	<video playsinline autoplay muted loop class="bgvid bg" style="display: none;">
		<source src="vid/PeacefulFlow.mp4" type="video/mp4">
	</video>
    <video playsinline autoplay muted loop class="bgvid bgs" style="display: none;">
        <source src="vid/exploding.mp4" type="video/mp4">
    </video>
    <div class="light" style="display: none;"></div>
    <div class="light-logo" style="display: none;"></div>
	<div class="duplas-bg"></div>
    <div class="container-fluid">

        <div class="row">
            <!-- SCORES -->
            <div class="col-xs-4 red">
                <div id="flipcounter-score-red" class="shadow-text">00</div>
            </div>
            <div class="col-xs-4">
                <p class="centertitle"><img src="images/logoIF.png"></p>
                <div class="ledboard shadow-text">
                    <div id="led-message" data-duplicated='true'></div>
                    <div id="led-watch"></div>
                </div>
            </div>
            <div class="col-xs-4 blue">
                <div id="flipcounter-score-blue" class="shadow-text">00</div>
            </div>
        </div>
        <div class="row">
            <!-- TEXT and games -->
            <!-- div class="col-xs-4 top" style="display: none;">
                <div id="flipcounter-fouls-red">00</div>
                <p>FALTAS</p>
            </div -->
            <div class="col-xs-12 top">
                <span id="flipcounter-games" class="shadow-text">0</span><br />
                <p class="fk shadow-text">ROUND</p>
            </div>
            <!-- div class="col-xs-4 top" style="display: none;">
                <div id="flipcounter-fouls-blue">00</div>
                <p>FALTAS</p>
            </div-->

        </div>
    </div>
</body>
</html>