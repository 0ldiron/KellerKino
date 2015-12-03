<?php
	include("tmdb_v3.php");
	include("omdb_v1.php");

	$apikey="ab6e8dd491403ef61a74448dc97f1e70";

	if ($_GET['id'] <> '')
	{
		$tmdb_V3 = new TMDBv3($apikey,'de');
		$omdb_V1 = new OMDBv1();

		$tm_info = $tmdb_V3->movieDetail($_GET['id']);
		$om_info = $omdb_V1->movieDetail($tm_info['imdb_id']);

		print '{';
		print '  "id": "'.$_GET['id'].'",';
		print '  "Rating": "'.$om_info['imdbRating'].' ('.$om_info[imdbVotes].')",';
		print '  "Genre": "'.$om_info['Genre'].'",';
		print '  "Director": "'.$om_info['Director'].'",';
		print '  "Actors": "'.$om_info['Actors'].'",';
		print '  "Plot": "'.addslashes($tm_info['overview']).'"';
		print "}";
	}
	else
	{
		print '{ "id": "-1"}';
	}
?>
