<script type="text/javascript" src="js/ckeditor/ckeditor.js"></script>

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
        width: 100%;
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
        <th>ID</th>
        <th>Cím</th>
        <th>Írta</th>
        <th>Dátum</th>
        <th></th>
    </tr>

    <?php

    $get_news = $sql->query("SELECT hir.id, hir.cim, hir.datum, felhasznalo.felhasznalonev FROM hir INNER JOIN felhasznalo ON felhasznalo.id = hir.irta ORDER BY id");

    if($get_news->num_rows) {
        while ($rows = $get_news->fetch_array(MYSQLI_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $rows["id"] . "</td>";
            echo "<td>" . $rows["cim"] . "</td>";
            echo "<td>" . $rows["felhasznalonev"] . "</td>";
            echo "<td>" . $rows["datum"] . "</td>";
            echo "<td>    
                <a href='php/admin/pinnews.php?id=" . $rows["id"] . "'>
                    <img src='img/pin.png' width='16' title='Rögzítés'>
                </a>    
                     
                <a href='php/admin/deletenews.php?id=" . $rows["id"] . "'>
                    <img src='img/delete.png' width='16' title='Törlés' onclick='return confirm(`Biztosan törölni szeretnéd ezt a hírt?`)'>
                </a>
              </td>";
            echo "</tr>";
        }
    }

    ?>
</table>

<div class="form-container">
    <p id="jarat-ttl">
        <img src="img/add.png" width="32">
        Új hír hozzáadása
    <hr size="4">
    </p>

    <form action="php/admin/addnews.php" method="post">
        <p><input type="text" name="cim" placeholder="Hír címe"></p>
        <p><textarea name="szoveg" id="szoveg"></textarea></p>
        <p><input type="submit" value="Hír rögzítése"></p>
    </form>
</div>

<script>
    ClassicEditor.create( document.querySelector("#szoveg") );
</script>