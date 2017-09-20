<?php
    include("./php/Data.php");
    $logged_in = false;
    $the_school;
    $the_user = Data::getUserWithId($_COOKIE['user_id']);
    if ($the_user['access_token'] == $_COOKIE['token'] && $the_user['access_token'] != null){
        $logged_in = true;
    }

    if ($logged_in && $the_user['amzn_id'] == 'amzn1.account.AGPA2QUOLG3BEFBSAGUE4ARYDDMQ'){
        $the_school = Data::query('SELECT * FROM schools WHERE id=:id', array(':id' => $_GET['schoolid']));
        if (count($the_school) == 1){
            $the_school = $the_school[0];
        }
    } elseif ($logged_in && isset($_GET['schoolid'])) {
        $the_schools = Data::getSchoolList();
        $the_school = null;
        foreach ($the_schools as $key => $school) {
            if ($school["_id"] == $_GET['schoolid']) {
                $the_school = $school;
            }
        }
        if ($the_school != null){
            if ($the_school['admin_user'] == $the_user['amzn_id']){
                #continue
            }else{
                echo "Du nicht der Administrator dieser Schule!";
                exitt();
            }
        }else{
            exitt();
        }
    }else{
        exitt();
    }

    function exitt(){
        //http_response_code(401);
        ?>
        <h1>Zugriff verweigert</h1>
        <p>Der Zugriff auf diese Seite ist Administratoren vorbehalten!</p>
        <a href='/'>Zur&uuml;ck zur Startseite!</a>
        <?php
        die();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Vertetungslpan — <?=$_title?></title>
        <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500" rel="stylesheet">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <link rel="stylesheet" href="/css/style.css">

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    </head>
    <body class="<?=($logged_in)?'logged_in':''?>">
        <header class="admin">
            <a class="line0" href="/">Vertretungsplan</a>
            <span class="glyphicon glyphicon-menu-hamburger" id="menuOpener"></span>
            <div class="centerFlexRow" id="infoOpener"><span class="rightNote">Beta!</span><span class="glyphicon glyphicon-info-sign <?=($logged_in)?'green':''?>"></span></div>
        </header>
        <nav>
            <span class="glyphicon glyphicon-chevron-left" id="menuCloser"></span>
            <div class="item"><a href="/admin">Backend</a></div>
            <div class="item"><a href="/admin/users">Benutzerverwaltung</a></div>
            <div class="item"><a href="/admin/schools">Schulverwaltung</a></div>
        </nav>
        <aside class="infoBar">
            <span class="glyphicon glyphicon-chevron-right" id="infoCloser"></span>
            <p>Das ist die Beta-Version von Vertretungsplan!</p>
            <p>Vertretungsplan ist ein Skill für Amazon Alexa, der eine Verbindung zwischen deinem Sprachassistenten und dem aktuellen Online-Vertretungsplan deiner Schule schafft.</p>
            <p>Vertretungsplan wird von <a href="https://146programming.de">146Programming</a> entwickelt.</p>
            <p>&copy;TG</p>
        </aside>
