<?php

class HomeController extends Controller{


    public function sessions(Request $r){

        return 'hello';

    }









    public function index(Request $r)
    {

        $users = User::all();
        return view('User.List' , ['users' => $users]);


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


    public function peoples(Request $r){
        $peoples = [
            'parsa',
            'amir',
            'nasim',
            'ali',
            'maryam',
            'farhad',
            'goli',
        ];
        return view('list' , ['peoples' => $peoples]);
    }
}
