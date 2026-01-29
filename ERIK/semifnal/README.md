# Kaavakanta - Kuntasuunnittelun Vuorovaikutusalusta

Kaavakanta on PHP-pohjainen verkkopalvelu, jonka avulla kunnan asukkaat voivat tarkastella käynnissä olevia kaavahankkeita, suodattaa niitä tilan mukaan. Sivuston koodissa on hyödytetty paljon seuraavia tekoälykaluja (ChatGPT ja Google Gemini)

## Ominaisuudet

* **Dynaaminen kaavalistaus:** Selaa kaavaehdotuksia, joissa on kuvat, sijaintitiedot ja lyhyet kuvaukset.
* **Suodatus:** Mahdollisuus suodattaa kaavoja prosessin vaiheen mukaan (esim. vireilläolo, kuuleminen).
* **Sivutus:** JavaScript-pohjainen sivutus suurten datamäärien hallintaan.
* **Käyttäjäjärjestelmä:**
    * Rekisteröityminen asuntovahvistuksella.
    * Turvallinen kirjautuminen (Password Hashing).
* **Responsiivisuus:** Moderni NavBar hampurilaisvalikolla ja mobiilioptimoitu taulukkonäkymä.
* **Lightbox-näkymä:** Klikkaa kaavakuvia nähdäksesi ne täydessä koossa.

* **Jätety pois:** Ei voi  jättää kommentteja kaavoihin eikä admin paneelia ole ollenkaan sillä aikaa niihin ei ollut. Tyyli on muos huono ajan puutteesta. Kirjautumisen jälkeen redirectaus ei ole tehty kirjautumis/rekisteröitymis sivuille.

##  Teknologiat

* **Backend:** PHP
* **Tietokanta:** MySQL / MariaDB (PDO-yhteys)
* **Frontend:** HTML5, CSS3, Vanilla JavaScript
* **Tyyli:** Flexbox & CSS Grid
