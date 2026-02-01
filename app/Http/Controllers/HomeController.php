<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Countries;
use App\Models\Client;
use App\Helpers\RoleHelper;
use DB;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function home(Request $request)
    {
        
        return view('welcome');
    }
}
