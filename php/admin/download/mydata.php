<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or $_SERVER["REQUEST_METHOD"] != "POST")
    http_response_code(403);

include_once("../../../sql/db_conn.php");

$data = [
    [ "ID", "Felhasználónév", "E-mail cím", "Kódolt jelszó", "Adminisztrátor", "Kiírt hírek száma", "Kiírt hírek címe", "Vásárolt jegyek száma" ],
];

$jegyek = [
    [ "ID", "USERID", "Név", "Mennyiség", "Dátum" ]
];

$hirek = [
    [ "ID", "Cím", "Szöveg", "Írta", "Dátum", "Rögzített" ]
];



$query_str = "
    SELECT 
           felhasznalo.*, COUNT(hir.id) AS hirek, SUM(jegy.mennyiseg) AS jegyek 
    FROM felhasznalo 
        INNER JOIN hir ON hir.irta = felhasznalo.id 
        INNER JOIN jegy ON jegy.user_id = felhasznalo.id
    WHERE felhasznalo.id = " . $_SESSION["userid"] . " 
    GROUP BY hir.irta, jegy.user_id;
";

$get_data = $sql->query($query_str);

$rows = $get_data->fetch_array(MYSQLI_ASSOC);

array_push($data, []);

foreach($rows as $elem) {
    array_push($data[1], $elem);
}



$query_str = "
    SELECT *
    FROM jegy 
    WHERE user_id = " . $_SESSION["userid"];

$get_tickets = $sql->query($query_str);

while($rows = $get_tickets->fetch_array(MYSQLI_ASSOC)) {
    array_push($jegyek, []);

    foreach($rows as $elem) {
        array_push($jegyek[count($jegyek) - 1], $elem);
    }
}



$query_str = "
    SELECT *
    FROM hir 
    WHERE irta = " . $_SESSION["userid"];

$get_news = $sql->query($query_str);

while($rows = $get_news->fetch_array(MYSQLI_ASSOC)) {
    array_push($hirek, []);

    foreach($rows as $elem) {
        array_push($hirek[count($hirek) - 1], $elem);
    }
}


$csv = fopen("generated_csv/SZEMELYES_ADATOK_ID_" . $_SESSION["userid"] . ".csv", "w");

for($i = 0; $i < count($data); $i++) {
    for($j = 0; $j < count($data[$i]); $j++) {
        fwrite($csv,"'" . $data[$i][$j] . "'");

        if($j+1 != count($data[$i]))
            fwrite($csv, ",");
    }
    fwrite($csv, "\n");
}
fwrite($csv, "\n\n");

for($i = 0; $i < count($jegyek); $i++) {
    for($j = 0; $j < count($jegyek[$i]); $j++) {
        fwrite($csv,"'" . $jegyek[$i][$j] . "'");

        if($j+1 != count($jegyek[$i]))
            fwrite($csv, ",");
    }
    fwrite($csv, "\n");
}
fwrite($csv, "\n\n");

for($i = 0; $i < count($hirek); $i++) {
    for($j = 0; $j < count($hirek[$i]); $j++) {
        fwrite($csv,"'" . $hirek[$i][$j] . "'");

        if($j+1 != count($hirek[$i]))
            fwrite($csv, ",");
    }
    fwrite($csv, "\n");
}
fwrite($csv, "\n\n");

fclose($csv);
header("Location: generated_csv/SZEMELYES_ADATOK_ID_" . $_SESSION["userid"] . ".csv");

?>