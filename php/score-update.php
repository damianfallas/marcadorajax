<?php

	$scores =  array(
				'stamp' => time(),
				'lights' =>   (isset($_POST['lights']))?$_POST['lights']:true,
				'score-red' =>   (isset($_POST['score-red']))?$_POST['score-red']:0,
				'fouls-red' =>   (isset($_POST['fouls-red']))?$_POST['fouls-red']:0,
				'score-blue' =>  (isset($_POST['score-blue']))?$_POST['score-blue']:0,
				'fouls-blue' =>  (isset($_POST['fouls-blue']))?$_POST['fouls-blue']:0,
				'games' =>  (isset($_POST['games']))?$_POST['games']:0
				);

	file_put_contents('score.json',json_encode($scores));