<?php
	session_start();

	/* Nur LOGON und danach zurueck ins Hauptverzeichnis */
    $_SESSION['UPDATE_AUTH'] = 1;
	header('Location: http://'.$_SERVER['HTTP_HOST']);
	exit();
?>
