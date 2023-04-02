<!DOCTYPE html>
<?php
session_start();
include('db.php');
include('Includes/funkce.php');

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

                    $obsazena = array();
                    $sql = "SELECT * FROM rezervovaná_sedadla WHERE id_predstaveni = $_GET[p]";
                    $result = $db->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            array_push($obsazena, $row['sedadloOznaceni']);
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
                            echo "<td><label class='container'>";
                            echo "<input type='checkbox' name='vybrana[]' value='$oznaceni'";
                            if (isset($_POST['vybrana']) && in_array($oznaceni, $_POST['vybrana'])) echo " checked='checked'";
                            echo "><span class=";
                            if (!in_array($oznaceni, $obsazena)) echo "'checkmark'";
                            else echo "'vybrana'";
                            echo "></span></label></td>";
                        }
                        echo "</tr>";
                    }

                    ?>
            </table>
            <button type="submit" name="submit">Potvrdit výběr</button>
            </form>
            <?php
            if (isset($_POST['submit'])) {
                if (!empty($_POST['vybrana'])) {
                    if (!isset($_SESSION["jmeno"])) {
                        echo "<div class='chyba'>Musíte se přihlásit!</div>";
                        exit;
                    }
                    $pomPole = array();
                    echo "<form class='potvrzenivyberu' method='POST' action='Includes/rezervace-include.php?p=$_GET[p]'>";
                    echo "<table>";
                    echo "<tr><td>Sedadlo</td><td>Typ</td><td>Cena</td></tr>";
                    foreach ($poleSedadel as $rada => $radaSedadel) {
                        foreach ($radaSedadel as $sedadlo => $oznaceni) {
                            if (in_array($oznaceni, $_POST['vybrana'])) {
                                array_push($pomPole, $oznaceni);
                                echo "<tr>";
                                echo "<td>" . $oznaceni . "</td>";
                                echo "<td><select name='moznost[]' class='vstupenky'>";
                                echo "<option value=''>-- Vyberte možnost --</option>";
                                echo "<option value='70'>Dítě (70Kč)</option>";
                                echo "<option value='150'>Student / Dospělý (150Kč)</option>";
                                echo "<option value='75'>Student + ISIC (75Kč)</option>";
                                echo "<option value='80'>Senior (80Kč)</option>";
                                echo "<td><div class='cena'>0</div></td>";
                                echo "</select></td>";
                                echo "<input type='hidden' name='pomPole[]' value='" . $oznaceni . "'>";
                                echo "</tr>";
                            }
                        }
                    }

                    echo "</table>";
                    echo "Celkem: <div id='sum'>0</div>Kč<br>";
                    echo "<button type='submit' name='rezervace' onclick='kontrola(event)'>Rezervovat</button>";
                    //echo "<button type='submit' name='submit'>Potvrdit sedadla</button>";
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
<script>
    const selects = document.querySelectorAll('.vstupenky');
    const numbers = document.querySelectorAll('.cena');
    const sumElement = document.getElementById('sum');

    let sum = 0;

    for (let i = 0; i < selects.length; i++) {
        const select = selects[i];
        const emptyOption = select.querySelector('option[value=""]');

        select.addEventListener('change', () => {
            if (select.value !== '') {
                emptyOption.disabled = true;
                emptyOption.style.display = 'none';
            }
        });
    }

    selects.forEach((select, index) => {
        select.addEventListener('change', () => {
            updateNumber(select, numbers[index]);
            calculateSum();
        });
    });

    function updateNumber(select, number) {
        number.textContent = select.value;
    }

    function calculateSum() {
        sum = 0;
        numbers.forEach(number => {
            sum += parseInt(number.textContent);
        });
        sumElement.textContent = sum;
    }

    function kontrola(event) {
        var selects = document.getElementsByTagName("select");
        for (var i = 0; i < selects.length; i++) {
            if (selects[i].value === "") {
                event.preventDefault();
                alert("Vyberte prosím možnost ze všech selectů.");
                return;
            }
        }
    }
</script>