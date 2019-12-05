<?php

/**
 * This is a form
 */
class GetInfoForm extends Form
{
	public function make(Formprint $form){
		$form->text('name')->max(30)->placeholder('نام');
		$form->number('age')->max(100)->placeholder('سن');
		
		return $form; // don't delete this line. $form most be return
	}
}
