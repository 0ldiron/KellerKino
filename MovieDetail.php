<?php
	include("tmdb_v3a.php");
	include("imdb_v1.php");

	$apikey="ab6e8dd491403ef61a74448dc97f1e70";

	if ($_GET['id'] <> '')
	{
		$tmdb_V3 = new TMDBv3($apikey,'de');
		$imdb_V1 = new IMDBv1();

		$tm_info = $tmdb_V3->movieDetail($_GET['id']);
		$tm_crew = $tmdb_V3->movieCrew($_GET['id']);
		$im_rate = $imdb_V1->GetRating($tm_info['imdb_id']);
		
		$str_genres = "";
		foreach ($tm_info['genres'] as $g)
		{
			if (empty($str_genres)) $str_genres = $g['name'];
			else $str_genres .= ' | '.$g['name'];
		}
		
		print '{';
		print '  "id": "'.$_GET['id'].'",';
		print '  "Rating": "'.$im_rate['rating'].' ('.$im_rate[ratingCount].')",';
		print '  "Genre": "'.$str_genres.'",';
		print '  "Director": "'.$tm_crew['Director'].'",';
		print '  "Actors": "'.$tm_crew['cast'].'",';
		print '  "Plot": "'.addcslashes($tm_info['overview'],'"').'"';
		print "}";
	}
	else
	{
		print '{ "id": "-1"}';
	}
?>
