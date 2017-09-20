<?php $_title = "Account"?>
<?php include("./php/header.php") ?>
<main class="container">
    <h1>Dein Account</h1>
    <?php if ($logged_in): ?>

    <p>Name: <?=$the_user['name']?></p>
    <p>E-Mail: <?=$the_user['amzn_mail']?></p>
    <p>Verbunden über: <?=(substr($the_user['amzn_id'], 0, 4) === "amzn")?"Amazon":"Google"?></p>
    <button class="btn btn-danger btn-lg" type="button" data-toggle="modal" data-target="#deleteModal">Account löschen!</button>

    <!-- Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
      <form class="modal-dialog" role="document" action="/delete" method="post">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h3 class="modal-title text-danger" id="myModalLabel">Account wirklich löschen?</h4>
          </div>
          <div class="modal-body text-danger">
            <p>Wenn du deinen Account löschst, geht wahrscheinlich die Welt unter😱.<br>
            Tu es also besser nicht!</p>
            <img src="https://media.giphy.com/media/NTY1kHmcLsCsg/giphy.gif" alt="Nein" class="img-responsive center-block">
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-info" data-dismiss="modal">Zurück😏</button>
            <button type="submit" class="btn btn-danger" onclick="delete">Account endgültig löschen😰</button>
          </div>
        </div>
    </form>
    </div>

    <?php else: ?>
        <p>…ist nur einsehbar, wenn du angemeldet bist. <a href="/">Besuche dazu die Startseite!</a></p>
    <?php endif; ?>
</main>
<?php include("./php/footer.php") ?>
