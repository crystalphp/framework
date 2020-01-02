<?php

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
  private function is_paramable($route){
    return strpos($route , '{');
  }

  private function route_is_sync($route , $uri){
    $route_d = explode('/', $route);
    $uri_d = explode('/', $uri);
    if(count($route_d) != count($uri_d)){
      return false;
    }

    $params = [];

    for($i = 0; $i < count($route_d); $i++){
        if($route_d[$i][0] == '{'){
          $params[substr($route_d[$i], 1 , strlen($route_d) - 1)] = $uri_d[$i];
        }else{
            if($route_d[$i] != $uri_d[$i]){
              return false;
            }
        }
    }

    return $params;
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
   */
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
   */
  function resolve()
  {
    if( ! $this->do_resolve){
      return;
    }
      if(!isset($this->{strtolower($this->request->requestMethod)})){
          return;
      }

    $methodDictionary = $this->{strtolower($this->request->requestMethod)};
    $formatedRoute = $this->formatRoute($this->request->requestUri);
	if(! isset($methodDictionary[$formatedRoute])){
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
    }else {
        echo call_user_func_array($method, array($this->request));
    }

    AppEventListener::on_end_request();
    die('');

  }
  function __destruct()
  {
    $this->resolve();
  }
}