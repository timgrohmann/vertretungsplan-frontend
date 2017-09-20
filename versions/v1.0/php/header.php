<?php
    include("./php/Data.php");
    $logged_in = false;
    $the_user = Data::getUserWithId($_COOKIE['user_id']);
    if ($the_user['access_token'] == $_COOKIE['token'] && $the_user['access_token'] != null){
        $logged_in = true;
    }


    if ($_GET['client_id'] == 'alexa-vertretungsplan' && isset($_GET['state']) && isset($_GET['redirect_uri'])){
        session_start();
        $_SESSION['my_state'] = $_GET['state'];
        $_SESSION['vp_redirect_uri'] = $_GET['redirect_uri'];

        $logged_in = false;
    }
    if (isset($_POST['school']) && isset($_POST['klasse'])){
        //die('not logged in');
        //header('Location: https://vertretungsplan.alexa.146programming.de/');
    }

    if ($logged_in) {
        $the_accessData = Data::getAuthDataForUserWithId($the_user['id']);

        if (isset($_POST['ac_username']) && isset($_POST['ac_password']) && is_numeric($the_user['id'])){
            if ($the_accessData === false) {
                Data::query('INSERT INTO accessdata (ac_username, ac_password, user_id) VALUES (:ac_username,:ac_password,:id)', array(':ac_username' => $_POST['ac_username'], ':ac_password' => $_POST['ac_password'], ':id' => $the_user['id']));
            }else{
                Data::query('UPDATE accessdata SET ac_username=:ac_username, ac_password=:ac_password WHERE user_id=:id', array(':ac_username' => $_POST['ac_username'], ':ac_password' => $_POST['ac_password'], ':id' => $the_user['id']));
            }


        }
    }

    if (isset($_POST['school']) && isset($_POST['klasse'])){
        Data::query('UPDATE users SET school_id=:school_id, klasse=:klasse WHERE amzn_id=:id', array(':school_id' => $_POST['school'], ':klasse' => $_POST['klasse'], ':id' => $the_user['amzn_id']));
    }



    //die(json_encode($the_user));

    $is_admin = ($logged_in && $the_user['amzn_id'] == 'amzn1.account.AGPA2QUOLG3BEFBSAGUE4ARYDDMQ');
?>

<!DOCTYPE html>
<html lang="de">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Vertetungslpan - <?=$_title?></title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link rel="stylesheet" href="./css/style.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

        <meta name="google-signin-client_id" content="282504638010-tsccvq2298o6nhektmpdk1pfult4sjkd.apps.googleusercontent.com">
    </head>
    <body class="<?=($logged_in)?'logged_in':''?>">
        <header>
            <a class="line0" href="/">Vertretungsplan</a>
            <span class="glyphicon glyphicon-menu-hamburger" id="menuOpener"></span>
            <div class="centerFlexRow" id="infoOpener"><span class="rightNote">Beta!</span><span class="glyphicon glyphicon-info-sign <?=($logged_in)?'green':''?>"></span></div>
        </header>
        <nav>
            <span class="glyphicon glyphicon-chevron-left" id="menuCloser"></span>
            <div class="item"><a href="/">Startseite</a></div>
            <div class="item"><a href="/about">Über</a></div>
            <?php if ($logged_in): ?>
            <div class="item"><a href="/viewer">Dein Plan</a></div>
            <div class="item"><a href="/account">Account</a></div>
            <?php endif; ?>
            <?php if ($is_admin): ?>
            <div class="item"><a href="/admin">Backend</a></div>
            <?php endif; ?>
        </nav>
        <aside class="infoBar">
            <span class="glyphicon glyphicon-chevron-right" id="infoCloser"></span>
            <p>Das ist die Beta-Version von Vertretungsplan!</p>
            <p>Vertretungsplan ist ein Skill für Amazon Alexa, der eine Verbindung zwischen deinem Sprachassistenten und dem aktuellen Online-Vertretungsplan deiner Schule schafft.</p>
            <p>Vertretungsplan wird von <a href="https://146programming.de">146Programming</a> entwickelt.</p>
            <p>&copy;TG</p>
        </aside>
