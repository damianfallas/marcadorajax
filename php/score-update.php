<?php

	$scores =  array(
				'stamp' => time(),
				'lights' =>   (isset($_POST['lights']))?$_POST['lights']:true,
				'score-red' =>   (isset($_POST['score-red']))?$_POST['score-red']:0,
				'fouls-red' =>   (isset($_POST['fouls-red']))?$_POST['fouls-red']:0,
				'score-blue' =>  (isset($_POST['score-blue']))?$_POST['score-blue']:0,
				'fouls-blue' =>  (isset($_POST['fouls-blue']))?$_POST['fouls-blue']:0,
				'led-mode' =>  (isset($_POST['led-mode']))?$_POST['led-mode']:"",
				'led-message' =>  (isset($_POST['led-message']))?$_POST['led-message']:"led-mode-message",
				'led-time' =>  (isset($_POST['led-time']))?$_POST['led-time']:0,
				'games' =>  (isset($_POST['games']))?$_POST['games']:0
				);

	file_put_contents('score.json',json_encode($scores));