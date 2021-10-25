<?php
    include_once("../sql/db_conn.php");

    if(isset($_GET["jarat"])) {
        $get_data = $sql->query("SELECT * FROM jarat WHERE megnevezes = '" . $_GET["jarat"] . "'");

        $rows = $get_data->fetch_array(MYSQLI_ASSOC);

        echo "<div class='jarat-record' style='background: rgb(44, 50, 255)'><span>" . $_GET["jarat"] . "</span></div>";
        echo "<p id='p-time'>Menetidő: " . $rows["menetido"];
        echo "<p id='p-stopcount'>Megállók száma: " . $rows["megallok_szama"];

        $query_str = "    SELECT megallo.nev, megall.sorszam FROM
                          megall INNER JOIN megallo ON megallo.id = megall.megallo_id
                          WHERE megall.jarat_megnevezes = '" . $_GET["jarat"] . "'
                          ORDER BY megall.sorszam";

        echo "<div id='busstop-container'>";
        echo "<table>";

        $get_data = $sql->query($query_str);

        while($rows = $get_data->fetch_array(MYSQLI_ASSOC)) {
            echo "<tr><td>" . $rows["sorszam"] . "</td><td>" . $rows["nev"] . "</td></tr>";
        }

        echo "</table>";
        echo "</div>";
    }
?>
