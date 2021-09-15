<?php
//
// 	The Open Movie Database API by Brian Fritz
//
// 	Parameter 	Value 				Description
// 	s 			string (optional) 	title of a movie to search for
// 	i 			string (optional) 	a valid IMDb movie id
// 	t 			string (optional) 	title of a movie to return
// 	y 			year (optional) 	year of the movie
// 	r 			JSON, XML 			response data type (JSON default)
// 	plot 		short, full 		short or extended plot (short default)
// 	callback 	name (optional) 	JSONP callback name
// 	tomatoes 	true (optional) 	adds rotten tomatoes data 
class OMDBv1
{
    #<CONSTANTS>
	#@var string url of API OMDB
//	const _API_URL_ = "http://www.omdbapi.com/?apikey=289ba303&";
//	const _API_URL_ = "http://www.omdbapi.com/?apikey=fcbd49b5&";
	const _API_URL_ = "http://www.omdbapi.com/?apikey=";
	
	public function movieDetail($idMovie)
	{
		return $this->_call('i=', $idMovie);
	}//end of movieDetail

	private function _GetApiKey()
	{
		$apikey = "";
		$rh = fopen("http://www.omdbapi.com/src/application.js", "r");
		if ($rh !==false)
		{
			while (!feof($rh))
			{
				if (($zeile = fgets($rh)) !== false)
				{
					$pos = stripos($zeile, "&apikey=");
					if ($pos !== false)
					{
						$pos += 8;
						$pos2 = stripos($zeile, "'", $pos);
						if ($pos2 !== false)
						{
							$apikey = substr($zeile, $pos, $pos2-$pos);
							break;
						}
					}
				}
			}
			fclose($rh);
		}
		error_log($apikey);
		return $apikey;
	}
	
	
	private function _call($action, $text)
	{

		$url=OMDBv1::_API_URL_.$this->_GetApiKey()."&".$action.$text;
		// echo "<pre>$url</pre>";
		$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);

		$results = curl_exec($ch);
		$headers = curl_getinfo($ch);

		$error_number = curl_errno($ch);
		$error_message = curl_error($ch);

		curl_close($ch);
		// header('Content-Type: text/html; charset=iso-8859-1');
		//echo"<pre>";print_r(($results));echo"</pre>";
		$results = json_decode(($results),true);
		return (array) $results;
	}//end of _call
}
?>