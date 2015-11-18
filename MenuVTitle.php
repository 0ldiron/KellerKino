<div id="navigation">
	<ul>
<?php
	$db = new SQLite3('videoworld.sqlite');
	$res = $db->query('SELECT title FROM movies ORDER BY title');
	$car_pre = null;
	while($row = $res->fetchArray(SQLITE3_ASSOC))
	{
		$car_new = strtoupper(substr($row['title'],0,1));
		if (is_numeric($car_new))
		{
			$car_new = '0';
		}
		if ($car_new <> $car_pre)
		{
			echo '<li class="cVTitle">'.$car_new.'</li>'."\r\n";
			$car_pre = $car_new;
		}
	}
	$db->close();
?>
	</ul>
</div>