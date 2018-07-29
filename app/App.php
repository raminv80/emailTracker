<?php
class App {
    private $routes = [];
    private $defaultRoute;

    function __construct($routes = [], $defaultRoute = '404') {
        $this->routes = $routes;
        $this->defaultRoute = $defaultRoute;

    }

    function request($route = false) {
        // a very dumb router layer ;)
        if($route===false){
            $this->getTemplate('header');
            $this->getTemplate($this->defaultRoute);
            $this->getTemplate('footer');
        }elseif(($ri=array_search($route, $this->routes))!==false){
            if(strpos($route, 'ajax-')===0){
                $this->getTemplate($this->routes[$ri]);
            } else {
                $this->getTemplate('header');
                $this->getTemplate($this->routes[$ri]);
                $this->getTemplate('footer');
            }
        } else {
            $this->respond404();
        }
    }

    function respond404(){
        $this->getTemplate('header');
        $this->getTemplate('err-404');
        $this->getTemplate('footer');
    }

    function getTemplate($name) {
        $file = "./app/inc/$name.php";
        include $file;
    }
}
