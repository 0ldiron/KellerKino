<?php
	include("tmdb_v3a.php");
	include("imdb_v1.php");
	include "SubIndex.php";


	$apikey="ab6e8dd491403ef61a74448dc97f1e70";

	if ($_POST['id'] <> '')
	{
#		echo 'ID: '.$_POST['id'];
		$tmdb_V3 = new TMDBv3($apikey,'de');
		$imdb_V1 = new IMDBv1();
		
#		echo "DETALLES DE PELICULA";
		$tm_info = $tmdb_V3->movieDetail($_POST['id']);
		$tm_crew = $tmdb_V3->movieCrew($_POST['id']);
		$im_rate = $imdb_V1->GetRating($tm_info['imdb_id']);
		
#		echo"<pre>";print_r($tm_info);echo"</pre>";
#		echo"<pre>";print_r($om_info);echo"</pre>";
		
		$str_genres = "";
		foreach ($tm_info['genres'] as $g)
		{
			if (empty($str_genres)) $str_genres = $g['name'];
			else $str_genres .= ' | '.$g['name'];
		}
#		echo"<pre>";print_r($str_genres);echo"</pre>";

		$idx_title = GetIndex($tm_info['title']);

		$db = new SQLite3('videoworld.sqlite');

		$stmt = $db->prepare('INSERT INTO movies(id,imdb_id,original_title,overview,poster_path,release_date,title,imdbRating,backdrop_path,genres,actors,director,idx_title,imdbVotes) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)');
		$stmt->bindParam( 1, $tm_info['id']);
		$stmt->bindParam( 2, $tm_info['imdb_id']);
		$stmt->bindParam( 3, $tm_info['original_title']);
		$stmt->bindParam( 4, $tm_info['overview']);
		$stmt->bindParam( 5, $tm_info['poster_path']);
		$stmt->bindParam( 6, $tm_info['release_date']);
		$stmt->bindParam( 7, $tm_info['title']);
		$stmt->bindParam( 8, $im_rate['rating']);
		$stmt->bindParam( 9, $tm_info['backdrop_path']);
		$stmt->bindParam(10, $str_genres);
		$stmt->bindParam(11, $tm_crew['cast']);
		$stmt->bindParam(12, $tm_crew['Director']);
		$stmt->bindParam(13, $idx_title);
		$stmt->bindParam(14, $im_rate[ratingCount]);
		$rc = $stmt->execute();
		if (!$rc)
		{
			print 'Error: "'.$tm_info['title'].'" not added!';
		}
#		echo"<pre>";print_r($rc);echo"</pre>";
		$db->close();
	}
?>