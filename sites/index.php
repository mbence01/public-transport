<style>
    #main-container {
        width: 100%;
        margin: 50px auto;
    }

    .news-record {
        width: 80%;
        background: rgba(0, 0, 0, .5);
        margin: auto;
        text-indent: 15px;
        position: relative;
        color: white;
    }

    .news-title {
        display: block;
        padding: 20px 20px;
        width: 100%;
        color: white;
        font-size: 18px;
        font-weight: bold;
        text-transform: uppercase;
        background: rgba(0, 0, 0, .8);
    }

    .date {
        position: absolute;
        bottom: 0;
        right: 15px;
        font-size: 12px;
        font-style: italic;
    }
</style>

<script>
    var max = 10;
    var curr = 2;

    document.body.style.backgroundImage = "url('img/bg/1.jpg')";
    document.body.style.backgroundRepeat = "no-repeat";
    document.body.style.backgroundSize = "cover";

    setInterval(function() {
        document.body.style.backgroundImage = "url('img/bg/" + curr++ + ".jpg')";
        document.body.style.backgroundRepeat = "no-repeat";
        document.body.style.backgroundSize = "cover";

        if(curr > max)
            curr = 1;
    }, 30000);
</script>

<div id="main-container" onload="changeBg()">
    <?php

    include_once("sql/db_conn.php");

    $get_news = $sql->query("SELECT * FROM hir ORDER BY rogzitett DESC, datum ASC");

    while($rows = $get_news->fetch_array(MYSQLI_ASSOC)) {
        echo "<div class='news-record'>
                    <p class='news-title'>" . $rows["cim"] . "</p>
                    " . $rows["szoveg"] . "
                    <p class='date'>" . $rows["datum"] . "</p>
              </div>";
    }

    ?>
</div>