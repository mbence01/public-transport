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
        <th>ID</th>
        <th>Felhasználónév</th>
        <th>E-mail cím</th>
        <th>Admin</th>
        <th></th>
    </tr>

    <?php

    $get_jaratok = $sql->query("SELECT * FROM felhasznalo ORDER BY id");

    while($rows = $get_jaratok->fetch_array(MYSQLI_ASSOC)) {
        echo "<tr>";
        echo "<td>". $rows["id"] ."</td>";
        echo "<td>". $rows["felhasznalonev"] ."</td>";
        echo "<td>". $rows["email"] ."</td>";
        echo "<td>" . ($rows["admin"] == 0 ? "<span style='color: darkred'>Nem</span>" : "<span style='color: green;'>Igen</span>") . "</td>";
        echo "<td>                
                <a href='php/admin/manageuser.php?type=edit&id=". $rows["id"] ."&admin=" . $rows["admin"] . "'>
                    <img src='img/admin.png' width='16' title='Adminjogosultság módosítása'>
                </a>              
                <a href='php/admin/manageuser.php?type=delete&id=". $rows["id"] ."'>
                    <img src='img/delete.png' width='16' title='Törlés' onclick='return confirm(`Biztosan törölni szeretnéd a felhasználót?`)'>
                </a>
              </td>";
        echo "</tr>";
    }

    ?>
</table>