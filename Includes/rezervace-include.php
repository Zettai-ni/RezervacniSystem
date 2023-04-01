<?php
session_start();
include('../db.php');
include('funkce.php');
if (isset($_POST['rezervace'])) {
    $cena = $_POST["moznost"];
    $oznaceni = $_POST['pomPole'];
    $predstaveni = $_GET['p'];

    vytvoritRezervovaneSedadlo($cena, $oznaceni, $predstaveni);

    header("location: ../rezervace.php?p=$predstaveni");
    exit();
}
