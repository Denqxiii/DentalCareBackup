<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    
    // Add these properties if you're using them
    protected $title;
    protected $content;
    
    // Add this method if you're using renderOutput()
    protected function renderOutput()
    {
        return view('layouts.admin', [
            'title' => $this->title,
            'content' => $this->content
        ]);
    }
}