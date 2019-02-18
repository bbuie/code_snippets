<?php

namespace App\Http\Controllers;

class ViewController extends Controller
{
    public function renderVueView()
    {
        return view('main');
    }
}