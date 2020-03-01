<?php

namespace Crystal\Http;

use Crystal\App\app;
use Crystal\App\AppEventListener;
use Crystal\Http\Middleware;

class Router{
    private $base = '';
    private $request;
    private $supportedHttpMethods = [
        "GET",
        "POST",
    ];

    public static $do_finish = true;

    private $invalid_route_method = null;

    public function base($path = null){
        if($path === null){
            return $this->base;
        }

        $this->base = $path;
    }

    function __construct()
    {
        $this->request = new Request;
    }

    private function is_paramable($route){
        return strpos($route , '{') && strpos($route , '}');
    }

    private function route_is_sync($route , $uri){
        if($route[0] == '/'){
        $route = substr($route, 1);
        }
        if($uri[0] == '/'){
        $uri = substr($uri, 1);
        }
        $route_d = explode('/', $this->formatRoute($route));
        $uri_d = explode('/', $this->formatRoute($uri));
        if(count($route_d) != count($uri_d)){
            return false;
        }

        $params = [];

        for($i = 0; $i < count($route_d); $i++){
            if($route_d[$i][0] == '{'){
                $params[substr($route_d[$i], 1 , strlen($route_d[$i]) - 2)] = $uri_d[$i];
            }else{
                if($route_d[$i] != $uri_d[$i]){
                    return false;
                }
            }
        }

        return $params;
    }


    public function redirect($from , $to){
        $from = $this->formatRoute($this->base . $from);
        $to = $this->formatRoute($this->base . $to);
        $here = $this->formatRoute($this->request->path());

        if($from == $here){
            redirect($to);
            die('');
        }
    }

    public function view($uri , $view){
        $this->any($uri , function() use ($view){
            return view($view);
        });
    }



    private function formatRoute($route)
    {
        $result = rtrim($route, '/');
        if ($result === '')
        {
            return '/';
        }
        return $result;
    }



    public function invalidMethodHandler(){

    }




    function __call($name , $args){
        if($name == 'any'){
            $name = strtolower($_SERVER['REQUEST_METHOD']);
        }

        if(!in_array(strtoupper($name), $this->supportedHttpMethods))
        {
            $this->invalidMethodHandler();
        }

        list($route, $method) = $args;

        $route = $this->base . $route;
        $route = $this->formatRoute($route);

        $middlewares = [];
        if(isset($args[2])){
            if(is_array($args[2])){
                $middlewares = $args[2];
            }else{
                if(is_string($args[2])){
                    $middlewares = [$args[2]];
                }
            }
        }

        Middleware::call_list($middlewares);

        if($this->is_paramable($this->formatRoute($args[0]))){
            $result_ris = $this->route_is_sync($this->formatRoute($route) , $this->formatRoute($_SERVER['REQUEST_URI']));
            $params = $result_ris;
            if(is_array($result_ris)){
                $response = '';
                if(is_string($method)){
                    $response = app::controller($method , $middlewares , $params);
                }else {
                    $response = call_user_func_array($method, array($this->request , $params));
                }
                return $this->send_response($response);
            }
        }


        $req_uri = $_SERVER['REQUEST_URI'];
        $req_uri = $this->formatRoute($req_uri);



        if($req_uri == $route){
            if(strtoupper($name) != strtoupper($_SERVER['REQUEST_METHOD'])){
                $this->invalid_route_method = [$route];
                return;
            }
            $response = '';
            if(is_string($method)){
                $response = app::controller($method , $middlewares , []);
            }else {
                $response = call_user_func_array($method, array($this->request , []));
            }
            return $this->send_response($response);
        }


    }



    private function send_response($response){
        echo $response;
        AppEventListener::on_end_request();
        static::$do_finish = false;
        $this->invalid_route_method = null;
        die('');
    }



    function finish(){
        if($this->invalid_route_method !== null){
            throw new \Crystal\Exceptions\InvalidRouteMethod([$this->request->path() , $this->request->requestMethod]);
        }


        if( ! static::$do_finish){
            return;
        }



        $response = AppEventListener::on_error_404();
        echo $response;
        static::$do_finish = false;
        $this->invalid_route_method = null;
        return;
    }
}
