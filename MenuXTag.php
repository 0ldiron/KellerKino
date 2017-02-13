<?php
include "Settings.php";

echo '<div id="navigation">';
echo "<ul>";
$db = new SQLite3($SQL_MOVIE);
$res = $db->query('SELECT * FROM tag ORDER BY name');
while($row = $res->fetchArray(SQLITE3_ASSOC))
{
	echo '<li class="cXTag" data-id="'.$row['tag_id'].'">'.$row['name'].'</li>'."\n\r";
} 
$db->close();
echo "</ul>";
echo '</div>';
?>
