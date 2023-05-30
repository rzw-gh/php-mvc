<?php

namespace Core;
use Core\View;
use App\Config;

/**
 * Base controller
 *
 * PHP version >= 5.4
 */
abstract class Controller
{

    /**
     * Parameters from the matched route
     * @var array
     */
    protected $route_params = [];

    /**
     * Server info
     * @var array
     */
    protected $server = [];

    /**
     * Get info
     * @var array
     */
    protected $get = [];

    /**
     * Post info
     * @var array
     */
    protected $post = [];

    /**
     * Files info
     * @var array
     */
    protected $files = [];

    /**
     * Class constructor
     *
     * @param array $route_params  Parameters from the route
     *
     * @return void
     */
    public function __construct($route_params, $SERVER, $GET, $POST, $FILES)
    {
        $this->route_params = $route_params;
        $this->server = $SERVER;
        $this->get = $GET;
        $this->post = $POST;
        $this->files = $FILES;
    }

    /**
     * Magic method called when a non-existent or inaccessible method is
     * called on an object of this class. Used to execute before and after
     * filter methods on action methods. Action methods need to be named
     * with an "Action" suffix, e.g. indexAction, showAction etc.
     *
     * @param string $name Method name
     * @param array $args Arguments passed to the method
     *
     * @return void
     * @throws \Exception
     */
    public function __call($name, $args)
    {
        $method = $name . 'Action';

        if (method_exists($this, $method)) {
            if ($this->before() !== false) {
                call_user_func_array([$this, $method], $args);
                $this->after();
            }
        } else {
            throw new \Exception("Method $method not found in controller " . get_class($this));
        }
    }

    /**
     * Before filter - called before an action method.
     *
     * @return void
     */
    protected function before()
    {
    }

    /**
     * After filter - called after an action method.
     *
     * @return void
     */
    protected function after()
    {
    }

    /**
     * check if request is Ajax or not
     *
     * @return bool
     */
    protected function isAjax() {
        return isset($this->server['HTTP_X_REQUESTED_WITH']) && $this->server['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';
    }

    /**
     * determines request method type
     *
     * @return string
     */
    protected function method() {
        return $this->server['REQUEST_METHOD'];
    }

    /**
     * raise http 404 page
     *
     * @return void
     */
    protected function http_404() {
        http_response_code(404);
        View::render(Config::page_404);
        exit();
    }
    
    /**
     * raise http 500 page
     *
     * @return void
     */
    protected function http_500() {
        http_response_code(500);
        View::render(Config::page_500);
        exit();
    }

    /**
     * redirect
     *
     * @return void
     */
    protected function redirect($path) {
        if (substr( $path, 0, 1 ) === "/") {
            $path = Config::BASE . $path;
        } else {
            $path = Config::BASE . '/' . $path;
        }
        header('Location: ' . $path);
        exit();
    }

    /**
     * get or return 404 page
     *
     * @return void
     */
    protected function get_or_404($val) {
        if (!isset($val[0])){
           $this->http_404();
        } else {
            return $val[0];
        }
    }
}
