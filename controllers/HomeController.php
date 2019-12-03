<?php

class HomeController extends Controller{
    public function index(Request $r)
    {
        return view('Hello' , ['name' => 'parsa']);
    }
}
