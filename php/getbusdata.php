<?php
    include_once("../sql/db_conn.php");

    if(isset($_GET["jarat"])) {
        $get_data = $sql->query("SELECT * FROM jarat WHERE megnevezes = '" . $_GET["jarat"] . "'");

        $rows = $get_data->fetch_array(MYSQLI_ASSOC);

        echo "<div class='jarat-record' style='background: rgb(44, 50, 255); margin: 0;'><span>" . $_GET["jarat"] . "</span></div>";
        echo "<p id='p-time'>Menetidő: " . $rows["menetido"] . " perc";
        echo "<p id='p-stopcount'>" . $rows["megallok_szama"] . " db megálló";
        echo "<hr style='height: 2px;'>";

        $query_str = "    SELECT megallo.nev, megall.sorszam FROM
                          megall INNER JOIN megallo ON megallo.id = megall.megallo_id
                          WHERE megall.jarat_megnevezes = '" . $_GET["jarat"] . "'
                          ORDER BY megall.sorszam";

        echo "<div id='busstop-container'>";
        echo "<table>";

        $get_data = $sql->query($query_str);

        while($rows = $get_data->fetch_array(MYSQLI_ASSOC)) {
            echo "<tr>";
            echo "    <td>";
            echo "        <div class='jarat-record' style='padding: 5px 5px;'>";
            echo "            <span style='font-size: 12px;'>" . $rows["sorszam"] . ".</span>";
            echo "        </div>";
            echo "    </td>";
            echo "    <td style='font-size: 15px; font-weight: bold; text-transform: uppercase;'>" . $rows["nev"] . "</td>";
            echo "</tr>";
        }

        echo "</table>";
        echo "</div>";
    }
?>
