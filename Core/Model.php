<?php

namespace Core;

use PDO;
use App\Config;
use Core\ORM;

/**
 * Base model
 *
 * PHP version >= 5.4
 */
abstract class Model
{
    /**
     * MYSQLI INITIALIZER
     *
     * @return mixed
     */
    public static function MYSQLI()
    {
        static $db = null;

        // Singleton
        if ($db === null) {
            $db = mysqli_connect(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);
            mysqli_set_charset($db, "utf8");

            // Throw an Exception when an error occurs
            mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
        }

        return $db;
    }

    /**
     * PDO INITIALIZER
     *
     * @return mixed
     */
    public static function PDO()
    {
        static $db = null;

        // Singleton
        if ($db === null) {
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            $db = new PDO($dsn, Config::DB_USER, Config::DB_PASSWORD);

            // Throw an Exception when an error occurs
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        return $db;
    }

    /**
     * ORM INITIALIZER
     *
     * @return mixed
     */
    public static function ORM()
    {
        static $db = null;

        // Singleton
        if ($db === null) {
            $db = new ORM(Config::DB_HOST, Config::DB_USER, Config::DB_PASSWORD, Config::DB_NAME);
            // ORM will handle errors itself
        }

        return $db;
    }
}
