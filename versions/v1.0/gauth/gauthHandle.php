<?php

require_once './../php/google-api-php-client-2.2.0/vendor/autoload.php';

include("./../php/Data.php");

$CLIENT_ID = '282504638010-tsccvq2298o6nhektmpdk1pfult4sjkd.apps.googleusercontent.com';
// Get $id_token via HTTPS POST.

if (isset($_POST['id_token'])) {
    $client = new Google_Client(['client_id' => $CLIENT_ID]);
    try {
        $payload = $client->verifyIdToken($_POST['id_token']);
        if ($payload) {
            $userid = $payload['sub'];
            $token = bin2hex(random_bytes(512));
            $the_user = Data::query('SELECT * FROM users WHERE amzn_id=:id', array(':id' => $userid));
            if (count($the_user) == 1){
                Data::query('UPDATE users SET access_token=:token WHERE id=:id', array(':token' => $token, ':id' => $the_user[0]['id']));
                sendData($the_user[0]['id'], $token);
            }else{
                $new_id = Data::query("INSERT INTO users (amzn_mail,access_token,amzn_id,name) VALUES (:mail,:token,:id,:name)", array(':mail' => $payload['email'], ':token' => $token, ':id' => $userid, ':name' => $payload['name']));
                sendData($new_id, $token);
            }
            sendData($userid, $token);
        } else {
            sendError();
        }
    } catch (Exception $e) {
        sendError();
    }
} else {
    sendError();
}

function sendError()
{
    $data = array('status' => 400);
    die(json_encode($data));
}

function sendData($userid, $token)
{
    $data = array('status' => 200, 'user_id' => $userid, 'token' => $token);
    die(json_encode($data));
}
