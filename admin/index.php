<?php $_title = "Administrationssystem"?>
<?php include("./php/header.php") ?>

<main class="container">
    <h2>Administrationssystem</h2>
    <div class="col-md-6">
        <h3>Schulverwaltung</h3>
        <p>Die mit <i>Vertretungsplan</i> verbundenen Schulen können hier eingesehen und bearbeitet werden.</p>
        <a href="/admin/schools" class="blocklink">Schulverwaltung öffnen</a>
    </div>
    <div class="col-md-6">
        <h3>Nutzerverwaltung</h3>
        <p>Alle <i>Vertretungsplan</i>-Nutzer können hier eingesehen werden.</p>
        <a href="/admin/users" class="blocklink">Nutzerverwaltung öffnen</a>
    </div>
</main>

<?php include("./php/footer.php") ?>
