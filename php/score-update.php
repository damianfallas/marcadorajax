<?php

	$scores = file_get_contents('score.json');

	$scores = json_decode($scores);

	//print_r($scores);

	$scores->{'stamp'} = time();

	if($_POST['update-mode'] == 'data') {

		$scores->{'update-mode'} = 'data';
		$scores->{'score-red'} = (isset($_POST['score-red']))?$_POST['score-red']:0;
		$scores->{'fouls-red'} = (isset($_POST['fouls-red']))?$_POST['fouls-red']:0;
		$scores->{'score-blue'} = (isset($_POST['score-blue']))?$_POST['score-blue']:0;
		$scores->{'fouls-blue'} = (isset($_POST['fouls-blue']))?$_POST['fouls-blue']:0;
		$scores->{'led-mode'} = (isset($_POST['led-mode']))?$_POST['led-mode']:"";
		$scores->{'led-message'} = (isset($_POST['led-message']))?$_POST['led-message']:"led-mode-message";
		$scores->{'led-time'} = (isset($_POST['led-time']))?$_POST['led-time']:0;
		$scores->{'led-time-state'} = (isset($_POST['led-time-state']))?$_POST['led-time-state']:0;
		$scores->{'games'} = (isset($_POST['games']))?$_POST['games']:0;

	} else if($_POST['update-mode'] == 'state') {

		$scores->{'update-mode'} = 'state';
		$scores->{'data'} = (isset($_POST['data']))?$_POST['data']:true;
		$scores->{'value'} = (isset($_POST['value']))?$_POST['value']:true;
	}

	file_put_contents('score.json',json_encode($scores));