<?php
function pridatObrazek($img, $povoleneTypySouboru, $maxVelikost)
{
    $slozka = "filmy";
    if (!file_exists($slozka)) mkdir($slozka);
    if (isset($_FILES[$img])) {
        if (empty($_FILES[$img]["error"])) {
            if (in_array($_FILES[$img]["type"], $povoleneTypySouboru)) {
                if ($_FILES[$img]["size"] <= $maxVelikost * 1024 * 1024) {

                    move_uploaded_file(
                        $_FILES[$img]["tmp_name"],
                        $slozka . "/" . $_FILES[$img]["name"]
                    );
                    // echo "<p>Soubor '{$_FILES[$img]["name"]}' byl úspěšně nahrán.</p>";
                } else
                    echo "<p>Soubor je příliš velký ({$_FILES[$img]["size"]} B)! Maximální velikost je $maxVelikost MB.</p>";
            } else
                echo "<p>Nevhodný typ souboru!</p>";
        } else {
            switch ($_FILES[$img]["error"]) {
                case 2:
                    echo "<p>Soubor je příliš velký. Překročen limit velikosti ve formuláři</p>";
                    break;
            }
        }
    }
}
function pridatFilm($nazev, $popis, $delka, $pristupnost, $titulni_obrazek, $vedlejsi_obrazek)
{
    include('db.php');
    $sql = "INSERT INTO filmy (nazev, popis, delka, pristupnost, titulni_obrazek, vedlejsi_obrazek) VALUES ('$nazev', '$popis', '$delka', '$pristupnost', '$titulni_obrazek', '$vedlejsi_obrazek')";
    if (mysqli_query($db, $sql)) {
        echo "<p>Film byl úspěšně přidán</p>";
    } else echo "<p>Error</p>: " . mysqli_error($db);
}
function pridatPredstaveni($id_filmu, $id_salu, $zacatek, $datum, $projektor)
{
    include('db.php');
    $sql = "INSERT INTO představení (id_filmu, id_salu, zacatek, datum, projektor) VALUES ('$id_filmu', '$id_salu', '$zacatek','$datum', '$projektor')";
    if (mysqli_query($db, $sql)) {
        echo "<p>Představení bylo úspěšně přidáno</p>";
    } else echo "<p>Error</p>: " . mysqli_error($db);
}
function vypisPredstaveni($filmecky, $row, $porovnavac)
{
    if ($row['datum'] == $porovnavac) {
        // echo $row['datum']." ";
        // echo $porovnavac." ";
        // echo "(".($row['id_filmu']).") ";
        if ($row['id_filmu'] != $filmecky[count($filmecky) - 1]) {
            echo "<tr>";
            echo "<td><a href='film.php?id=" . $row['id_filmu'] . "'><img src='filmy/" . $row['titulni_obrazek'] . "'></a></td>";
        }
        array_push($filmecky, $row['id_filmu']);
        // echo print_r($filmecky);
        // echo "<br>";
        echo "<td class='prdst_cas'><a href='rezervace.php?p=" . $row['id_predstaveni'] . "'>" . $row['substring(zacatek,1,5)'] . "</a></td>";
        if ($row['id_filmu'] != $filmecky[count($filmecky) - 1]) echo "</tr>";
    }

    return $filmecky;
    //print_r($row['id_filmu']);
    //print_r($filmecky);
}
