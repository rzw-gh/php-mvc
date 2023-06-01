# PHP MVC design pattern

A simple, secure and easy to use PHP MVC design pattern written in pure php >=5.6

<a name="index_block"></a>

* [1. Structure Overview](#block0)
* [1. Setup](#block1)
* [2. Basic Example](#block2)
    * [2. Models](#block2)
    * [2. Controllers](#block2.1)
    * [2. Views](#block2.2)
    * [2. Routing](#block2.3)
* [5. TODO](#block3)

<a name="block0"></a>
### Structure Overview: [↑](#index_block)
---
```bash
├── App
│   ├── Config.php
│   ├── home
│   │   ├── Controllers.php
│   │   └── Models.php
│   └── views
│       ├── 404.php
│       ├── 500.php
│       └── home
│           └── index.php
├── assets
│   ├── css
│   │   └── style.css
│   ├── images
│   │   └── favicon.ico
│   └── js
│       └── script.js
├── base
│   ├── footer.php
│   └── header.php
├── Core
│   ├── Controller.php
│   ├── Error.php
│   ├── Model.php
│   ├── ORM.php
│   ├── Router.php
│   └── View.php
├── index.php
├── .htaccess
├── logs
│   └── 2023-6-01.txt
```
| Dir                 | Description |
|--------------------:|----------------------------|
|App/Config.php|project configuration lives here. i.e: Domain Address, DataBase Authentication info...|
|App/home|basic example of how an application would be. it contains controllers and models|
|App/views|root directory of html templates for applications|
|App/views/404.php|custom 404 error page|
|App/views/500.php|custom 500 error page|
|assets|static files like css, js and images goes here|
|base|base html template files like header and footer lives here. you can choose not to use this|
|Core|mvc core files lives here. don't change these files unless you know what you're doing|
|index.php|this is where our routes will be written in|
|logs|you can see your error reports here if there is any|

<a name="block1"></a>
### Setup: [↑](#index_block)
---
Download this repo by cloning
```bash
git clone https://github.com/Rewzaw/php-mvc.git
```
or simply download zip file.

after creating a database, go change `App/Config` based on your requirements.

if you're struggling creating a database. refer to this <a href="https://www.geeksforgeeks.org/how-to-create-a-new-database-in-phpmyadmin/">Tutorial</a>
<a name="block2"></a>
### Basic Example - Models: [↑](#index_block)
---
the goal is to read our post records from database and show them in home index

first create a Table named 'posts' with columns 'id, name, content' using a DBMS

if you're struggling creating a Table. refer to this <a href="https://www.liquidweb.com/kb/creating-tables-in-a-database-with-phpmyadmin/">Tutorial</a>

here is an example of how Models would be used correctly in 3 methods of PDO, MYSQLI and a custom <a href="https://github.com/Rewzaw/php-query-builder">ORM</a>

this code is located in `App/home/Models.php` directory
```php
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
```
<a name="block2.1"></a>
### Basic Example - Controllers: [↑](#index_block)
---
we'll use Model output in Controller. `getPosts_MYSQLI` method used here.

Controller method names should be always end with ‍‍`Action` Suffix. (this is a security feature)

`View::render` method used to pass context values to our template and render html

this code is located in `App/home/Controllers.php` directory
```php
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
            'posts' => Models::getPosts_MYSQLI() // records retrieved using Model
            
            // 'params' => $this->route_params,
            // 'server' => $this->server, // $_SERVER
            // 'get' => $this->get, // $_GET
            // 'post' => $this->post, // $_POST
            // 'files' => $this->files, // $_FILES
        ];

        View::render('home/index.php', $context);
    }
}
```
<a name="block2.2"></a>
### Basic Example - Views: [↑](#index_block)
---
in html template we can access to `posts`.

this code is located in `App/views/home/index.php` directory
```php
<?php

require App\Config::HEADER;
?>

<div style="display: block">
    <h1>Hello World!</h1>
    <br>
    <ul>
    <?php foreach ($posts as $post) { ?>
        <li><?= $post['name'] ?></li>
    <?php } ?>
    </ul>
</div>

<?php require App\Config::FOOTER ?>
```
<a name="block2.3"></a>
### Basic Example - Routing: [↑](#index_block)
---
take a look at this example:

```php
$router->add(
  '', // url
  [
    'controller' => 'home', // app name
    'action' => 'index' // controller method without 'Action' suffix
  ]
);
```

you can accept ids as url parameter like this: 

`$router->add('blog/post/{id:\d+}', ['controller' => 'blog', 'action' => 'detail']);`

`\d+` represents digital int

then you can access id in controller using `$this->route_params['id']` 

this code is located in `App/views/home/index.php` directory
```php
<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Error and Exception handling
 */
error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

/**
 * Routing
 */
$router = new Core\Router();

$router->add('', ['controller' => 'home', 'action' => 'index']);

$router->dispatch($_SERVER, $_GET, $_POST, $_FILES);
```
<a name="block3"></a>
### TODO: [↑](#index_block)
---
* Specify route METHOD type (POST/GET/...)
* Built-in basic authentication
* Built-in CSRF tokens for forms
