<?php
	include("tmdb_v3.php");
	include("omdb_v1.php");


	$apikey="ab6e8dd491403ef61a74448dc97f1e70";

	if ($_POST['id'] <> '')
	{
#		echo 'ID: '.$_POST['id'];
		$tmdb_V3 = new TMDBv3($apikey,'de');
		$omdb_V1 = new OMDBv1();
		
#		echo "DETALLES DE PELICULA";
		$tm_info = $tmdb_V3->movieDetail($_POST['id']);
		$om_info = $omdb_V1->movieDetail($tm_info['imdb_id']);
		
#		echo"<pre>";print_r($tm_info);echo"</pre>";
#		echo"<pre>";print_r($om_info);echo"</pre>";
		
		$str_genres = "";
		foreach ($tm_info['genres'] as $g)
		{
			if (empty($str_genres)) $str_genres = $g['name'];
			else $str_genres .= ' | '.$g['name'];
		}
#		echo"<pre>";print_r($str_genres);echo"</pre>";

		$db = new SQLite3('videoworld.sqlite');
		
		$stmt = $db->prepare('INSERT INTO movies(id,imdb_id,original_title,overview,poster_path,release_date,title,imdbRating,backdrop_path,genres,actors,director) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)');
		$stmt->bindParam( 1, $tm_info['id']);
		$stmt->bindParam( 2, $tm_info['imdb_id']);
		$stmt->bindParam( 3, $tm_info['original_title']);
		$stmt->bindParam( 4, $tm_info['overview']);
		$stmt->bindParam( 5, $tm_info['poster_path']);
		$stmt->bindParam( 6, $tm_info['release_date']);
		$stmt->bindParam( 7, $tm_info['title']);
		$stmt->bindParam( 8, $om_info['imdbRating']);
		$stmt->bindParam( 9, $tm_info['backdrop_path']);
		$stmt->bindParam(10, $str_genres);
		$stmt->bindParam(11, $om_info['Actors']);
		$stmt->bindParam(12, $om_info['Director']);
		$rc = $stmt->execute();
		if (!$rc)
		{
			print 'Error: "'.$tm_info['title'].'" not added!';
		}
#		echo"<pre>";print_r($rc);echo"</pre>";
		$db->close();
	}
?>

