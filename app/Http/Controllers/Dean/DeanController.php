<?php

namespace App\Http\Controllers\Dean;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Schools;
use App\Programs;
class DeanController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:dean');
    }
    /**
     * @return \Illuminate\Support\Facades\Response
     */
    public function index()
    {
        return view('dean.dashboard');
    }
}
