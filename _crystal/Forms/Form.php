<?php

namespace Crystal\Forms;

use Crystal\Forms\Formprint;
use Crystal\Http\Request;

class Form{

    public static $error_message = null;
    

	public static function render($field , $attributes=''){
		$form = static::make(new Formprint);
		$field_obj = null;
		foreach($form->fields as $f){
			if($f->name == $field){
				$field_obj = $f;
				break;
			}
		}
		
		if($field_obj->type != 'textarea'){
			$maxlength = $field_obj->max != null ? 'maxlength="'.$field_obj->max.'"' : '';
			$required = $field_obj->required ? 'required' : '';
			$render_html = '<input type="'.$field_obj->type.'" name="'.$field_obj->name.'" '.$required.' '.$attributes.' value="'.$field_obj->default.'" '.$maxlength.' placeholder="'.$field_obj->placeholder.'" />';
		}else{
            $maxlength = $field_obj->max != null ? 'maxlength="'.$field_obj->max.'"' : '';
            $required = $field_obj->required ? 'required' : '';
			$render_html = '<textarea name="'.$field_obj->name.'" '.$required.' '.$maxlength.' '.$attributes.'>'.$field_obj->default.'</textarea>';
		}
		
		return $render_html;
	}
	
	public static function isValid(Request $r , $method='post' , $run_onsubmit=true){
		$form = static::make(new Formprint);
		$m = $method;
		$result = true;
		$error = null;
        foreach($form->fields as $f){
			if($r->$m($f->name) != null || $r->file($f->name)){
                if($f->type == 'file'){
                    $file = request()->file($f->name);
                    if($f->file_validtypes != []){
                        if( ! $file->validTypes($f->file_validtypes)){
                            $result = false;
                            $error = $f->file_validtypes_error;
                            $error = str_replace('{types}', \Crystal\Utilities\Str::make_string_from_array($f->file_validtypes), $error);
                            break;
                        }
                    }

                    if($f->file_invalidtypes != []){
                        if(!$file->invalidTypes($f->file_invalidtypes)){
                            $result = false;
                            $error = $f->file_invalidtypes_error;
                            $error = str_replace('{types}', \Crystal\Utilities\Str::make_string_from_array($f->file_invalidtypes), $error);
                            break;
                        }
                    }

                    if($f->file_max_size != null){
                        if($file->size() > $f->file_max_size){
                            $result = false;
                            $error = $f->file_max_size_error;
                            break;
                        }
                    }else{
                        if($f->max != null){
                            if($file->size() > $f->max){
                                $result = false;
                                $error = $f->max_error;
                                break;
                            }
                        }
                    }
                }
				if($f->type == 'number'){
					if( ! is_numeric($r->$m($f->name))){
						$result = false;
                        $error = $f->numeric_error;
                        break;
					}
				}
			    if($f->max != null) {
			    	if($f->type == 'number'){
			    		if ($r->$m($f->name) > $f->max) {
                        	$result = false;
                        	$error = $f->max_error;
                        	break;
                    	}
			    	}else{
                    	if (strlen($r->$m($f->name)) > $f->max) {
                        	$result = false;
                        	$error = $f->max_error;
                        	break;
                    	}
                	}
                }
				if($f->most_equals != null){
				    $val = '';
				    foreach($form->fields as $tmp){
				        if($tmp->name == $f->most_equals){
				            $val = $r->$m($tmp->name);
                        }
                    }
                    if($r->$m($f->name) == $val){

                    }else{
                        $result = false;
                        $error = $f->most_equals_error;
                        break;
                    }
                }
			}else{
                if($f->required){
                    if($f->type == 'file'){
                        if($r->file($f->name)){

                        }else{
                            $result = false;
                            $error = $f->required_error;
                            break;
                        }
                    }else{
				        $result = false;
				        $error = $f->required_error;
    				    break;
                    }
                }
			}
		}

        static::$error_message = $error;

        if($result){
        	if($run_onsubmit){
                $data = static::getData($r , $method);
        		static::onsubmit($data , $r);
        	}
        }

		return $result;
	}

    public static function errorText()
    {
        return static::$error_message;
	}

    public static function submited(Request $r, $method = 'post')
    {
        $result = true;
        $form = static::make(new Formprint);
        foreach($form->fields as $f){
            if($f->required){
                if($r->$method($f->name) != null){

                }else{
                    if($f->type == 'file'){
                        if($r->file($f->name)){

                        }else{
                            $result = false;
                            break;
                        }
                    }else{
                        $result = false;
                        break;
                    }
                }
            }
        }

        return $result;
	}

    public static function submited_and_is_valid(Request $r , $method="post" , $call_onsubmit=true){
        if(static::submited($r , $method)){
            if(static::isValid($r , $method , $call_onsubmit)){
                return true;
            }
        }

        return false;
    }


	public static function getData(Request $r , $method="post"){
        $form = static::make(new Formprint);
        $data = [];
        foreach($form->fields as $f){
            $data[$f->name] = $r->$method($f->name);
        }

        return $data;
    }
	
}