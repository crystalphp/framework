<?php
/*
namespace Crystal\Http;

use Crystal\App\app;
use Crystal\App\AppEventListener;
use Crystal\Middlewares\Middleware;

class Router
{
  private $do_resolve = true;
  private $base = '';
  private $request;
  private $supportedHttpMethods = array(
    "GET",
    "POST"
  );
  public function base($path = null){
    if($path === null){
      return $this->base;
    }

    $this->base = $path;
  }
  function __construct(IRequest $request = null)
  {
        $this->request = new Request;
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


  function __call($name, $args)
  {
      if($name == 'any'){
          $name = strtolower($_SERVER['REQUEST_METHOD']);
      }
    list($route, $method) = $args;

    $route = $this->base . $route;

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

     if($this->is_paramable($this->formatRoute($args[0]))){
      $result_ris = $this->route_is_sync($this->formatRoute($route) , $this->formatRoute($_SERVER['REQUEST_URI']));
      $params = $result_ris;
        if(is_array($result_ris)){
          if(is_string($method)){
            app::controller($method , $middlewares , $params);
           }else {
              echo call_user_func_array($method, array($this->request , $params));
           }
           $this->do_resolve = false;
           AppEventListener::on_end_request();
            die('');
          }
     }

    if(!in_array(strtoupper($name), $this->supportedHttpMethods))
    {
      $this->invalidMethodHandler();
    }
    $this->{strtolower($name)}[$this->formatRoute($route)] = [$method , $middlewares];
  }
  /**
   * Removes trailing forward slashes from the right of the route.
   * @param route (string)
   */ /*
  private function formatRoute($route)
  {
    $result = rtrim($route, '/');
    if ($result === '')
    {
      return '/';
    }
    return $result;
  }
  private function invalidMethodHandler()
  {
    header("{$this->request->serverProtocol} 405 Method Not Allowed");
  }
  private function defaultRequestHandler()
  {
    header("{$this->request->serverProtocol} 404 Not Found");
  }
  /**
   * Resolves a route
   */ /*
  function resolve()
  {
    if( ! $this->do_resolve){
      return;
    }
      if(!isset($this->{strtolower($this->request->requestMethod)})){
        if($this->is_route_in_other_methods($this->request->path() , $this->request->requestMethod)){
          throw new \Crystal\Exceptions\InvalidRouteMethod([$this->request->path() , $this->request->requestMethod]);
        }
          return;
      }
    $methodDictionary = $this->{strtolower($this->request->requestMethod)};
    $formatedRoute = $this->formatRoute($this->request->requestUri);
	if(! isset($methodDictionary[$formatedRoute])){
    
    if($this->is_route_in_other_methods($this->request->path() , $this->request->requestMethod)){
      throw new \Crystal\Exceptions\InvalidRouteMethod([$this->request->path() , $this->request->requestMethod]);
    }

		AppEventListener::on_error_404();
		$this->defaultRequestHandler();
		return;
  }
    $method = $methodDictionary[$formatedRoute][0];
    if(is_null($method))
    {
      $this->defaultRequestHandler();
      return;
    }

        Middleware::call_requireds();
        Middleware::call_list($methodDictionary[$formatedRoute][1]);

    if(is_string($method)){
        app::controller($method);
    }else{
        echo \Crystal\Controllers\Controller::make_output(call_user_func_array($method, array($this->request)));
    }

    AppEventListener::on_end_request();
    die('');

  }
  function __destruct()
  {
    $this->resolve();
  }




  private function is_route_in_other_methods($route , $default_method){
    foreach($this->supportedHttpMethods as $m){
      if(strtolower($m) != strtolower($default_method)){
        if(isset($this->{strtolower($m)}[$this->formatRoute($route)])){
          return true;
        }
      }
    }

    return false;
  }
}*/
