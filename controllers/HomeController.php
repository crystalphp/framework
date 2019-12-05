<?php

class HomeController extends Controller{
    public function index(Request $r)
    {
    	if(GetInfoForm::submited($r)){
    		if(GetInfoForm::isValid($r)){
    			$data = GetInfoForm::getData($r);
    			return view('Hello' , ['name' => $data['name'] , 'age' => $data['age']]);
    		}else{
    			return GetInfoForm::errorText();
    		}
    	}
    	return view('GetName');
    }
}
