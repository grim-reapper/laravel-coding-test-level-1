<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PostController extends Controller
{
    protected $url = 'https://jsonplaceholder.typicode.com/posts';
    public function index()
    {
        $data = [];
        $response = Http::get($this->url);
        if($response->ok()) {
            $data = $response->json();
        }
        return view('posts', compact('data'));
    }
}
