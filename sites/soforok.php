<style>
    #soforok-container {
        width: 90%;
        text-align: center;
        margin: 25px auto;
    }

    #sofor-ttl {
        display: block;
        width: 50%;
        text-align: center;
        font-size: 40px;
        font-weight: bold;
        color: grey;
        text-transform: uppercase;
        margin: auto;
    }

    hr {
        margin: auto;
        width: 50%;
    }

    .sofor-record {
        margin: 10px 10px;
        padding: 5px 5px;
        background: rgba(0, 0, 0, .1);
    }

    .name {
        font-size: 18px;
        text-transform: uppercase;
        font-weight: bold;
        color: grey;
        margin-bottom: 0;
        margin-top: 5px;
    }

    .date {
        font-size: 10px;
        color: grey;
        margin: 0;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12" id="soforok-container">
            <p id="sofor-ttl">
                Sofőreink
                <hr size="4">
            </p>

            <div id="main-container" class="d-flex flex-wrap justify-content-center">
                <?php

                include_once('sql/db_conn.php');

                $get_data = $sql->query("SELECT vezeteknev, keresztnev, szemelyi_szam, csatlakozas_datuma FROM sofor ORDER BY vezeteknev, keresztnev");

                while($rows = $get_data->fetch_array(MYSQLI_ASSOC)) {
                    $imgViewerUrl = "ImageViewer.php?table=sofor&selected_field=profil&field=szemelyi_szam&value=" . $rows["szemelyi_szam"];

                    echo "<div class='sofor-record'>";
                    echo "<img src='" . $imgViewerUrl . "' height='180'><br>";
                    echo "<p class='name'>" . $rows["vezeteknev"] . " " . $rows["keresztnev"] . "</p>";
                    echo "<p class='date'>" . $rows["csatlakozas_datuma"] . " óta</p>";
                    echo "</div>";
                }

                ?>
            </div>
        </div>
    </div>
</div>