<script type="text/javascript" src="js/createroute.js"></script>

<style>
    #jaratok-tbl {
        width: 100%;
        margin: 20px auto 50px auto;
        text-align: center;
    }

    #jaratok-tbl th {
        font-size: 17px;
        text-transform: uppercase;
        background: rgba(44, 50, 255, .5);
        height: 50px;
    }

    #jaratok-tbl tr:nth-child(odd) {
        background: rgba(44, 50, 255, .3);
    }

    #jarat-ttl {
        text-align: left;
        font-size: 22px;
    }

    input {
        outline: none;
        border: 1px solid rgb(44, 50, 255);
        width: 25%;
        font-size: 13px;
        height: 30px;
        text-indent: 5px;
    }

    input[type="submit"] {
        width: 50%;
        background: rgb(44, 50, 255);
        color: white;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 16px;
        height: 40px;
    }

    .form-container {
        background: rgba(44, 50, 255, .2);
        padding: 25px 25px;
        margin-top: 50px;
        text-align: center;
    }
</style>

<div class="form-container">
    <p id="jarat-ttl">
        <img src="img/add.png" width="32">
        Új járat készítése
    <hr size="4">
    </p>

    <form action="php/admin/createroute.php" method="post">
        <?php

        $get_routes = $sql->query("SELECT megnevezes FROM jarat ORDER BY megnevezes");

        echo "<p>";
        echo "Járat: <select name='jarat'>";

        while($rows = $get_routes->fetch_array(MYSQLI_ASSOC)) {
            echo "<option value='" . $rows["megnevezes"] . "'>" . $rows["megnevezes"] . "</option>";
        }

        echo "</select>";
        echo "</p>";

        ?>

        <p>
            <input type="number" min="1" name="menetido" placeholder="Menetidő"> perc
        </p>

        <p>
            <input type="number" min="1" name="megallok_szama" placeholder="Megállók száma" id="stopcount"> db megálló
        </p>

        <div id="stops-container" count="0">

        </div>

        <p><input type="submit" value="Hozzáadás" id="edit"></p>
    </form>
</div>