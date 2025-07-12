<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
   public function test_admin()
   {
       return view('admin.test_admin');
   }        
}
