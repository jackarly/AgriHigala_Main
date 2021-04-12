<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminsController extends Controller
{
    // LOGIN FORM
    public function showAdminLoginForm()
    {
        return view('admin.auth.login');
    }

    
}
