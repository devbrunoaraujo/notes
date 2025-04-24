<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index()
    {
        echo "I'm the app";
    }

    public function newNote()
    {
        echo "new note";
    }
}
