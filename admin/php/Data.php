<?php

class Data{
    private static function connect() {
        $pdo = new PDO('mysql:host=127.0.0.1;dbname=d025b08f;charset=utf8', 'd025b08f', 'sSP-3Le-acF-egq');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function query($query, $params = array()) {
        $statement = self::connect()->prepare($query);
        $statement->execute($params);
        if (explode(' ', $query)[0] == 'SELECT') {
            $data = $statement->fetchAll();
            return $data;
        }
    }
    public static function getUserWithId($id){
        return Data::query("SELECT * FROM users WHERE id=:id", array(":id" => $id))[0];
    }

    public static function getSchoolList(){
        $data = file_get_contents("https://vpman.146programming.de/schools");
        return json_decode($data,true)['schools'];
    }
}

 ?>
