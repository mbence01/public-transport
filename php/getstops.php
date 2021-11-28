<?php

include_once("../sql/db_conn.php");

$get_stops = $sql->query("SELECT * FROM megallo ORDER BY nev");
$c = $_GET["count"];

echo "<p>" . ++$c . ". <select name='megallo" . $c . "'>";
while($rows = $get_stops->fetch_array(MYSQLI_ASSOC)) {
    echo "<option value='" . $rows["id"] . "'>" . $rows["nev"] . "</option>";
}
echo "</select></p>";

?>