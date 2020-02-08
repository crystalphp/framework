<?php

namespace Crystal\Ajax;

class Response{

	private $res_code = '';

	private function mkcode($code){
		$this->res_code .= $code . '
';
		return $this;
	}

	public function alert($msg){
        return $this->mkcode("alert('{$msg}')");
    }

    public function redirect($to){
        return $this->mkcode("location.href='{$to}'");
    }

    public function jscode($code){
        return $this->mkcode($code);
    }

    public function js($code){
        return $this->jscode($code);
    }

    public function code($code){
        return $this->jscode($code);
    }

    public function elcontentset($selector , $content=''){
        return $this->mkcode("$('{$selector}').html('{$content}')");
    }

    public function elattrset($selector , $attr , $value){
        return $this->mkcode("$('{$selector}').attr('{$attr}' , '{$value}')");
    }

    function __toString(){
    	return $this->res_code;
    }
}
