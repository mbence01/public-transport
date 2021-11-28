<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or $_SERVER["REQUEST_METHOD"] != "POST")
    http_response_code(403);

include_once("../../../sql/db_conn.php");



$query_str = "SELECT CONCAT(id, ',', indulasi_ora, ',', indulasi_perc, ',', indulasi_nap, ',', jarat_megnevezes) AS text FROM indul";


$get_buses = $sql->query($query_str);
$csv = fopen("generated_csv/INDULASOK.csv", "w");

fwrite($csv, "ID, Óra, Perc, Nap, Járat\n");

while($rows = $get_buses->fetch_array(MYSQLI_ASSOC))
    fwrite($csv, $rows["text"] . "\n");

fclose($csv);

header("Location: generated_csv/INDULASOK.csv");

?>