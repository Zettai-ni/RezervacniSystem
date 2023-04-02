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
    if ($delka < 60) {
?><script>
            alert("Délka musí být větší jak 1 hodina!");
        </script><?php
                    header("location: index.php");
                    exit();
                }
                $sql = "INSERT INTO filmy (nazev, popis, delka, pristupnost, titulni_obrazek, vedlejsi_obrazek) VALUES ('$nazev', '$popis', '$delka', '$pristupnost', '$titulni_obrazek', '$vedlejsi_obrazek')";
                if (mysqli_query($db, $sql)) {
                    echo "<p>Film byl úspěšně přidán</p>";
                } else echo "<p>Error</p>: " . mysqli_error($db);
            }
            function pridatPredstaveni($id_filmu, $id_salu, $zacatek, $datum, $projektor)
            {
                include('db.php');
                // $sql = "SELECT delka FROM filmy WHERE id_filmu = $id_filmu";
                // $result = $db->query($sql);
                // if ($result->num_rows > 0) {
                //     while ($row = $result->fetch_assoc()) {
                //         $delka = $row['delka'] * 60;
                //         $zacatekPom = DateTime::createFromFormat("H:i:s", $datum);
                //         $zacatekMinusDelka = clone $zacatekPom;
                //         $zacatekMinusDelka->sub(new DateInterval('PT' . $delka . 'S'));
                //         $zacatekMinusDelkaPom = $zacatekMinusDelka->format('H:i:s');

                //         $zacatekPlusDelka = clone $zacatekPom;
                //         $zacatekPlusDelka->add(new DateInterval('PT' . $delka . 'S'));
                //         $zacatekPlusDelkaPom = $zacatekPlusDelka->format('H:i:s');

                //         // echo "<br>Datum minus delka: " . $zacatekMinusDelkaPom . "\n";
                //         // echo "<br>Datum plus delka: " . $zacatekPlusDelkaPom  . "\n";

                //         $sql = "SELECT zacatek FROM predstaveni WHERE datum = $datum AND id_salu = $id_salu";
                //         $result = $db->query($sql);
                //         if ($result->num_rows > 0) {
                //             while ($row = $result->fetch_assoc()) {
                //                 if ($row['zacatek'] >= $zacatekMinusDelkaPom && $row['zacatek'] <= $zacatekPlusDelkaPom) {
                //     ?><script>
                //             alert("V intervalu se již nějaké představení nachází!");
                //         </script><?php
                //                     header("location: index.php");
                //                     exit();
                //                 }
                //             }
                //         }
                //     }
                // } else echo "<p>Error</p>: " . mysqli_error($db);
                $sql = "INSERT INTO představení (id_filmu, id_salu, zacatek, datum, projektor) VALUES ('$id_filmu', '$id_salu', '$zacatek','$datum', '$projektor')";
                if (mysqli_query($db, $sql)) {
                    echo "<p>Představení bylo úspěšně přidáno</p>";
                } else echo "<p>Error</p>: " . mysqli_error($db);
            }
            function vypisPredstaveni($filmecky, $row, $porovnavac)
            {
                if ($row['datum'] == $porovnavac) {
                    if ($row['id_filmu'] != $filmecky[count($filmecky) - 1]) {
                        echo "<tr>";
                        echo "<td><a href='film.php?id=" . $row['id_filmu'] . "'><img src='filmy/" . $row['titulni_obrazek'] . "'></a></td>";
                    }
                    array_push($filmecky, $row['id_filmu']);
                    echo "<td class='prdst_cas'><p style='margin-bottom: 0;'>Sál " . $row['id_salu'] . "</p><a href='rezervace.php?p=" . $row['id_predstaveni'] . "'>" . $row['substring(zacatek,1,5)'] . "</a></td>";
                    if ($row['id_filmu'] != $filmecky[count($filmecky) - 1]) echo "</tr>";
                }

                return $filmecky;
            }
            function vytvoritRezervaci($uzivatel)
            {
                include('../db.php');
                $sql = "INSERT INTO rezervace (id_uzivatele) VALUES ('$uzivatel')";
                if (mysqli_query($db, $sql)) {
                    echo "<p>Rezervace úspěšně vytvořena (1)</p>";
                } else echo "<p>Error</p>: " . mysqli_error($db);
            }

            function vytvoritRezervovaneSedadlo($poleCen, $poleOznaceni, $predstaveni)
            {
                vytvoritRezervaci($_SESSION['id_uzivatele']);

                include('../db.php');
                $sql = "SELECT id_rezervace FROM rezervace ORDER BY id_rezervace DESC LIMIT 1";
                $result = mysqli_query($db, $sql);
                if ($result) {
                    $row = mysqli_fetch_array($result);
                    $id_r = $row['id_rezervace'];
                    echo "<p>Rezervace úspěšně vytvořena (2)</p>";
                } else echo "<p>Error</p>: " . mysqli_error($db);
                foreach ($poleCen as $index => $cena) {
                    if (isset($poleOznaceni[$index])) {
                        $oznaceni = $poleOznaceni[$index];
                        $sql = "INSERT INTO rezervovaná_sedadla (id_rezervace, id_predstaveni, sedadloOznaceni, cena) VALUES ('$id_r','$predstaveni','$oznaceni','$cena')";
                        if (mysqli_query($db, $sql)) {
                            echo "<p>Rezervace úspěšně vytvořena (4)</p>";
                        } else echo "<p>Error</p>: " . mysqli_error($db);
                    }
                }

                $cisla = array_map('intval', $poleCen);
                $sum = array_sum($cisla);

                $sql = "UPDATE rezervace SET cena = $sum WHERE id_rezervace = $id_r";
                if (mysqli_query($db, $sql)) {
                    echo "<p>Cena přičtena</p>";
                } else echo "<p>Error</p>: " . mysqli_error($db);
            }
