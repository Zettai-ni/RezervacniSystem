<!DOCTYPE html>
<?php
session_start();
include('db.php');
include('Includes/funkce.php');
$maxVelikost = 8; // 8MB
$povoleneTypySouboru = [
    "image/jpeg",
    "image/png",
    "image/gif",
    "image/webp",
    "image/avif"
];
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
            <h2>Přidat film</h2>
            <form method="POST" action="" enctype="multipart/form-data">
                <label for="nazev">Název</label>
                <input class="nazevfilmu" type="text" id="nazev" name="nazev" required>
                <label for="popis">Popis</label>
                <textarea class="popisfilmu" name="popis" id="popis" cols="30" rows="10"></textarea>
                <div>
                    <label for="delka">Délka</label>
                    <input class="delkafilmu" type="text" id="delka" name="delka" min="0" max="600">
                </div>
                <div>
                    <label for="pristupnost">Věkové omezení</label>
                    <select class="pristupnostfilmu" name="pristupnost" id="pristupnost">
                        <option value="p1">Všichni</option>
                        <option value="p2">7+</option>
                        <option value="p3">12+</option>
                        <option value="p4">15+</option>
                        <option value="p5">18+</option>
                    </select>
                </div>
                <input type="hidden" name="MAX_FILE_SIZE" value="<?= $maxVelikost * 1024 * 1024 ?>">
                <div>
                    <label for="titulni_obrazek">Titulní obrázek</label>
                    <input class="obrazek" type="file" name="titulni_obrazek" id="titulni_obrazek" accept="<?= implode(", ", $povoleneTypySouboru) ?>">
                </div>
                <div>
                    <label for="vedlejsi_obrazek">Obrázek do pozadí</label>
                    <input class="obrazek" type="file" name="vedlejsi_obrazek" id="vedlejsi_obrazek" accept="<?= implode(", ", $povoleneTypySouboru) ?>">
                </div>
                <button class="submit" type="submit" name="pridat">Přidat</button>
            </form>
        </div>

        <?php
        if (isset($_POST['pridat'])) {
            pridatObrazek('titulni_obrazek', $povoleneTypySouboru, $maxVelikost);
            pridatObrazek('vedlejsi_obrazek', $povoleneTypySouboru, $maxVelikost);
            pridatFilm($_POST['nazev'], $_POST['popis'], $_POST['delka'], $_POST['pristupnost'], $_FILES['titulni_obrazek']['name'], $_FILES['vedlejsi_obrazek']['name']);
        }

        ?>
    </div>

    <?php include('footer.php'); ?>
</body>


</html>