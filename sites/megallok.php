<style>
    #megallo-container {
        width: 80%;
        text-align: center;
        margin: 25px auto;
    }

    #megallo-ttl {
        text-align: left;
        font-size: 22px;
    }

    #megallok {
        width: 100%;
        margin: 0 auto;
        border: 1px solid rgba(0, 0, 0, .1);
        text-indent: 5px;
    }

    #megallok tr th {
        height: 50px;
        background: rgba(0, 0, 0, .2);
    }

    #megallok tr:nth-child(odd) {
        background: rgba(0, 0, 0, .1);
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12" id="megallo-container">
            <p id="megallo-ttl">
                <img src="/img/busstop.png" width="32">
                Mucsaröcsöge buszmegállóinak listája
            <hr size="4">
            </p>

            <table id="megallok">
                <tr>
                    <th style="width: 20%">
                        <a href="index.php?page=megallo&sortby=id<?php echo desc(); ?>">
                            Azonosító
                            <?php
                            if(isset($_GET["desc"]) and $_GET["sortby"] == "id")
                                echo "<img align='absmiddle' src='img/down.png' width='16'>";
                            else
                                echo "<img align='absmiddle' src='img/down.png' width='16' style='transform: scaleY(-1)'>";
                            ?>
                        </a>
                    </th>
                    <th style="width: 30%">
                        <a href="index.php?page=megallo&sortby=nev<?php echo desc(); ?>">
                            Megnevezés
                            <?php
                            if(isset($_GET["desc"]) and $_GET["sortby"] == "nev")
                                echo "<img align='absmiddle' src='img/down.png' width='16'>";
                            else
                                echo "<img align='absmiddle' src='img/down.png' width='16' style='transform: scaleY(-1)'>";
                            ?>
                        </a>
                    </th>
                    <th style="width: 50%">
                        <a href="index.php?page=megallo&sortby=change<?php echo desc(); ?>">
                            Átszállási lehetőség
                            <?php
                            if(isset($_GET["desc"]) and $_GET["sortby"] == "change")
                                echo "<img align='absmiddle' src='img/down.png' width='16'>";
                            else
                                echo "<img align='absmiddle' src='img/down.png' width='16' style='transform: scaleY(-1)'>";
                            ?>
                        </a>
                    </th>
                </tr>

                <?php

                $get_data = null;

                if(isset($_GET["sortby"])) {
                    if($_GET["sortby"] == "nev")
                        $get_data = $sql->query("SELECT * FROM megallo ORDER BY nev" . (isset($_GET["desc"]) ? " DESC" : ""));
                    else if($_GET["sortby"] == "id")
                        $get_data = $sql->query("SELECT * FROM megallo ORDER BY id" . (isset($_GET["desc"]) ? " DESC" : ""));
                    else if($_GET["sortby"] == "change")
                        $get_data = $sql->query("SELECT megallo.id, megallo.nev, COUNT(megall.megallo_id) FROM megallo INNER JOIN megall ON megall.megallo_id = megallo.id GROUP BY megall.megallo_id ORDER BY COUNT(megall.megallo_id)" . (isset($_GET["desc"]) ? " DESC" : ""));
                } else {
                    $get_data = $sql->query("SELECT * FROM megallo ORDER BY nev" . (isset($_GET["desc"]) ? " DESC" : ""));
                }

                while($rows = $get_data->fetch_array(MYSQLI_ASSOC)) {
                    $get_changes = $sql->query("SELECT jarat_megnevezes FROM megall WHERE megallo_id = " . $rows["id"]);
                    $list = "";

                    while($changes = $get_changes->fetch_array(MYSQLI_ASSOC)) {
                        $list .= $changes["jarat_megnevezes"] . " ";
                    }

                    echo "<tr>";
                    echo "    <td>" . $rows["id"] . "</td>";
                    echo "    <td>" . $rows["nev"] . "</td>";
                    echo "    <td>" . $list . "</td>";
                    echo "</tr>";
                }

                ?>
            </table>
        </div>
    </div>
</div>

<?php

function desc() {
    if(isset($_GET["desc"])) {
        if($_GET["desc"] == 0)
            return "&desc=1";
        return "";
    } else return "&desc=1";
}

?>