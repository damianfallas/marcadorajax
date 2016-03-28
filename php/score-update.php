<?php

	$scores = file_get_contents('score.json');

	$scores = json_decode($scores);

	//print_r($scores);

	$scores->{'stamp'} = time();

	if($_POST['update-mode'] == 'score-update') {

		$scores->{'update-mode'} = 'score-update';
		$scores->{'score-red'} = (isset($_POST['score-red']))?$_POST['score-red']:0;
		$scores->{'fouls-red'} = (isset($_POST['fouls-red']))?$_POST['fouls-red']:0;
		$scores->{'score-blue'} = (isset($_POST['score-blue']))?$_POST['score-blue']:0;
		$scores->{'fouls-blue'} = (isset($_POST['fouls-blue']))?$_POST['fouls-blue']:0;
		$scores->{'games'} = (isset($_POST['games']))?$_POST['games']:0;

	} else if($_POST['update-mode'] == 'led-message-update') {

		$scores->{'update-mode'} = 'led-message-update';
		$scores->{'led-message'} = (isset($_POST['led-message']))?$_POST['led-message']:"led-mode-message";

	} else if($_POST['update-mode'] == 'led-time-update') {

		$scores->{'update-mode'} = 'led-time-update';
		$scores->{'led-time'} = (isset($_POST['led-time']))?$_POST['led-time']:0;

	} else if($_POST['update-mode'] == 'state') {

		$scores->{'update-mode'} = 'state';
		$scores->{'data'} = (isset($_POST['data']))?$_POST['data']:true;
		$scores->{'value'} = (isset($_POST['value']))?$_POST['value']:true;
	}

	file_put_contents('score.json',json_encode($scores));