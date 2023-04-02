<!DOCTYPE html>
<html>
<?php
session_start();
include('db.php');
include('head.php');
include('Includes/funkce.php');
?>

<body>
    <?php include('header.php'); ?>
    <a href="index.php">
        <h1 class="nadpis">CINETEK</h1>
    </a>
    <div class="maindiv">
        <div class="blok">
            <h2>Vaše rezervace</h2>
        </div>

    </div>
    <?php include('footer.php'); ?>
</body>

</html>