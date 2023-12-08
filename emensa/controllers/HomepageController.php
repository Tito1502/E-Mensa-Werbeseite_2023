<?php
require_once($_SERVER['DOCUMENT_ROOT'].'/../models/gericht.php');

/* Datei: controllers/HomeController.php */
class HomepageController
{
    public function index(RequestData $request) {
        return view('homepage.homepage');
    }

}