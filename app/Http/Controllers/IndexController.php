<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function home() {
        $recommendation = post::inRandomOrder(10)->get();
        return view("pages.home", [
            "recommendation" => $recommendation,
        ]);
    }

    public function login() {
        return view('pages.login');
    }
}
