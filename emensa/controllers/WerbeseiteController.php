<?php

require_once ("../models/gericht.php");
class WerbeseiteController
{
    public function index()
    {
        dbget5meals(true);
        return view('homepage.homepage');
    }
}