<?php

// declare namespace for your app
namespace App\home;
use PDO;

class Models extends \Core\Model
{
    public static function getPosts_ORM()
    { // ORM example
        $db = static::ORM();
        return $db->table('posts')->select()->execute();
    }

    public static function getPosts_PDO()
    { // PDO example
        $db = static::PDO();
        $stmt = $db->query("SELECT * FROM `posts`");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getPosts_MYSQLI()
    { // MYSQLI example
        $db = static::MYSQLI();
        $result = mysqli_query($db, "SELECT * FROM `posts`");
        return mysqli_fetch_assoc($result);
    }
}
