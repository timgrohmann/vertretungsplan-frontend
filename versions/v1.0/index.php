<?php $_title = "Startseite"?>
<?php include("./php/header.php") ?>
<main class="container">



    <?php if ($logged_in): ?>
    <p class="name">Hallo <?=explode(" ", $the_user['name'])[0]?>!</p>


    <form class="inputform" action="/" method="post">
        <label for="plan_uri">Deine Schule:</label>
        <select id="schoolSelect" name="school">
            <?php
                $schools = Data::getSchoolList();
                foreach ($schools as $school) {
                    if ((!isset($_POST['school']) && $school['_id']==$the_user['school_id']) || $_POST['school'] == $school['_id']) {
                        echo '<option value="'.$school['_id'].'" selected>'.$school['name'].'</option>';
                    }else{
                        echo '<option value="'.$school['_id'].'">'.$school['name'].'</option>';
                    }
                } ?>
        </select>
        <p class="hint"><span>ID: </span><span id="plan_uri_input"></span></p>
        <p><a class="addschool" href="mailto:kontakt@146programming.de">Deine Schule ist noch nicht dabei? Schreibe uns eine Mail!</a></p>
        <br>
        <label for="klasse">Klasse:</label>
        <input type="text" name="klasse" value="<?=(isset($_POST['klasse'])) ? $_POST['klasse'] : $the_user['klasse']?>" placeholder="z.B.: 10.2">
        <br><br>
        <label for="ac_username">Benutzername:</label>
        <input type="text" name="ac_username" value="<?=(isset($_POST['ac_username'])) ? $_POST['ac_username'] : $the_accessData['ac_username']?>" placeholder="nur für einige Schulen">
        <br>
        <label for="ac_password">Passwort:</label>
        <input type="password" name="ac_password" value="<?=(isset($_POST['ac_password'])) ? $_POST['ac_password'] : $the_accessData['ac_password']?>" placeholder="nur für einige Schulen">

        <br>
        <button class="btn btn-primary center-block" type="submit" name="button">Daten ändern!</button>
    </form>
    <button class="btn btn-warning center-block" type="button" name="button" id="Logout">Abmelden!</button>

    <?php else: ?>
        <h1>Anmelden</h1>
        <row class="clearfix">
            <div class="col-md-6">
                <a href="#" id="LoginWithAmazon" class="loginBtn">
                  <img border="0" alt="Login with Amazon"
                    src="https://images-na.ssl-images-amazon.com/images/G/01/lwa/btnLWA_gry_312x64.png"
                    width="250" height="auto" />
                </a>
            </div>
            <div class="col-md-6">
                <div id="google-button" class="loginBtn" data-onsuccess="onSignIn"></div>
            </div>
        </row>
        <row>
            <p>Solltest du dich zum ersten Mal anmelden, erstellen wir automatisch ein Konto für dich! Du musst daraufhin lediglich deine Schule auswählen und kannst dann deinen Vertretungsplan auf eine attraktive Weise ansehen.</p><br>
            <p>Durch die Anmeldung erklären Du dich mit unseren <a href="https://146programming.de/datenschutzbestimmung-vertretungsplan/">Datenschutzbestimmungen</a> einverstanden.</p>
            <p>Wenn Du dich mit Google anmeldest, kann der Account später nicht mit Alexa verknüpft werden!</p>
        </row>

    <?php endif; ?>
</main>


<div id="amazon-root"></div>
<script src="./js/amzn.js" charset="utf-8"></script>
<script src="./js/select.js" charset="utf-8"></script>
<script src="https://apis.google.com/js/platform.js?onload=gAPIDidLoad&hl=de" async defer></script>
<?php include("./php/footer.php") ?>
