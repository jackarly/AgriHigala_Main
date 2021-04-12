<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use App\Admin;

class AdminsController extends Controller
{
    // LOGIN FORM
    public function showAdminLoginForm(){
        

        return view('admin.auth.login');
    }

    // public function post(){
    //     $user = new User;
    //     $user->user_type = '1';
    //     $user->username = 'bacon_admin';
    //     $user->password = Hash::make('imung_nawong');
    //     $user->f_name = 'Bacon';
    //     $user->m_name = 'Admin';
    //     $user->l_name = 'Group';
    //     $user->mobile_number = '09351662157';
    //     $user->email = 'bacon@gmail.com';
        
    //     $admin = new Admin;
    //     $admin->admin_type_id = '2';

    //     $user->save();
    //     $user->admin()->save($admin);
    // }

    
}
