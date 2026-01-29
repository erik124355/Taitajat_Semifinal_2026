<?php
require "config/db.php";

$error = "";
$success = "";
//AI-USE: Gemini

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"]);
    $email = trim($_POST["email"]);
    $address = trim($_POST["adress"]);
    $phone = trim($_POST["phone"]);
    $password = $_POST["password"];
    $password_check = $_POST["password-check"];

    if ($password !== $password_check) {
        $error = "Salasanat eivät täsmää.";
    } 
    elseif (strlen($password) < 6) {
        $error = "Salasanan täytyy olla vähintään 6 merkkiä.";
    } 
    else {
        try {
            $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
            $stmt->execute([$email]);

            if ($stmt->fetch()) {
                $error = "Sähköpostiosoite on jo rekisteröity.";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare(
                    "INSERT INTO users (name, email, address, phone, password) 
                     VALUES (?, ?, ?, ?, ?)"
                );
                $stmt->execute([$name, $email, $address, $phone, $hash]);

                $success = "Käyttäjä luotu onnistuneesti 🎉 Voit nyt kirjautua sisään.";
            }
        } catch (PDOException $e) {
            $error = "Tietokantavirhe: " . $e->getMessage();
        }
    }
}
//AI-USE END
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekisteröidy - Kaavakanta</title>
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
        <a href="login.php">Kirjaudu</a>
    </div>
</nav>

<div style="max-width: 400px; margin: 40px auto; padding: 20px; text-align: left;">
    <h2>Rekisteröityminen</h2>

    <?php if ($error): ?>
        <p style="color:red; background: #fee; padding: 10px; border-radius: 5px;"><?php echo $error; ?></p>
    <?php endif; ?>

    <?php if ($success): ?>
        <p style="color:green; background: #efe; padding: 10px; border-radius: 5px;"><?php echo $success; ?></p>
    <?php endif; ?>

    <p style="font-size: 0.9em; color: #666;">Tämä palvelu on tarkoitettu vain kunnan asukkaille. Rekisteröitymällä vakuutat olevasi kunnan asukas.</p>

    <form method="POST">
        <label>Nimi:</label>
        <input type="text" name="name" style="width:100%; padding: 8px; margin-bottom: 15px;" required>
        
        <label>Sähköpostiosoite:</label>
        <input type="email" name="email" style="width:100%; padding: 8px; margin-bottom: 15px;" required>
        
        <label>Lähiosoite:</label>
        <input type="text" name="adress" style="width:100%; padding: 8px; margin-bottom: 15px;" required>
        
        <label>Puhelinnumero:</label>
        <input type="tel" name="phone" style="width:100%; padding: 8px; margin-bottom: 15px;" required>
        
        <label>Salasana:</label>
        <input type="password" name="password" style="width:100%; padding: 8px; margin-bottom: 15px;" required>
        
        <label>Salasana uudelleen:</label>
        <input type="password" name="password-check" style="width:100%; padding: 8px; margin-bottom: 20px;" required>
    
        <div style="margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px;">
            <input type="checkbox" name="resident_confirm" id="resident_confirm" style="margin-top: 5px;" required>
            <label for="resident_confirm" style="font-size: 0.9em; line-height: 1.4; color: #333;">
                Hyväksy, että antamani tiedot tallennetaan järjestelmään ja että tiedot ovat kunna kaavoitusasioista<br>vastaavien henkilöiden nähtävissä palvelun käyttötarkoituksen mukaisesti
            </label>
        </div>

        <button type="submit" style="width: 100%; padding: 10px; background: #667eea; color: white; border: none; border-radius: 5px; cursor: pointer;">
            Lähetä
        </button>
        <p>Oletko jo rekisteröitynyt?</p>
        <a href="login.php">Tästä kirjautumaan</a>
    </form>
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
        if (!navMenu.contains(event.target) && !burgerBtn.contains(event.target)) {
            navMenu.classList.remove('active');
        }
    });
}
    //AI-USE END
</script>
</body>
</html>