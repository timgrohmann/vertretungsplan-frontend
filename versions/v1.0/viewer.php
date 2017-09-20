<?php $_title = "Dein Plan"?>
<?php include("./php/header.php") ?>
<main class="container">
    <h1>Dein Vertretungsplan</h1>

    <?php if ($logged_in): ?>
    <p id="info">Lädt…</p>

    <table id="planTable" class="hidden">
        <tr class="head"> <th>Stunde</th> <th>Fach</th> <th>Lehrer</th> <th>Raum</th> <th>Info</th> </tr>
    </table>
    <?php
    $loaders = ["https://media.giphy.com/media/brHaCdJqCXijm/giphy.gif","https://media.giphy.com/media/tXL4FHPSnVJ0A/giphy.gif","https://media.giphy.com/media/ZXKZWB13D6gFO/giphy.gif","https://media.giphy.com/media/GiWEowj3nQv9C/giphy.gif","https://media.giphy.com/media/NWg7M1VlT101W/giphy.gif","https://media.giphy.com/media/TlK63EI7rtUu9IAyxTW/giphy.gif","https://media.giphy.com/media/AboDThj3SWZLW/giphy.gif","https://media.giphy.com/media/3o6Mbop5bycEsLJpvi/giphy.gif","https://media.giphy.com/media/3oEjHUajTSwjbkCDRu/giphy.gif"];
    $src = $loaders[array_rand($loaders)];
     ?>
    <img src="<?=$src?>" alt="Laden" class="loader img-responsive center-block">


    <?php
    $url = "https://vpman.146programming.de/plan/" . $the_user['school_id'] . "?acun=" . urlencode($the_accessData['ac_username']) . "&acpw=" . urlencode($the_accessData['ac_password']);
    echo '<script type="text/javascript">var url="'.$url.'"</script>';
    ?>

    <button type="button" class="btn btn-dark disabled" id="prevPage">Vorherige Seite</button>
    <button type="button" class="btn btn-dark" id="nextPage">Nächste Seite</button>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="js/planviewajax.js" charset="utf-8"></script>

    <?php else: ?>
        <p>…ist nur einsehbar, wenn du angemeldet bist. <a href="/">Besuche dazu die Startseite!</a></p>
    <?php endif; ?>

    <br>
    <blockquote>
        <p>Es ist nichts schrecklicher als ein Lehrer, der nicht mehr weiß, als die Schüler allenfalls wissen sollen. Wer andere lehren will, kann wohl oft das Beste verschweigen, was er weiß, aber er darf nicht halbwissend sein.</p>
        <footer>Johann Wolfgang von Goethe</footer>
    </blockquote>
</main>
<?php include("./php/footer.php") ?>
