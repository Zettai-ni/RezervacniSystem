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
            <h2>Aktuální nabídka filmů
                <?php
                if (isset($_SESSION["jmeno"])) {
                    $jmeno = $_SESSION["jmeno"];
                    $sql = "SELECT prava FROM uživatelé WHERE jmeno LIKE '$jmeno'";
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        $row = mysqli_fetch_array($result);
                        if ($row['prava'] == 'admin') {
                            echo "<div class='vytvorit'><a href='addfilm.php'>Vytvořit</a></div>";
                        }
                    }
                }
                ?>
            </h2>

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
        </div>
        <br>
        <div class="blok" style="min-height:50rem;">
            <h2>Přehled představení
                <?php
                if (isset($_SESSION["jmeno"])) {
                    $jmeno = $_SESSION["jmeno"];
                    $sql = "SELECT prava FROM uživatelé WHERE jmeno LIKE '$jmeno'";
                    $result = mysqli_query($db, $sql);
                    if ($result) {
                        $row = mysqli_fetch_array($result);
                        if ($row['prava'] == 'admin' || $row['prava'] == 'zamestnanec') {
                            echo "<div class='vytvorit'><a href='addpredstaveni.php'>Vytvořit</a></div>";
                        }
                    }
                }
                ?>

            </h2>

            <form action="" method="POST" onsubmit="saveScrollPosition()">
                <button name="zpet" type="zpet">◄</button>
                <input name="date" type="date" value=<?php
                                                        if (isset($_POST['zpet'])) {
                                                            echo date('Y-m-d', strtotime($_POST['date'] . '-1 day'));
                                                        } else if (isset($_POST['dalsi'])) {
                                                            echo date('Y-m-d', strtotime($_POST['date'] . '+1 day'));
                                                        } else if (isset($_POST['date'])) {
                                                            echo $_POST['date'];
                                                        } else echo date("Y-m-d"); ?>>
                <button name="dalsi" type="dalsi">►</button>
                <button type="search">Potvrdit výběr</button>
            </form>

            <script>
                function saveScrollPosition() {
                    var scrollPosition = window.pageYOffset || document.documentElement.scrollTop;
                    document.cookie = "scrollPosition=" + scrollPosition;
                }
            </script>
            <?php
            if (isset($_POST['date'])) {
                $scrollPosition = $_COOKIE['scrollPosition'];
                echo "<script>window.scrollTo(0, $scrollPosition);</script>";

                $datum = $_POST['date'];
            }
            ?>


            <?php
            $filmecky = array();
            array_push($filmecky, '0');
            $sql = "SELECT id_predstaveni, id_filmu, titulni_obrazek, datum, substring(zacatek,1,5) FROM představení p INNER JOIN filmy f USING(id_filmu) ORDER BY id_filmu";
            $result = $db->query($sql);
            if ($result->num_rows > 0) {
                echo "<table>";
                while ($row = $result->fetch_assoc()) {

                    if (isset($_POST['date'])) {
                        if (isset($_POST['zpet'])) {
                            $filmecky = vypisPredstaveni($filmecky, $row, date('Y-m-d', strtotime($_POST['date'] . '-1 day')));
                        } else if (isset($_POST['dalsi'])) {
                            $filmecky = vypisPredstaveni($filmecky, $row, date('Y-m-d', strtotime($_POST['date'] . '+1 day')));
                        } else {
                            $filmecky = vypisPredstaveni($filmecky, $row, $_POST['date']);
                        }
                    }
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