<?php
class Router
{
  private $request;
  private $supportedHttpMethods = array(
    "GET",
    "POST"
  );
  function __construct(IRequest $request = null)
  {
        $this->request = new Request;
  }
  function __call($name, $args)
  {
      if($name == 'any'){
          $name = strtolower($_SERVER['REQUEST_METHOD']);
      }
    list($route, $method) = $args;

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