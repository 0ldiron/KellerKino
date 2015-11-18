<?php

	$db = new SQLite3('videoworld.sqlite');

	if (($_POST['id'] <> '') && ($_POST['idStatus'] <> ''))
	{
		$stmt = $db->prepare('UPDATE movies SET status=? WHERE lfdnr=?');
		$stmt->bindParam( 1, $_POST['idStatus']);
		$stmt->bindParam( 2, $_POST['id']);
		$rc = $stmt->execute();
		if ($rc)
		{
			print 'id('.$_POST['id'].') updated';
		}
		else
		{
			print '<b>Error</b>';
		}
		$db->close();
	}
?>

