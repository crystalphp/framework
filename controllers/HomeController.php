<?php

class HomeController extends Controller{
    public function test(Request $r , $params){
    	if($params['id'] == 12){
    		return redirect('/users/' . $params['id']);
    	}
    	return 'hello ' . $params['id'];
    }
}
