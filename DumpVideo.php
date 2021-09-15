<?php

	include("tmdb_v3.php");

	include("omdb_v1.php");





	$apikey="ab6e8dd491403ef61a74448dc97f1e70";


	$tmdb_V3 = new TMDBv3($apikey,'de');

	$omdb_V1 = new OMDBv1();
//        apikey=44cf2d13;


	$tm_info = $tmdb_V3->movieDetail(296098);

	$om_info = $omdb_V1->movieDetail($tm_info['imdb_id']);

	$conf = $tmdb_V3->getConfig();
	
	echo 'TMDBv3->getConfig(): ';

	echo"<pre>";print_r($conf);echo"</pre>";
	

	echo 'TMDBv3: ';

	echo"<pre>";print_r($tmdb_V3);echo"</pre>";



	echo 'TMDBv3->movieDetail: ';

	echo"<pre>";print_r($tm_info);echo"</pre>";



	echo 'OMDBv1->movieDetail: ';

	echo"<pre>";print_r($om_info);echo"</pre>";

?>