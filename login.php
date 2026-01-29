<?php
session_start();
require "config/db.php";

/*
AI-USE: Gemini
Käytettynä apuna taulujen tiedon hakemiseen ja tilojen hakemiseen
*/
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    try {
        $stmt = $pdo->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user["password"])) {

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["email"] = $user["email"];

            header("Location: plans.php");
            exit;
        } else {
            $error = "Virheellinen sähköpostiosoite tai salasana.";
        }
    } catch (PDOException $e) {
        $error = "Tietokantavirhe: " . $e->getMessage();
    }
}
/*AI-USE END*/
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirjaudu - Kaavakanta</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-left">
        <span class="company-name">Kaavakanta</span>
    </div>

    <div class="burger" id="burgerBtn">&#9776;</div>

    <div class="nav-right" id="navMenu">
        <a href="index.php">Etusivu</a>
        <a href="plans.php">Kaavaehdotukset</a>
        <a href="login.php">Rekisteröidy</a>
    </div>
</nav>

<div style="max-width: 400px; margin: 50px auto; padding: 20px; text-align: center; border: 1px solid #ddd; border-radius: 8px;">
    <h2>Kirjautuminen</h2>

    <?php if ($error): ?>
        <p style="color:red; background: #fee; padding: 10px; border-radius: 5px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <form method="POST">
        <input type="email" name="email" placeholder="Sähköpostiosoite" style="width:100%; padding: 10px; margin-bottom: 15px; box-sizing: border-box;" required>
        <br>
        <input type="password" name="password" placeholder="Salasana" style="width:100%; padding: 10px; margin-bottom: 15px; box-sizing: border-box;" required>
        <br>
        <button type="submit" style="width: 100%; padding: 10px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Kirjaudu
        </button>
    </form>
    
    <p style="margin-top: 20px;">
        Eikö sinulla ole tunnusta? <a href="signup.php">Rekisteröidy täältä</a>
    </p>
</div>
<footer class="footer">
    <p>© 2026 Erik Cerrada Plumed</p>
    <p>Savon Ammattiopisto</p>
</footer>
<script>
//AI-USE: ChatGPT
//Käytettynä apuna navbar burgeri nappi avaamiseen
const burgerBtn = document.getElementById('burgerBtn');
    const navMenu = document.getElementById('navMenu');

    if (burgerBtn && navMenu) {

        burgerBtn.addEventListener('click', function(e) {
            e.stopPropagation();
            navMenu.classList.toggle('active');
        });

        document.addEventListener('click', function(event) {
            const isClickInside = navMenu.contains(event.target) || burgerBtn.contains(event.target);
            
            if (!isClickInside && navMenu.classList.contains('active')) {
                navMenu.classList.remove('active');
            }
        });
    }

//AI-USE END
</script>
</body>
</html>