<header>

    
    

    <div class="form-popup" id="prihlaseni">
        <form action="" class="form-container">
            <h2 style="font-size:2rem;margin:0 0 1rem 0">Přihlášení</h2>
            <input type="text" placeholder="Uživatelské jméno" name="username" class="username" required>
            <input type="password" placeholder="Heslo" name="pwd" class="password" required>

            <button type="submit" class="login">Login</button>
            <button type="button" class="close" onclick="closePrihlaseni()">Close</button>
            
        </form>
        <button id="btnReg" onclick="openRegistrace()">Registrace</button>
    </div>

    <div class="form-popup" id="registrace">
        <form action="" class="form-container">
            <h2 style="font-size:2rem;margin:0 0 1rem 0">Registrace</h2>
            <input type="text" placeholder="Uživatelské jméno" name="username" class="username" required>
            <input type="text" placeholder="Email" name="email" class="email" required>
            <input type="password" placeholder="Heslo" name="pwd" class="password" required>
            <input type="password" placeholder="Opakuj heslo" name="pwdRepear" class="password" required>

            <button type="submit" class="registrace">Registrovat</button>
            <button type="button" class="close" onclick="closeRegistrace()">Close</button>

        </form>
        
    </div>

    <button id="btnPri" onclick="openPrihlaseni()">Přihlásit se</button>

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