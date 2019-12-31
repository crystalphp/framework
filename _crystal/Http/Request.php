<?php

class Request implements IRequest
{
    public function requestMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function path()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function ip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }
	
	
	public function get($key , $default=null){
		if(isset($_GET[$key])){
			return $_GET[$key];
		}else{
			return $default;
		}
	}
	public function post($key , $default=null){
		if(isset($_POST[$key])){
			return $_POST[$key];
		}else{
			return $default;
		}
	}
	
	
	
	
	
  function __construct()
  {
    $this->bootstrapSelf();
  }
  private function bootstrapSelf()
  {
    foreach($_SERVER as $key => $value)
    {
      $this->{$this->toCamelCase($key)} = $value;
    }
  }
  private function toCamelCase($string)
  {
    $result = strtolower($string);
        
    preg_match_all('/_[a-z]/', $result, $matches);
    foreach($matches[0] as $match)
    {
        $c = str_replace('_', '', strtoupper($match));
        $result = str_replace($match, $c, $result);
    }
    return $result;
  }
  public function getBody()
  {
    if($this->requestMethod === "GET")
    {
      return;
    }
    if ($this->requestMethod == "POST")
    {
      $body = array();
      foreach($_POST as $key => $value)
      {
        $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
      }
      return $body;
    }
  }
}