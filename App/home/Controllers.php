<?php

// declare namespace for your app
namespace App\home;

use Core\View;
use App\home\Models;

class Controllers extends \Core\Controller
{
    protected function indexAction()
    {
        $context = [
            'colors' => ['red', 'green', 'blue'],
            'params' => $this->route_params,
            'server' => $this->server, // $_SERVER
            'get' => $this->get, // $_GET
            'post' => $this->post, // $_POST
            'files' => $this->files, // $_FILES
            'posts' => Models::getPosts_MYSQLI() // records retrieved using Model
        ];

        View::render('home/index.php', $context);
    }
}
