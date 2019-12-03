<?php

class TestMiddleware{
    public function handle(Request $r)
    {

        //return 'access is denied';

        return false;
    }
}
