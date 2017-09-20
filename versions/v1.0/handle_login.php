<?php
include("./php/Data.php");
session_start();
/*verify that the access token belongs to us*/
$c = curl_init('https://api.amazon.com/auth/o2/tokeninfo?access_token=' . urlencode($_REQUEST['access_token']));
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

$r = curl_exec($c);
curl_close($c);
$d = json_decode($r);

if ($d->aud != 'amzn1.application-oa2-client.269ef1cfdcf448a5baca31d0cd310676') {
  // the access token does not belong to us
  header('HTTP/1.1 404 Not Found');
  echo 'Page not found';
  echo json_encode($d);
  echo '<br>';
  echo json_encode($_REQUEST);
  exit;
}

// exchange the access token for user profile
$c = curl_init('https://api.amazon.com/user/profile');
curl_setopt($c, CURLOPT_HTTPHEADER, array('Authorization: bearer ' . $_REQUEST['access_token']));
curl_setopt($c, CURLOPT_RETURNTRANSFER, true);

$r = curl_exec($c);
curl_close($c);
$d = json_decode($r);



$the_user = Data::query("SELECT * FROM users WHERE amzn_id=:id", array(":id" => $d->user_id));
$endtoken = '';
if (count($the_user) == 1){
    if ($the_user[0]['access_token'] == "") {
        $token = bin2hex(random_bytes(512));
        Data::query('UPDATE users SET access_token=:token WHERE id=:id', array(':token' => $token, ':id' => $the_user[0]['id']));

        setcookie('token', $token);
        $endtoken = $token;
    }else{
        setcookie('token', $the_user[0]['access_token']);
        $endtoken = $the_user[0]['access_token'];
    }
    
    setcookie('user_id', $the_user[0]['id']);
}else{
    //Create new user

    $token = bin2hex(random_bytes(512));

    $new_id = Data::query("INSERT INTO users (amzn_mail,access_token,amzn_id,name) VALUES (:mail,:token,:id,:name)", array(':mail' => $d->email, ':token' => $token, ':id' => $d->user_id, ':name' => $d->name));
    setcookie('token', $token);
    $endtoken = $token;
    setcookie('user_id', $new_id);
}

if (isset($_SESSION['my_state']) && isset($_SESSION['vp_redirect_uri'])){
    //Alexa authentication in progress. Redirect to amazon instead of login page.

    header('Location: ' . urldecode($_SESSION['vp_redirect_uri']) . '#state='.urlencode($_SESSION['my_state']) . '&access_token=' . urlencode($endtoken) . '&token_type=Bearer');
    //header('Location: https://vertretungsplan.alexa.146programming.de/login');
}else{
    header('Location: https://vertretungsplan.alexa.146programming.de/');
}

echo 'You seem to be stuck in authentication!';
