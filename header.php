<header>
    <div class="form-popup" id="prihlaseni">
        <form action="Includes/login-include.php" method="post" class="form-container">
            <h2 style="font-size:2rem;margin:0 0 1rem 0">Přihlášení</h2>
            <input type="text" placeholder="Uživatelské jméno" name="username" class="username" required>
            <input type="password" placeholder="Heslo" name="pwd" class="pwd" required>

            <button type="submit" name="submit" class="login">Login</button>
            <button type="button" class="close" onclick="closePrihlaseni()">Close</button>

        </form>
        <button id="btnReg" onclick="openRegistrace()">Registrace</button>
    </div>

    <div class="form-popup" id="registrace">
        <form action="Includes/signup-include.php" method="post" class="form-container">
            <h2 style="font-size:2rem;margin:0 0 1rem 0">Registrace</h2>
            <input type="text" placeholder="Uživatelské jméno" name="username" class="username" required>
            <input type="text" placeholder="Email" name="email" class="email" required>
            <input type="password" placeholder="Heslo" name="pwd" class="pwd" required>
            <input type="password" placeholder="Opakuj heslo" name="pwdrepeat" class="pwd" required>

            <button type="submit" name="submit" class="registrace">Registrovat</button>
            <button type="button" class="close" onclick="closeRegistrace()">Close</button>

        </form>

    </div>

    <button id="btnPri" onclick="openPrihlaseni()">Přihlásit se</button>

    <button id="btnPro"><a href="profil.php">Profil <?php echo $_SESSION["jmeno"]?></a> </button>

    <button id="btnOdh"><a href="Includes/logout-include.php">Odhlásit se</a> </button>

    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            ?><script>alert("Vyplň všechna políčka!");</script><?php
        } else if ($_GET["error"] == "wronglogin") {
            ?><script>alert("Špatné přihlašovací údaje!");</script><?php
        } else if ($_GET["error"] == "invalidUid") {
            ?><script>alert("Zvol vhodnější username!");</script><?php
        } else if ($_GET["error"] == "invalidEmail") {
            ?><script>alert("Zvol vhodnější mail!");</script><?php
        } else if ($_GET["error"] == "invalidPassword") {
            ?><script>alert("Špatně zadané heslo!");</script><?php
        } else if ($_GET["error"] == "stmtfailed") {
            ?><script>alert("Něco se pokazilo, zkus to znovu!");</script><?php
        } else if ($_GET["error"] == "usernametaken") {
            ?><script>alert("username nebo email je již používán!");</script><?php
        } else if ($_GET["error"] == "none") {
            echo "<p class='chyba' style='background:green'>Úspěšně zaregistrováno</p>";
        }
    }
    ?>

</header>
<script>
    document.getElementById("prihlaseni").style.display = "none";
    document.getElementById("registrace").style.display = "none";
    document.getElementById("btnPri").style.display = "block";
    document.getElementById("btnReg").style.display = "none";

    function openPrihlaseni() {
        document.getElementById("prihlaseni").style.display = "block";
        document.getElementById("registrace").style.display = "none";
        document.getElementById("btnPri").style.display = "none";
        document.getElementById("btnReg").style.display = "block";
    }

    function closePrihlaseni() {
        document.getElementById("prihlaseni").style.display = "none";
        document.getElementById("registrace").style.display = "none";
        document.getElementById("btnPri").style.display = "block";
        document.getElementById("btnReg").style.display = "none";
    }

    function openRegistrace() {
        document.getElementById("prihlaseni").style.display = "none";
        document.getElementById("registrace").style.display = "block";
        document.getElementById("btnPri").style.display = "none";
        document.getElementById("btnReg").style.display = "none";
    }

    function closeRegistrace() {
        document.getElementById("prihlaseni").style.display = "block";
        document.getElementById("registrace").style.display = "none";
        document.getElementById("btnPri").style.display = "none";
        document.getElementById("btnReg").style.display = "block";
    }
</script>
<?php
if (isset($_SESSION["jmeno"])) {
?>
    <script>
        document.getElementById("btnPri").style.display = "none";
        document.getElementById("btnOdh").style.display = "block";
        document.getElementById("btnPro").style.display = "block";
    </script>
<?php
} else {
?>
    <script>
        document.getElementById("btnPri").style.display = "block";
        document.getElementById("btnOdh").style.display = "none";
        document.getElementById("btnPro").style.display = "none";
    </script>
<?php
}
?>