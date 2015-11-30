<?php
# $mode 0: Keine Buttons
#       1: Status Buttons
#       2: Delete Button
#		3: Info Buttons
function PrintVideos($stmt, $mode)
{
	$db = new SQLite3('videoworld.sqlite');
	$res = $db->query($stmt);

	echo '<div id="movieLibraryContainer" class="contentContainer">';
	while($row = $res->fetchArray(SQLITE3_ASSOC))
	{
		$title = $row['title'];
		if (strlen($title) > 26)
		{
			$title = substr($title, 0, 23)."...";
		}
		
		echo '<div class="divTST">';

		echo '<div class="videoPoster" data-id="'.$row['lfdnr'].'">';
		if (empty($row['poster_path']))
		{
			echo '<img class="cover" src="images/nocover.png" height="278" width="185">';
		}
		else
		{
	#		$tmdb_V3->getImageURL("w185"): 	http://image.tmdb.org/t/p/w185
			echo '<img class="cover" alt="'.$title.'" src="http://image.tmdb.org/t/p/w185'.$row['poster_path'].'">';
		}

		echo '<div class="movieIcon">';
		if ($mode == 1)
		{
			$s1= ""; $s2= ""; $s3= "";
			switch ($row['status'])
			{
				case 1: $s1=" cActive"; break;
				case 2: $s2=" cActive"; break;
				case 3: $s3=" cActive"; break;
			}

			echo '<img class="cUpd" data-id="'.$row['lfdnr'].'" data-state="0" src="images/status_0.png">';
			echo '<img class="cUpd'.$s1.'" data-id="'.$row['lfdnr'].'" data-state="1" src="images/status_1.png">';
			echo '<img class="cUpd'.$s3.'" data-id="'.$row['lfdnr'].'" data-state="3" src="images/status_3.png">';
			echo '<img class="cUpd'.$s2.'" data-id="'.$row['lfdnr'].'" data-state="2" src="images/status_2.png">';
		}
		elseif ($mode == 2)
		{
			echo '<img class="cDel" data-id="'.$row['lfdnr'].'" data-state="0" src="images/delete.png">';
		}
		elseif ($mode == 3)
		{
			switch ($row['status'])
			{
				case 1: echo '<img class="cInfo" src="images/status_1.png">'; break;
				case 2: echo '<img class="cInfo" src="images/status_2.png">'; break;
				case 3: echo '<img class="cInfo" src="images/status_3.png">'; break;
			}
		}
		echo '</div>'; # movieIcon

		echo '<div class="desc">'.$title.'</div>';
		echo '</div>'; # videoPoster
		
		echo '<div class="movieDetail">';
		echo '<B>'.$row['title'].' ('.substr($row['release_date'],0,4).')</B>';
		echo '<TABLE>';
		echo '<TR><TD>Rating:</TD><TD>'.$row['imdbRating'].'</TD></TR>';
		echo '<TR><TD>Genre:</TD><TD>'.$row['genres'].'</TD></TR>';
		echo '<TR><TD>Director:</TD><TD>'.$row['director'].'</TD></TR>';
		echo '<TR><TD>Actors:</TD><TD>'.$row['actors'].'</TD></TR>';
		echo '</TABLE>';
		echo $row['overview'];
		echo '</div>'; # movieDetail
		echo '</div>'; # divTST
	}
	echo "</div>"; #contentContainer


	$db->close();

	#DEBUG#
	echo '<script>console.log(\''.$stmt.'\')</script>';
}

?>
