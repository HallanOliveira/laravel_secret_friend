<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function welcome() {
        return view('welcome');
    }
    
    public function home() {
        return view('home', [
            'secretFriends' => ['10/12/2023: Revenda Mais', '25/12/2023: Familia Oliveira']
        ]);
    }
}
