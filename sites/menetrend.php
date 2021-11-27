<script type="text/javascript" src="js/menetrend.js"></script>

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
        transition: .5s;
        padding: 5px 35px;
        background: #2c32ff;
        background: rgba(44, 50, 255, .5);
        margin: 5px 5px;
        text-align: center;
    }

    .jarat-record:hover {
        transition: .5s;
        cursor: pointer;
        background: rgba(44, 50, 255, 1);
    }

    .jarat-record span {
        color: white;
        font-weight: bold;
        font-size: 22px;
    }

    #bus-data {
        background: rgba(44, 50, 255, .2);
        border: 1px solid rgb(44, 50, 255);
        margin-top: 25px;
    }

    #busstop-container {
        margin-left: 20px;
    }

    #p-time, #p-stopcount {
        text-align: left;
        text-indent: 20px;
        font-weight: 500;
        font-size: 15px;
        margin-top: 25px;
    }

    #change-day-btn {
        display: block;
        margin: 25px auto;
        width: 30%;
        padding: 20px 0px;
        font-size: 13px;
        background: rgba(44, 50, 255, 1);
        color: white;
        text-transform: uppercase;
        font-weight: bold;
        outline: none;
        border: none;
    }

    #change-day-btn:hover {
        cursor: pointer;
    }
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12" id="jarat-container">
            <p id="jarat-ttl">
                <img src="/img/schedule.png" width="32">
                Menetrend
            <hr size="4">
            </p>

            <div id="jaratok" class="d-flex flex-wrap justify-content-center">
                <?php

                $get_data = $sql->query("SELECT megnevezes FROM jarat ORDER BY megnevezes");

                while($rows = $get_data->fetch_array(MYSQLI_ASSOC)) {
                    echo "<div class='jarat-record'>";
                    echo "    <span>" . $rows["megnevezes"] . "</span>";
                    echo "</div>";
                }

                ?>
            </div>

            <div id="bus-data">

            </div>
        </div>
    </div>
</div>