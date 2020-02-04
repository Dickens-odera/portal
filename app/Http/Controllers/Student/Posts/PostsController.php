<?php

namespace App\Http\Controllers\Student\Posts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Posts;
class PostsController extends Controller
{
    public function post_data()
    {
        //Posts::create($this->validate_request());
    }
    private function validate_request()
    {
       return request()->validate([
            'title'=>'required',
            'author'=>'required'
        ]);
    }
}
