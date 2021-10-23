<script type="text/javascript" src="js/jaratok.js"></script>

<style>
    #jarat-container {
        width: 80%;
        text-align: center;
        margin: 25px auto;
    }

    #jarat-ttl {
        text-align: left;
        font-size: 22px;
    }

    #jaratok {
        margin-top: 20px;
    }

    .jarat-record {
        padding: 10px 40px;
        background: #2c32ff;
        margin: 5px 5px;
    }

    .jarat-record:hover {
        cursor: pointer;
    }

    .jarat-record span {
        color: white;
        font-weight: bold;
        font-size: 22px;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12" id="jarat-container">
            <p id="jarat-ttl">
                <img src="/img/bus.png" width="32">
                Autóbusz járataink
                <hr size="4">
            </p>

            <div id="jaratok" class="d-flex flex-wrap justify-content-center">
                <?php

                include_once("sql/db_conn.php");

                $get_data = $sql->query("SELECT megnevezes FROM jarat ORDER BY megnevezes");

                while($rows = $get_data->fetch_array(MYSQLI_ASSOC)) {
                    echo "<div class='jarat-record'>";
                    echo "<span>" . $rows["megnevezes"] . "</span>";
                    echo "</div>";
                }

                ?>
            </div>
        </div>
    </div>
</div>