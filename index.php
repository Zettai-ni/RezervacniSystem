<!DOCTYPE html>
<html>
<?php include('db.php'); ?>
<?php include('head.php'); ?>

<body>
    <?php include('header.php'); ?>
    <a href="index.php">
        <h1 class="nadpis">CINETEK</h1>
    </a>
    <div class="maindiv">
        <div class="blok">
            <h2>Přehled filmů</h2>
            <div class="filmy">
                <?php
                $sql = "SELECT titulni_obrazek, id_filmu FROM filmy;";
                $result = $db->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div><a href='film.php?id=" . $row['id_filmu'] . "'>";
                        echo "<img src='filmy/" . $row['titulni_obrazek'] . "' alt='film" . $row['id_filmu'] . "'>";
                        echo "</a></div>";
                    }
                }
                ?>
            </div>
        <br>
        <div class="blok">
            <h2>Přehled představení</h2>
            <?php
            $filmecky = array();
            $sql = "SELECT id_predstaveni, id_filmu, titulni_obrazek, substring(zacatek,1,5) FROM představení p INNER JOIN filmy f USING(id_filmu) ORDER BY id_filmu";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                echo "<table>";
                while ($row = $result->fetch_assoc()) {
                    if (!in_array($row['id_filmu'], $filmecky)) {
                        echo "<tr>";
                        array_push($filmecky, $row['id_filmu']);
                        echo "<td><a href='film.php?id=" . $row['id_filmu'] . "'><img src='filmy/" . $row['titulni_obrazek'] . "'></a></td>";
                    }
                    echo "<td class='prdst_cas'><a href='rezervace.php?p=" . $row['id_predstaveni'] . "'>" . $row['substring(zacatek,1,5)'] . "</a></td>";

                    if ($row['id_filmu'] != $filmecky[count($filmecky) - 1]) echo "</tr>";
                }
                echo "</table>";
            }
            ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>
<?php include('filmyScroll.php'); ?>