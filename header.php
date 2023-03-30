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

    <button id="btnOdh"><a href="Includes/logout-include.php">Odhlásit se</a> </button>

    <?php
    if (isset($_GET["error"])) {
        if ($_GET["error"] == "emptyinput") {
            echo "<p style='font-size: 36px;margin: 10px;padding: 15px;color:red'>Fill in all fields!</p>";
        } else if ($_GET["error"] == "wronglogin") {
            echo "<p style='font-size: 36px;margin: 10px;padding: 15px;color:red'>Incorrect login informations!</p>";
        } else if ($_GET["error"] == "invalidUid") {
            echo "<p style='font-size: 36px;margin: 10px;padding: 15px;color:red'>Choose a proper username!</p>";
        } else if ($_GET["error"] == "invalidEmail") {
            echo "<p style='font-size: 36px;margin: 10px;padding: 15px;color:red'>Choose a proper email!</p>";
        } else if ($_GET["error"] == "invalidPassword") {
            echo "<p style='font-size: 36px;margin: 10px;padding: 15px;color:red'>Passwords doesn't match!</p>";
        } else if ($_GET["error"] == "stmtfailed") {
            echo "<p style='font-size: 36px;margin: 10px;padding: 15px;color:red'>Something went wrong, try again!</p>";
        } else if ($_GET["error"] == "usernametaken") {
            echo "<p style='font-size: 36px;margin: 10px;padding: 15px;color:red'>Username or email already taken!</p>";
        } else if ($_GET["error"] == "none") {
            echo "<p style='font-size: 36px;margin: 10px;padding: 15px;color:green'>You have signed up!</p>";
        }
    }
    ?>

    <!-- <a href="profil.php">
        <p style="font-size: 1.5rem;color:white;opacity:0.7;">Přihlásit se</p>
    </a> -->
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
    </script>
<?php
} else {
?>
    <script>
        document.getElementById("btnPri").style.display = "block";
        document.getElementById("btnOdh").style.display = "none";
    </script>
<?php
}
?>