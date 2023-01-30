<!DOCTYPE html>
<?php
include('db.php');
?>
<html>
<?php include('head.php'); ?>

<body style="overflow-x: hidden;">
    <?php include('header.php'); ?>
    <a href="index.php">
        <h1 class="nadpis">CINETEK</h1>
    </a>
    <div class="maindiv">
        <div class="blok">
            <?php
            if (isset($_GET["id"])) {
                $sql = "SELECT * FROM filmy WHERE id_filmu={$_GET['id']}";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<img class='ved_obrazek' src='filmy/" . $row['vedlejsi_obrazek'] . "' alt='film" . $row['id_filmu'] . "'>";
                        echo "<h2><div style='color:#27086b;display:inline;'>" . $row['nazev'] . "</div></h2>";
                        echo "<p>" . $row['popis'] . "</p>";
                        echo "<p><b>Věkové omezení</b>: " . $row['pristupnost'] . "</p>";
                        echo "<p><b>Délka filmu</b>: " . $row['delka'] . " minut</p>";
                    }
                }
            }
            ?>
        </div>



    </div>

    <?php include('footer.php'); ?>
</body>

</html>