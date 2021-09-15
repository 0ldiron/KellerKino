<?php
	session_start();

include("SubVideo.php");


$first = true;

if (isset($_POST['idStatus']) && ($_POST['idStatus'] <> -1))
{
	$stmt = 'SELECT * FROM movies WHERE status='.$_POST['idStatus'].' ORDER BY lfdnr DESC LIMIT 10 OFFSET 0';
}
elseif (isset($_POST['idRating']))
{
	$start = $_POST['idRating'];
	$end   = $start + 1;
	$stmt = 'SELECT * FROM movies WHERE imdbRating BETWEEN '.$start.' AND '.$end.' ORDER BY lfdnr DESC LIMIT 10 OFFSET 0';
}
elseif (isset($_POST['cVGenre']))
{
	$stmt = 'SELECT * FROM movies WHERE genres LIKE "%'.$_POST['cVGenre'].'%" ORDER BY title LIMIT 10 OFFSET 0';
}
elseif (isset($_POST['cVTitle']))
{
	$stmt = 'SELECT * FROM movies WHERE idx_title LIKE "'.$_POST['cVTitle'].'%" ORDER BY idx_title LIMIT 10 OFFSET 0';
}
elseif (isset($_POST['next']))
{
	$arr = explode(' ', $_SESSION['SQL_STMT']);
	for ($i=0; $i<count($arr); $i++)
	{
		if (0 == strcasecmp($arr[$i], 'LIMIT'))
		{
			$LIMIT = $arr[$i+1];
		}
		if (0 == strcasecmp($arr[$i], 'OFFSET'))
		{
			$arr[$i+1] += $LIMIT;
		}
	}
	$stmt = implode(' ', $arr);
	$first = false;
}
else $stmt = 'SELECT * FROM movies ORDER BY lfdnr DESC LIMIT 10 OFFSET 0';
$_SESSION['SQL_STMT'] = $stmt;


if (empty($_SESSION['UPDATE_AUTH']))
{
	PrintVideos($stmt, 3, $first);
}
else
{
	PrintVideos($stmt, 1, $first);
}

?>
