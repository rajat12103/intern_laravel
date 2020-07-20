<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Image;
use App\Products;
use App\Category;




class ProductsController extends Controller
{
    public function addProduct(Request $request){

    	if($request->ismethod('post')){
    		$data= $request->all();
    		//echo "<pre>"; print_r($data); die;
    		$product= new Products;
            $product->category_id = $data['category_id'];
    		$product->name = $data['product_name'];
    		$product->code = $data['product_code'];
    		$product->color = $data['product_color'];
    		if(!empty($data['product_description'])){
    			$product->description = $data['product_description'];
    		}
    		else{
    			$product->description = '';
    		}
    		
    		$product->price = $data['product_price'];
    		if($request->hasfile('image')){
    			 $img_tmp=Input::file('image');
    			if($img_tmp->isValid()){

    			//image path code
    			$extension= $img_tmp->getClientOriginalExtension();
    			$filename= rand(111, 99999).'.'.$extension;
    			$img_path= 'uploads/products/'.$filename;

    			//image resize
    			Image::make($img_tmp)->resize(500,500)->save($img_path);

    			$product->image=$filename;
    			}
    		}
    		$product->save();
    		return redirect('/admin/view-products')->with('flash_message_success','Product has been Added Successfully!!');

    	}

        //Categories dropdown menu code
        $categories= Category::where(['parent_id'=>0])->get();
        $categories_dropdown= "<option value='' selected disabled>Select</option>";
        foreach ($categories as $cat) {
            $categories_dropdown.= "<option value='".$cat->id."'>".$cat->name."</option>";
            $sub_categories= Category::where(['parent_id'=>$cat->id])->get();
            foreach ($sub_categories as $sub_cat) {
                 $categories_dropdown.= "<option value='".$sub_cat->id."'>&nbsp;--&nbsp;".$sub_cat->name."</option>";
            }
        }
    	return view('admin.products.add_product')->with(compact('categories_dropdown'));
    }

    public function viewProducts(){
    	$products= Products::get();
    	return view('admin.products.view_products')->with(compact('products'));
    }

    public function editProduct(Request $request, $id=null){
    	if($request->ismethod('post')){
    		$data= $request->all();

    		if($request->hasfile('image')){
    			echo $img_tmp=Input::file('image');
    			if($img_tmp->isValid()){

    			//image path code
    			$extension= $img_tmp->getClientOriginalExtension();
    			$filename= rand(111, 99999).'.'.$extension;
    			$img_path= 'uploads/products/'.$filename;

    			//image resize
    			Image::make($img_tmp)->resize(500,500)->save($img_path);
    			}
    		}
    		else{
    			$filename=$data['current_image'];
    		}

    		if(empty($data['product_description'])){
    			$data['product_description']='';
    		}

    		Products::where(['id'=>$id])->update(['name'=>$data['product_name'], 'category_id'=>$data['category_id'], 'code'=>$data['product_code'], 'color'=>$data['product_color'], 'description'=>$data['product_description'], 'price'=>$data['product_price'], 'image'=>$filename]);
    		return redirect('/admin/view-products')->with('flash_message_success','Product has been updated!!');
    	}
    	$productDetails= Products::where(['id'=>$id])->first();

        //Category Dropdown Code
        $categories= Category::where(['parent_id'=>0])->get();
         $categories_dropdown= "<option value='' selected disabled>Select</option>";
        foreach ($categories as $cat) {
            if($cat->id==$productDetails->category_id){
                $selected="selected";
            }
            else{
                $selected="";
            }
            $categories_dropdown.= "<option value='".$cat->id."'".$selected.">".$cat->name."</option>";


        //for subcategories
        $sub_categories=Category::where(['parent_id'=>$cat->id])->get();
        foreach ($sub_categories as $sub_cat) {
            if($sub_cat->id==$productDetails->category_id){
                $selected="selected";
            }
            else{
                $selected="";
            }
             $categories_dropdown.= "<option value='".$sub_cat->id."'".$selected.">&nbsp; --&nbsp;".$sub_cat->name."</option>";
        }
        }

    	return view('admin.products.edit_product')->with(compact('productDetails','categories_dropdown'));
    }

    public function DeleteProduct($id=null){
        Products::where(['id'=>$id])->delete();
        return redirect()->back()->with('flash_message_error', 'Product Deleted Successfully!!');

    }

   
}
