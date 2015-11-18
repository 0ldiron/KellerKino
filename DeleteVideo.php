<?php

	$db = new SQLite3('videoworld.sqlite');

	if ($_POST['id'] <> '')
	{
		$stmt = $db->prepare('DELETE FROM movies WHERE lfdnr=?');
		$stmt->bindParam( 1, $_POST['id']);
		$rc = $stmt->execute();
		if ($rc)
		{
			print 'id('.$_POST['id'].') deleted';
		}
		else
		{
			print '<b>Error</b>';
		}
		$db->close();
	}
?>

