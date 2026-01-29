<?php
/*
AI-USE: ChatGPT
Käytettynä apuna taulujen tiedon hakemiseen ja tilojen hakemiseen
*/
require "config/db.php";
session_start();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

try {
    if ($id) {
        $stmt = $pdo->prepare("
            SELECT p.*, s.name AS status_name
            FROM plans p
            JOIN status s ON p.status_id = s.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        $plan = $stmt->fetch();

        if (!$plan) {
            die("Kaavaa ei löydy.");
        }
    } else {
        $stmt = $pdo->prepare("
            SELECT p.*, s.name AS status_name
            FROM plans p
            JOIN status s ON p.status_id = s.id
            ORDER BY p.id ASC
        ");
        $stmt->execute();
        $plans = $stmt->fetchAll();

        $statusStmt = $pdo->prepare("SELECT * FROM status ORDER BY id ASC");
        $statusStmt->execute();
        $statuses = $statusStmt->fetchAll();
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
/* AI-USE END */
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plans</title>
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
        <a href="register.php">Rekisteröidy</a>
        <a href="login.php">Kirjaudu</a>
    </div>
</nav>

<?php if ($id && $plan): ?>
    <!-- PLAN VIEW -->
    <div class="plan-container">
        <div class="plan-left">
            <?php if ($plan['id']): ?>
                <?php
                    $thumbUrl = "https://public.bc.fi/jarla/semifinal/thumbnail_" . $plan['id'] . ".jpg";
                    $fullUrl  = "https://public.bc.fi/jarla/semifinal/plan_" . $plan['id'] . ".png";
                ?>
                <img id="planThumbnail" class="plan-thumb" 
                    src="<?= htmlspecialchars($thumbUrl) ?>" 
                    data-full="<?= htmlspecialchars($fullUrl) ?>" 
                    alt="<?= htmlspecialchars($plan['name']) ?>">
                <p>Klikkaa kuvaa nähdäksesi suurempana</p>
            <?php endif; ?>
        </div>

        <!-- Lightbox -->
        <div id="lightboxOverlay">
            <div id="lightboxContent">
                <span id="closeLightbox">×</span>
                <img id="lightboxImg" src="" alt="Kaava">
            </div>
        </div>

        <div class="plan-middle">
            <h2><?= htmlspecialchars($plan['name']) ?></h2>
            <strong><?= htmlspecialchars($plan['location']) ?></strong>
            <p><?= nl2br(htmlspecialchars($plan['long_description'] ?: $plan['short_description'])) ?></p>
        </div>

        <div class="plan-comments">
            <h3>Kommentit</h3>
            <?php 
            $canComment = in_array($plan['status_name'], ['kuuleminen','nähtävilläolo']);
            if (!isset($_SESSION['user_id'])): ?>
                <div class="login-prompt">
                    <p>Kirjaudu sisään tai rekisteröidy kommentoidaksesi.</p>
                    <a href="login.php">Kirjaudu</a> | <a href="register.php">Rekisteröidy</a>
                </div>
            <?php elseif (!$canComment): ?>
                <p>Kaavaa ei voi kommentoida tässä vaiheessa.</p>
            <?php else: ?>
                <form method="POST" action="submit_comment.php">
                    <input type="hidden" name="plan_id" value="<?= $plan['id'] ?>">
                    <textarea name="comment" rows="4" placeholder="Kirjoita kommentti..." required style="width:100%;"></textarea>
                    <button type="submit">Lähetä</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <div class="back-link-container">
        <a href="plans.php" class="back-link">
            &#129044; Takaisin listaukseen
        </a>
    </div>
<?php else: ?>
    
    <h2 class="page-title">
        Kaavaehdotukset
    </h2>

    <div class="table-container">
        <table id="plansTable">
            <thead>
                <tr>
                    <th class="thumbnail-col">Kuva</th>
                    <th>Nimi</th>
                    <th>Kuvaus / Sijainti</th>
                    <th>
                        Kaavaprosessin tila
                        <select id="statusFilter">
                            <option value="">Kaikki</option>
                            <?php foreach($statuses as $status): ?>
                                <option value="<?= htmlspecialchars($status['name']) ?>"><?= htmlspecialchars($status['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($plans as $plan): ?>
                <tr>
                    <td class="thumbnail-col">
                        <?php if ($plan['thumbnail_url']): ?>
                            <img src="<?= htmlspecialchars($plan['thumbnail_url']) ?>" alt="<?= htmlspecialchars($plan['name']) ?>">
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($plan['name']) ?></td>
                    <td class="desc">
                        <strong><?= htmlspecialchars($plan['location']) ?></strong><br>
                        <?= htmlspecialchars($plan['short_description']) ?>
                    </td>
                    <td><?= htmlspecialchars($plan['status_name']) ?></td>
                    <td style="border:none; text-align:center;">
                        <a href="plans.php?id=<?= $plan['id'] ?>" style="text-decoration:none; font-size:20px;">
                            ➔
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>

<div id="pagination"></div>
<p id="noRowsMessage" style="display:none; color:#555; font-style:italic;">Ei rivejä näytettäväksi valitulla suodatuksella.</p>


<footer class="footer">
    <p>© 2026 Erik Cerrada Plumed</p>
    <p>Savon Ammattiopisto</p>
</footer>

<script>
//AI-USE: ChatGPT
//Käytettynä apuna taulun rivien suodattamiseen, sivutukseen, kokonäytön kuvaan, navbar burgeri nappi avaamiseen

const table = document.getElementById('plansTable');

if (table) {
    const tbody = table.querySelector('tbody');
    const rows = Array.from(tbody.querySelectorAll('tr'));
    const rowsPerPage = 5;
    let currentPage = 1;

    const paginationContainer = document.getElementById('pagination');
    const filterSelect = document.getElementById('statusFilter');

    filterSelect.addEventListener('change', function() {
        const value = this.value.toLowerCase();
        rows.forEach(row => {
            const statusCell = row.cells[3].textContent.toLowerCase();
            row.style.display = (value === "" || statusCell === value) ? "" : "none";
        });
        currentPage = 1;
        renderPagination();
        showPage(currentPage);
    });

    function showPage(page) {
        const value = filterSelect.value.toLowerCase();
        const visibleRows = rows.filter(row => {
            const statusCell = row.cells[3].textContent.toLowerCase();
            return value === "" || statusCell === value;
        });

        document.getElementById('noRowsMessage').style.display =
            visibleRows.length === 0 ? 'block' : 'none';

        visibleRows.forEach((row, index) => {
            row.style.display =
                (index >= (page - 1) * rowsPerPage && index < page * rowsPerPage)
                ? ""
                : "none";
        });
    }

    function renderPagination() {
        const value = filterSelect.value.toLowerCase();
        const visibleRows = rows.filter(row => {
            const statusCell = row.cells[3].textContent.toLowerCase();
            return value === "" || statusCell === value;
        });

        const pageCount = Math.ceil(visibleRows.length / rowsPerPage);
        paginationContainer.innerHTML = "";

        for (let i = 1; i <= pageCount; i++) {
            const btn = document.createElement('button');
            btn.textContent = i;
            if (i === currentPage) btn.classList.add('active');
            btn.onclick = () => {
                currentPage = i;
                showPage(currentPage);
                renderPagination();
            };
            paginationContainer.appendChild(btn);
        }
    }

    renderPagination();
    showPage(currentPage);
}

const thumbnail = document.getElementById('planThumbnail');
const lightbox = document.getElementById('lightboxOverlay');
const lightboxImg = document.getElementById('lightboxImg');
const closeBtn = document.getElementById('closeLightbox');

if (thumbnail) {
    thumbnail.addEventListener('click', () => {
        lightbox.style.display = 'flex';
        lightboxImg.src = thumbnail.dataset.full;
    });
}

if (closeBtn) {
    closeBtn.addEventListener('click', () => {
        lightbox.style.display = 'none';
        lightboxImg.src = '';
    });
}

if (lightbox) {
    lightbox.addEventListener('click', (e) => {
        if (e.target === lightbox) {
            lightbox.style.display = 'none';
            lightboxImg.src = '';
        }
    });
}


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