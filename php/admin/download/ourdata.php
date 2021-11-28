<?php

session_start();

if(!isset($_SESSION["logged"]) or (isset($_SESSION["logged"]) and !$_SESSION["logged"]) or $_SESSION["admin"] == 0 or $_SERVER["REQUEST_METHOD"] != "POST")
    http_response_code(403);

include_once("../../../sql/db_conn.php");

$data = [];


//Buszok
$query_str = "
    SELECT 
           rendszam, tipus, ev, CONCAT(vezeteknev, ' ', keresztnev, '(', szemelyi_szam, ')') AS nev 
    FROM busz
        INNER JOIN sofor ON sofor.szemelyi_szam = sofor_szemelyi_szam";

array_push($data, [ "Rendszám", "Típus", "Évjárat", "Hozzárendelt sofőr" ]);

$get_buses = $sql->query($query_str);

while($rows = $get_buses->fetch_array(MYSQLI_ASSOC)) {
    $temp = [];

    array_push($temp, $rows["rendszam"]);
    array_push($temp, $rows["tipus"]);
    array_push($temp, $rows["ev"]);
    array_push($temp, $rows["nev"]);

    array_push($data, $temp);
}
array_push($data, [ "\n\n" ]);



//Járatok
$query_str = "
    SELECT 
           megnevezes, menetido, megallok_szama, COUNT(megall.megallo_id) AS tenyleges_megallok_szama
    FROM jarat
    INNER JOIN megall ON megall.jarat_megnevezes = megnevezes
    GROUP BY jarat.megnevezes";

array_push($data, [ "Megnevezés", "Menetidő", "Megállók száma", "Tényleges megállók száma" ]);

$get_routes = $sql->query($query_str);

while($rows = $get_routes->fetch_array(MYSQLI_ASSOC)) {
    $temp = [];

    array_push($temp, $rows["megnevezes"]);
    array_push($temp, $rows["menetido"]);
    array_push($temp, $rows["megallok_szama"]);
    array_push($temp, $rows["tenyleges_megallok_szama"]);

    array_push($data, $temp);
}
array_push($data, [ "\n\n" ]);



//Sofőrök
$query_str = "
    SELECT 
           CONCAT(vezeteknev, ' ', keresztnev) AS nev, szemelyi_szam, csatlakozas_datuma
    FROM sofor";

array_push($data, [ "Név", "Személyi szám", "Csatlakozás dátuma" ]);

$get_drivers = $sql->query($query_str);

while($rows = $get_drivers->fetch_array(MYSQLI_ASSOC)) {
    $temp = [];

    array_push($temp, $rows["nev"]);
    array_push($temp, $rows["szemelyi_szam"]);
    array_push($temp, $rows["csatlakozas_datuma"]);

    array_push($data, $temp);
}
array_push($data, [ "\n\n" ]);


$content = "";

foreach($data as $arr) {
    $len = count($arr);
    $i = 0;

    if($arr === [ "\n\n" ]) {
        $content .= "\n\n";
        continue;
    }

    foreach($arr as $elem) {
        $content .= "'$elem'";

        if(++$i != $len)
            $content .= ",";
    }
    $content .= "\n";
}

file_put_contents("generated_csv/CEGADATOK.csv", $content);

header("Location: generated_csv/CEGADATOK.csv");

?>