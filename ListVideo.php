<?php
	session_start();

include("SubVideo.php");

if (($_POST['idStatus'] <> '') & ($_POST['idStatus'] <> -1))
{
	$stmt = 'SELECT * FROM movies WHERE status='.$_POST['idStatus'].' ORDER BY lfdnr DESC';
}
elseif ($_POST['idRating'] <> '')
{
	$start = $_POST['idRating'];
	$end   = $start + 1;
	$stmt = 'SELECT * FROM movies WHERE imdbRating BETWEEN '.$start.' AND '.$end.' ORDER BY lfdnr DESC';
}
elseif ($_POST['cVGenre'] <> '')
{
	$stmt = 'SELECT * FROM movies WHERE genres LIKE "%'.$_POST['cVGenre'].'%" ORDER BY title';
}
elseif ($_POST['cVTitle'] <> '')
{
	$stmt = 'SELECT * FROM movies WHERE idx_title LIKE "'.$_POST['cVTitle'].'%" ORDER BY title';
}
else $stmt = 'SELECT * FROM movies ORDER BY lfdnr DESC';

if (empty($_SESSION['UPDATE_AUTH']))
{
	PrintVideos($stmt, 3);
}
else
{
	PrintVideos($stmt, 1);
}

?>
