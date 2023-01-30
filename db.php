<?php
$db = mysqli_connect('localhost', 'root', '', 'rezervacni_system');
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}