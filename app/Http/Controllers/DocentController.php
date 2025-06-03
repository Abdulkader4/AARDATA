<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DocentController extends Controller
{
    public function index(){
        return view('docent.index');
    }
}
