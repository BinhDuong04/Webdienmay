<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('home/index');
    }

    public function introduce()
    {
        return view('home/introduce');
    }

    public function news()
    {
        return view('home/news');
    }
}