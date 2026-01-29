<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Etusivu</title>
</head>
<body>
<nav class="navbar">
    <div class="nav-left">
        <span class="company-name">Kaavakanta</span>
    </div>

    <div class="burger" id="burgerBtn">&#9776;</div>

    <div class="nav-right" id="navMenu">
        <a href="plans.php">Kaavaehdotukset</a>
        <a href="register.php">Rekisteröidy</a>
        <a href="login.php">Kirjaudu</a>
    </div>
</nav>

<div class="container">
    <div class="left">
        <img src="assets/frontpage_hero.png" alt="Hero Image">
        <h2>Tervetuloa Kaavakantaan</h2>
        <p>Kaavakanta on kunnan verkkopalvelu, jonka kautta kuntalaiset voivat tutustua ajankohtaisiin maankäytön kaavaehdotuksiin ja seurata kaavaprosessin etenemistä.</p>

        <p>Palvelussa voit tarkastella eri alueita koskevia kaavaehdotuksia, lukea niiden taustatietoja sekä nähdä, missä vaiheessa kaavaprosessi on parhaillaan. Kaavoitus vaikuttaa kunnan ympäristöön, asumiseen ja arjen toimivuuteen. Kaavakannan tavoitteena on tehdä suunnittelusta mahdollisimman avointa ja helposti lähestyttävää.</p>

        <p>Osa kaavaehdotuksista on avoinna kommentointia varten. Kommenttien jättäminen edellyttää kirjautumista palveluun.</p>

        <div class="inline-boxes">
            <a href="plans.php" class="box">Tutustu Kaavaehdotuksiin</a>
        </div>
    </div>

    <div class="right">
        <h2>Kaavaprosessi</h2>
        <p>Kaavaprosessi etenee vaiheittain suunnittelusta päätöksentekoon.</p>
        <p>Prosessi alkaa aloitusvaiheesta, jossa kaavamuutoksen tarve arvioidaan ja laaditaan osallistumis- ja arviointisuunnitelma. Tämän jälkeen kaavaa selvitysten pohjalta laaditaan kaavaluonnos.</p>
        <p>Valmisteluvaiheessa kaavaluonnos asetetaan nähtäville kuulemista varten, jolloin osalliset voivat esittää mielipiteitä. Saatujen palautteiden perusteella kaavaa muokataan ja laaditaan varsinainen kaavaehdotus, joka asetetaan virallisesti nähtäville. Nähtävilläolon aikana osalliset voivat tehdä muistutuksia ja viranomaiset antaa lausuntoja.</p>
        <p>Lopuksi kaava etenee hyväksymiskäsittelyyn. Hyväksymisen jälkeen kaava kuulutetaan ja se saa lainvoiman, mikäli siitä ei valiteta.</p>

        <div class="container boxes">
            <a href="plans.php" class="box">Tutustu Kaavaehdotuksiin</a>
            <a href="register.php" class="box">Rekiströidy ja kommentoi kaavaehdotuksia</a>
            <a href="login.php" class="box">Kirjaudu sisään</a>
        </div>
    </div>

    
        <div class="inline-boxes">
            <a href="register.php" class="box">KRekiströidy ja kommentoi kaavaehdotuksia</a>
            <a href="login.php" class="box">Kirjaudu sisään</a>
        </div>
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
