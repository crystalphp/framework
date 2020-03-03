<?php

namespace Crystal\Http;

use ArrayAccess;

class Request implements ArrayAccess
{
    public function file($key){
        if(isset($_FILES[$key])){
            return new \Crystal\Forms\HttpFile($key);
        }else{
            return null;
        }
    }

    public function requestMethod()
    {
        return strtoupper($_SERVER['REQUEST_METHOD']);
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
        $this->proccess();
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

    private function proccess ()
    {
        $body = $this->getBody();

        foreach ($body as $key => $value)
        {
            $this->{$key} = $value;
        }

    }

    public function getBody()
    {
        $body = [];
        if($this->requestMethod === "GET")
        {
            foreach($_GET as $key => $value)
            {
                $body[$key] = filter_input(INPUT_GET, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        if ($this->requestMethod === "POST")
        {
            foreach($_POST as $key => $value)
            {
                $body[$key] = filter_input(INPUT_POST, $key, FILTER_SANITIZE_SPECIAL_CHARS);
            }
        }
        return $body;
    }

    public function only($array)
    {
        $data = [];
        if(is_array($array))
        {
            foreach ($this->getBody() as $key => $value)
            {
                if(in_array($key, $array))
                    $data[$key] = $value;
            }
        }
        if(is_string($array)){
            $body = $this->getBody();
            $data = $body[$array];
        }
        return $data;
    }

    public function except($array)
    {
        $data = [];
        if(is_array($array))
        {
            $body = $this->getBody();
            foreach ($body as $key => $value)
            {
                if(in_array($key, $array))
                    unset($body[$key]);
            }
            $data = $body;
        }
        if(is_string($array)){
            $body = $this->getBody();
            unset($body[$array]);
            $data = $body;
        }
        return $data;
    }

    public function __toString()
    {
        $content = '';

        foreach ($this as $key => $value)
        {
            $content .= "[$key => $value]";
        }

        return $content;
    }

    public function offsetExists($offset){
        if(is_null($this->{$offset}))
            return false;
        else
            return true;
    }

    public function offsetGet($offset){
        return $this->{$offset};
    }

    public function offsetSet($offset, $value){
        $this->{$offset} = $value;
    }

    public function offsetUnset($offset){
        unset($this->{$offset});
    }

}