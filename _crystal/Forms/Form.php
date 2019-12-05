<?php

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
		
		echo $render_html;
	}
	
	public static function isValid(Request $r , $method='post'){
		$form = static::make(new Formprint);
		$m = $method;
		$result = true;
		$error = null;
        foreach($form->fields as $f){
			if($r->$m($f->name) != null){
			    if($f->max != null) {
                    if (strlen($r->$m($f->name)) > $f->max) {
                        $result = false;
                        $error = $f->max_error;
                        break;
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
				$result = false;
				$error = $f->required_error;
				break;
			}
		}

        static::$error_message = $error;

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
            if($r->$method($f->name) != null){

            }else{
                $result = false;
                break;
            }
        }

        return $result;
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