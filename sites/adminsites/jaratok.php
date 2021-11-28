<script type="text/javascript" src="js/editroute.js"></script>

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
        margin-bottom: 50px;
        text-align: center;
    }
</style>

<table id="jaratok-tbl">
    <tr>
        <th>Megnevezés</th>
        <th>Menetidő</th>
        <th>Megállók száma</th>
        <th></th>
    </tr>

    <?php

    $get_jaratok = $sql->query("SELECT * FROM jarat ORDER BY megnevezes");

    while($rows = $get_jaratok->fetch_array(MYSQLI_ASSOC)) {
        $data = $rows["megnevezes"] . "," . $rows["menetido"] . "," . $rows["megallok_szama"];

        echo "<tr>";
        echo "<td>". $rows["megnevezes"] ."</td>";
        echo "<td>". $rows["menetido"] ." perc</td>";
        echo "<td>". $rows["megallok_szama"] ." db</td>";
        echo "<td>
                <a href='index.php?page=admin&menu=jaratok#edit' onclick='fillForm(`". $data ."`)'>
                    <img src='img/edit.png' width='16' title='Módosítás'>
                </a>
                
                <a href='php/admin/manageroute.php?type=delete&id=". $rows["megnevezes"] ."'>
                    <img src='img/delete.png' width='16' title='Törlés' onclick='return confirm(`Biztosan törölni szeretnéd a járatot?`)'>
                </a>
              </td>";
        echo "</tr>";
    }

    ?>
</table>

<div class="form-container">
    <p id="jarat-ttl">
        <img src="img/add.png" width="32">
        Új járat hozzáadása
        <hr size="4">
    </p>

    <form action="php/admin/manageroute.php?type=add" method="post">
        <p><input type="text" name="megnevezes" placeholder="Járat megnevezése"></p>
        <p><input type="number" name="menetido" placeholder="Menetidő"> perc</p>
        <p><input type="number" name="megallok_szama" placeholder="Megállók száma"> db megálló</p>
        <p><input type="submit" value="Hozzáadás" id="edit"></p>
    </form>
</div>

<div class="form-container">
    <p id="jarat-ttl">
        <img src="img/edit.png" width="32">
        Járat szerkesztése
        <hr size="4">
    </p>

    <form action="php/admin/manageroute.php?type=edit" method="post">
        <p><input type="text" name="megnevezes" id="input_megnevezes"></p>
        <p><input type="number" name="menetido" id="input_menetido"> perc</p>
        <p><input type="number" name="megallok_szama" id="input_megallok_szama"> db megálló</p>

        <p style="color: darkred; font-size: 10px;">Használd a fenti táblázatban található Módosítás ikont!</p>

        <p><input type="submit" value="Módosítás"></p>
    </form>
</div>