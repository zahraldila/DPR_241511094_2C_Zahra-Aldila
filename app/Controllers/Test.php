<?php

namespace App\Controllers;

class Test extends BaseController
{
    public function display(): string
    {
        return view('test');
    }
}
