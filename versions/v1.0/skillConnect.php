<?php
header('Content-Type: application/json; charset=utf-8');

include("./php/Data.php");
if (!isset($_SERVER['HTTP_AUTHORIZATION'])){
    die('{
        "status": 400
    }');
}
$access_token = $_SERVER['HTTP_AUTHORIZATION'];
$usr = Data::query('SELECT * FROM users WHERE access_token=:token', array(':token' => $access_token));

if (count($usr) == 1){

    $user = $usr[0];

    $school_url = Data::query('SELECT plan_url FROM schools WHERE id=:id', array(':id' => $user['school_id']))[0]['plan_url'];

    $accessData = Data::query('SELECT ac_username,ac_password FROM accessdata WHERE user_id=:id', array(':id' => $user['id']));
    $ac_un = "";
    $ac_pw = "";

    if (count($accessData) == 1) {
        $ac_un = $accessData[0]['ac_username'];
        $ac_pw = $accessData[0]['ac_password'];
    }

    $return = array('klasse' => $user['klasse'], 'school_id' =>$user['school_id'], 'ac_username' => $ac_un, 'ac_password' => $ac_pw, 'status' => 200);
    echo json_encode($return);
}else{
    echo json_encode(array('status' => 400));
}

?>
