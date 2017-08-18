<?php
	include_once('../../TwitterAutoPilot.php');
	include_once('../../utils/databaseUtils.php');

	$email = "usersEmail";
	$jobData = getJobJSON($email, "../logs/" . $email);

	$tap = new TwitterAutoPilot;
	$tap->init($jobData, $email, "../logs/");
?>