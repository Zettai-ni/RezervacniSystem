<!DOCTYPE html>
<?php
session_start();
include('db.php');
// var_dump($poleSedadel);

$dny = array(
    "1" => "pondělí",
    "2" => "úterý",
    "3" => "středa",
    "4" => "čtvrtek",
    "5" => "pátek",
    "6" => "sobota",
    "7" => "neděle"
);

$mesice = array(
    "1" => "ledna",
    "2" => "února",
    "3" => "března",
    "4" => "dubna",
    "5" => "května",
    "6" => "června",
    "7" => "července",
    "5" => "srpna",
    "6" => "září",
    "7" => "října",
    "5" => "listopadu",
    "6" => "prosince"
)
?>
<html>

<?php include('head.php'); ?>

<body>
    <?php include('header.php'); ?>
    <a href="index.php">
        <h1 class="nadpis">CINETEK</h1>
    </a>
    <div class="maindiv">

        <div class="rezervace">
            <?php
            $sql = "SELECT nazev, id_salu, dayofweek(datum), day(datum), month(datum), substring(zacatek,1,5) 
                    FROM představení p INNER JOIN filmy f USING(id_filmu) WHERE id_predstaveni = $_GET[p]";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<h2>Rezervace filmu <div style='color:#27086b;display:inline;'>" . $row['nazev'] . "</div></h2>";
                    echo "<h3>Sál " . $row['id_salu'] . ", " . $dny[$row['dayofweek(datum)']] . " " .
                        $row['substring(zacatek,1,5)'] . " " . $row['day(datum)'] . ". " . $mesice[$row['month(datum)']] . "</h3>";
                }
            }
            ?>
            <!-- Sál 7, Úterý 11:15 27.listopadu 2023 -->

            <?php
            echo "<form method='post' action='rezervace.php?p=$_GET[p]'>";
            ?>
            <table class="sedadla">
                <tr>
                    <td></td>
                    <?php

                    $sql = "SELECT * FROM sály s INNER JOIN představení p USING(id_salu) WHERE id_predstaveni = $_GET[p]";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $pocetSedadel = $row['pocetSedacek'];
                            $pocetRad = $row['pocetRad'];
                        }
                    }

                    $poleSedadel = array();

                    for ($rada = 1; $rada <= $pocetRad; $rada++) {
                        for ($sedadlo = 1; $sedadlo <= $pocetSedadel; $sedadlo++) {
                            $poleSedadel[$rada][$sedadlo] = chr($rada + 64) . $sedadlo;
                        }
                    }

                    for ($sedadlo = 1; $sedadlo <= $pocetSedadel; $sedadlo++) {
                        echo "<td>$sedadlo</td>";
                    }
                    echo "</tr>";
                    $vybrana = array();
                    foreach ($poleSedadel as $rada => $radaSedadel) {
                        echo "<tr><td style='width:48px;'>" . chr($rada + 64) . "</td>";
                        foreach ($radaSedadel as $sedadlo => $oznaceni) {
                            // print_r($oznaceni);
                            echo "<td><label class='container'>";
                            echo "<input type='checkbox' name='vybrana[]' value='$oznaceni'";
                            if (isset($_POST['vybrana']) && in_array($oznaceni, $_POST['vybrana'])) echo " checked='checked'";
                            echo "><span class='checkmark'></span></label></td>";
                        }
                        echo "</tr>";
                    }

                    ?>
            </table>
            <button type="submit" name="submit">Vybrat místa</button>
            </form>
            <?php
            if (isset($_POST['submit'])) {
                if (!empty($_POST['vybrana'])) {
                    echo "<form class='potvrzenivyberu'>";
                    echo "<table>";
                    echo "<tr><td>Sedadlo</td><td>Typ</td><td>Cena</td></tr>";
                    foreach ($poleSedadel as $rada => $radaSedadel) {
                        foreach ($radaSedadel as $sedadlo => $oznaceni) {
                            if (in_array($oznaceni, $_POST['vybrana'])) {

                                echo "<tr>";
                                echo "<td>" . chr($rada + 64) . $sedadlo . "</td>";
                                echo "<td><select>";
                                echo "<option>Dítě</option>";
                                echo "<option>Student</option>";
                                echo "<option>Dospělý</option>";
                                echo "<option>Senior</option>";
                                echo "</select></td>";
                                echo "<td>159Kč</td>";
                                echo "</tr>";
                            }
                        }
                    }



                    echo "</table>";
                    echo "Celkem: 0Kč<br>";
                    echo "<button type='submit' name='submit'>Potvrdit sedadla</button>";
                    echo "</form>";

                    // print_r($poleSedadel);

                } else echo "<div class='chyba'>Nebyla vybrána žádná sedadla!</div>";
            }
            ?>
        </div>
    </div>
    <?php include('footer.php'); ?>
</body>

</html>