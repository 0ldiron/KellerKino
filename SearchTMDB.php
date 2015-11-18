<?php
	include("tmdb_v3.php");
	include("omdb_v1.php");

	$apikey="ab6e8dd491403ef61a74448dc97f1e70";

	print '<div id="movieLibraryContainer" class="contentContainer">';
	echo '<div class="searchMovie">';
	echo '<input type="text" name="title" placeholder="Titel" size="100" hight="32px" id="cTSearch" value="'.$_POST['cTitle'].'"/>';
	echo '<button class="searchbutton" id="bTSearch"/>';
	echo '</div>';
	
	
	if ($_POST['cXTitle'] <> '')
	{
		$tmdb_V3 = new TMDBv3($apikey,'de');

		$tm_search = $tmdb_V3->searchMovie($_POST['cTitle']);
#		echo"<pre>";echo_r($tm_search);echo"</pre>";

		foreach ($tm_search['results'] as $tm_movie)
		{
#			echo"<pre>";echo_r($tm_movie);echo"</pre>";
			$title = $tm_movie['title'];
			if (strlen($title) > 26)
			{
				$title = substr($title, 0, 23)."...";
			}

			print '<div class="divTST">';
			
			print '<div class="moviePoster">';
			
			if (empty($tm_movie['poster_path']))
			{
				$cover = 'images/nocover.png';
			}
			else
			{
				$cover = $tmdb_V3->getImageURL("w185").$tm_movie['poster_path'];
			}
			
			echo '<img class="cover" src="'.$cover.'" height="278" width="185">';
			print '<div class="movieIcon">';
			echo '<img class="cVAdd" data-id="'.$tm_movie['id'].'" data-state="0" src="images/plus.png">';
			print '</div>'; # movieIcon
			print '<div class="desc">'.$title.'</div>';

			echo '</div>'; # moviePoster
			echo '<div class="movieDetail" data-id="'.$tm_movie['id'].'">';
#			echo '<input type="submit" value="+" class="cAdd" data-id="'.$tm_movie['id'].'">';
			echo '<B>'.$tm_movie['title'].' ('.substr($tm_movie['release_date'],0,4).')</B>';

			echo '<TABLE>';
			echo '<TR><TD>Rating:</TD>  <TD id="Rating"  ></TD></TR>';
			echo '<TR><TD>Genre:</TD>   <TD id="Genre"   ></TD></TR>';
			echo '<TR><TD>Director:</TD><TD id="Director"></TD></TR>';
			echo '<TR><TD>Actors:</TD>  <TD id="Actors"  ></TD></TR>';
			echo '</TABLE>';
			echo '<div id="Plot"></div>';
			echo "</div>\n"; # movieDetail
			echo '</div>'; # divTST
			echo '<script>$.getJSON("MovieDetail.php",{id:'.$tm_movie['id'].'},SetDetail);</script>';
		}
	}
	echo '</div>'; # contentContainer
?>
