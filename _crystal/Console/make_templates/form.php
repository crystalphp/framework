<?php

/**
 * This is a form
 */
class ClassName extends Form
{
	public function make(Formprint $form){
		// use $form variable for set form fields
		
		return $form; // don't delete this line. $form most be return
	}

	public static function onsubmit(Request $r){
		// This function is called when the form is submited
	}
}
