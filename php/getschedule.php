<?php
include_once("../sql/db_conn.php");

if(isset($_GET["jarat"])) {
    $day = "";

    if(isset($_GET["day"]) && ($_GET["day"] == "hétvége" || $_GET["day"] == "hétköznap"))
        $day = $_GET["day"];
    else
        $day = (date("D") == "Sat" || date("D") == "Sun") ? "hétvége" : "hétköznap";

    $query_str = "SELECT indulasi_ora, GROUP_CONCAT(indulasi_perc ORDER BY indulasi_perc SEPARATOR ' perc, ') AS percek
                    FROM 
                         indul 
                    WHERE 
                        indulasi_nap = '". $day ."' AND jarat_megnevezes = '". $_GET["jarat"] ."' 
                    GROUP BY indulasi_ora 
                    ORDER BY indulasi_ora";

    echo "<div class='jarat-record' style='background: rgb(44, 50, 255); margin: 0;'><span>" . $_GET["jarat"] . " indulások</span></div>";

    echo "<button id='change-day-btn' day='". $day ."' onclick='btnClick(this)'>Váltás ". ($day == "hétvége" ? "hétköznapi" : "hétvégei") ." menetrendre</button>";
    echo "<hr style='height: 2px;'>";

    echo "<div id='busstop-container'>";
    echo "<table style='margin-bottom: 15px;'>";

    $get_data = $sql->query($query_str);

    while($rows = $get_data->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "    <td>";
        echo "        <div class='jarat-record' style='padding: 5px 5px;'>";
        echo "            <span style='font-size: 12px;'>" . $rows["indulasi_ora"] . " óra</span>";
        echo "        </div>";
        echo "    </td>";
        echo "    <td style='font-size: 15px; font-weight: bold; text-transform: uppercase;'>" . $rows["percek"] . " perc</td>";
        echo "</tr>";
    }

    echo "</table>";
    echo "</div>";
}
?>
