<!DOCTYPE html>
<?php
include('db.php');
include('Includes/funkce.php');
?>
<html>
<?php include('head.php'); ?>

<body>
    <?php include('header.php'); ?>
    <a href="index.php">
        <h1 class="nadpis">CINETEK</h1>
    </a>
    <div class="maindiv">
        <div class="blok">
            <h2>Přidat představení</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <div>
                    <label for="film">Film</label>
                    <select class="film" name="film" id="film">
                        <?php
                        $sql = "SELECT id_filmu, nazev FROM filmy;";
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=" . $row['id_filmu'] . ">" . "(" . $row['id_filmu'] . ") " . $row['nazev'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="vyberdata">Datum a čas</label>
                    <input class="vyberdata" type="date" name="datum" id="datum">
                    <input class="vyberdata" type="time" name="cas" id="cas">
                </div>
                <div>
                    <label for="sal">Sál</label>
                    <select class="sal" name="sal" id="sal">
                        <?php
                        $sql = "SELECT * FROM sály;";
                        $result = $db->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value=" . $row['id_salu'] . ">" . $row['id_salu'] . " (" . $row['pocetRad'] . " x " . $row['pocetSedacek'] . ")</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="projektor">Projektor</label>
                    <select class="projektor" name="projektor" id="projektor">
                        <option value="2D">2D</option>
                        <option value="3D">3D</option>
                    </select>


                </div>
                <button class="submit" type="submit" name="pridat">Přidat</button>
            </form>
        </div>
        <?php
        if (isset($_POST['pridat'])) {
            pridatPredstaveni($_POST['film'], $_POST['sal'], $_POST['cas'], $_POST['datum'], $_POST['projektor']);
        }


        ?>


    </div>

    <?php include('footer.php'); ?>
</body>


</html>