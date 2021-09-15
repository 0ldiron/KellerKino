<?php
class IMDBv1
{
	function GetRating($title)
	{
		$url="http://p.media-imdb.com/static-content/documents/v1/title/".$title."/ratings%3Fjsonp=imdb.rating.run:imdb.api.title.ratings/data.json";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);         // keine Header in Ausgabe
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Transfer als String zurückliefern
		curl_setopt($ch, CURLOPT_FAILONERROR, 1);    // ausführliche Fehlermeldung bei Fehlern (>= 400)

		$results = curl_exec($ch);
		$headers = curl_getinfo($ch);

		$error_number = curl_errno($ch);
		$error_message = curl_error($ch);

		curl_close($ch);

		$res2 = gzdecode($results);
		$res3 = substr($res2, 16, -1); // remove "imdb.rating.run(" and ")"
		$res4 = json_decode(($res3),true);
		$res5 = $res4['resource'];
		return (array) $res5;
	}
}
?>