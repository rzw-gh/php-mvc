<?php

namespace App;

/**
 * Application configuration
 *
 * PHP version >= 5.4
 */
class Config
{
    const TITLE = "My Website";
    const BASE = "https://my-website.com";
    const HEADER = "base/header.php";
    const FOOTER = "base/footer.php";
    const CSS = "assets/css";
    const JS = "assets/js";
    const IMG = "assets/images";

    /**
     * Database host
     * @var string
     */
    const DB_HOST = 'localhost';

    /**
     * Database name
     * @var string
     */
    const DB_NAME = 'my-website-db';

    /**
     * Database user
     * @var string
     */
    const DB_USER = 'my-website-user';

    /**
     * Database password
     * @var string
     */
    const DB_PASSWORD = 'my-website-password';

    /**
     * 404 Page Path
     * @var string
     */
    const page_404 = '404.php';

    /**
     * 500 Page Path
     * @var string
     */
    const page_500 = '500.php';

    /**
     * Show or hide error messages on screen
     * always set to false in production mode
     * @var boolean
     */
    const DEBUG = true;
}
