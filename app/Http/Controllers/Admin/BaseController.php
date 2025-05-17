<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class BaseController extends Controller
{
    protected $user;
    protected $template;
    protected $vars = [];
    protected $title;
    protected $content = false;

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        
        $this->user = Auth::user();
    }
    
    protected function renderOutput()
    {
        $this->vars = array_add($this->vars, 'title', $this->title);
        
        if ($this->content) {
            $this->vars = array_add($this->vars, 'content', $this->content);
        }
        
        return view($this->template)->with($this->vars);
    }
}