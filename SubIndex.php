<?php
function GetIndex($title)
{
	$s1 = utf8_decode($title);
	$s1 = strtr ($s1, 'ƒд÷ц№ья', 'AaOoUuS');
	$s1 = strtoupper($s1);
	
	$worte=explode(" ",$s1);
	if ((strcasecmp($worte[0], "ein" ) == 0) ||
	   (strcasecmp($worte[0], "eine") == 0) ||
	   (strcasecmp($worte[0], "der" ) == 0) ||
	   (strcasecmp($worte[0], "die" ) == 0) ||
	   (strcasecmp($worte[0], "das" ) == 0) ||
	   (strcasecmp($worte[0], "the" ) == 0) ||
	   (strcasecmp($worte[0], "a"   ) == 0) ||
	   (strcasecmp($worte[0], "an"  ) == 0) ||
	   (strcasecmp($worte[0], "el"  ) == 0) ||
	   (strcasecmp($worte[0], "la"  ) == 0))
	{
		array_shift($worte); // erstes Wort wech
	}
	$c1 = substr($worte[0],0,1);
	if (ctype_digit($c1)) array_unshift($worte, '#');
	elseif (ctype_alpha($c1)) array_unshift ($worte, $c1);
	else array_unshift($worte, '*');
	$s1 = implode(" ",$worte);
	return $s1;
}
?>