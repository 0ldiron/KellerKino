<?php


	if ($_POST['id'] <> '')
	{
		$stmt = 'SELECT * FROM movies WHERE lfdnr='.$_POST['id'];

		$db = new SQLite3('videoworld.sqlite');
	$res = $db->query($stmt);

	if ($row = $res->fetchArray(SQLITE3_ASSOC))
	{
		echo "<TABLE><TR><TD>";
		if (empty($row['poster_path']))
		{
			echo '<img class="cover" src="images/nocover.png" height="278" width="185">';
		}
		else
		{
	#		$tmdb_V3->getImageURL("w185"): 	http://image.tmdb.org/t/p/w185
			echo '<img class="cover" alt="'.$title.'" src="http://image.tmdb.org/t/p/w185'.$row['poster_path'].'">';
		}
		echo "</TD><TD>";

		echo '<B>'.$row['title'].' ('.substr($row['release_date'],0,4).')</B>';
		echo '<TABLE>';
		echo '<TR><TD>Rating:</TD><TD>'.$row['imdbRating'].' ('.$row['imdbVotes'].')</TD></TR>';
		echo '<TR><TD>Genre:</TD><TD>'.$row['genres'].'</TD></TR>';
		echo '<TR><TD>Director:</TD><TD>'.$row['director'].'</TD></TR>';
		echo '<TR><TD>Actors:</TD><TD>'.$row['actors'].'</TD></TR>';
		echo '<TR><TD>Links:</TD><TD><A target="_blank" HREF="http://www.imdb.com/title/'.$row['imdb_id'].'/">IMDB</A>&nbsp;<A target="_blank" HREF="https://www.themoviedb.org/movie/'.$row['id'].'">TMDB</A></TD></TR>';
		echo '</TABLE>';
		echo $row['overview'];
		echo "</TD></TR></TABLE>";
	}


	$db->close();

	#DEBUG#
	echo '<script>console.log(\''.$stmt.'\')</script>';
}

?>
