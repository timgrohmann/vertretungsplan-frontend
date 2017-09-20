<?php $_title = "Account gelöscht"?>
<?php include("./php/header.php") ?>
<?php
if ($logged_in && $the_user['id'] != "") {
    Data::query('DELETE FROM users WHERE id=:id LIMIT 1', array(':id' => $the_user['id']));
    Data::query('DELETE FROM accessdata WHERE user_id=:id LIMIT 1', array(':id' => $the_user['id']));
}

 ?>

<main class="container">
    <h1>Dein Account wurde gelöscht!</h1>
    <img src="https://media.giphy.com/media/tXsJ1frsMEhhu/giphy.gif" alt="Fliegendes Einhorn" class="img-responsive center-block">
</main>
<?php include("./php/footer.php") ?>
