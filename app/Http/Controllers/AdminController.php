<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Products;

class AdminController extends Controller
{
    public function dashboard(){
    	return view('admin.dashboard');
    }

    public function view(){
    	
   		$categories= Category::with('categories')->where(['parent_id'=>0])->get();
   		$products= Products::paginate(3);
   		return view('welcome')->with(compact('categories', 'products'));
    }
}
