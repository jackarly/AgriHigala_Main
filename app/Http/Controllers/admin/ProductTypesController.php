<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ProductType;

class ProductTypesController extends Controller
{
    
    public function index(){
        $categories=ProductType::orderBy('product_type_id')->paginate(10);
        return view('admin.categories.index',compact('categories'));
    }

    public function create(){

        return view('admin.categories.create');
    }

    public function store(Request $request){

        // PRODUCT TYPE TABLE VALIDATOR
        $validated = $request->validate([
            'title' => ['required','string','min:2'],
            'description' => ['required','string','min:2'],
        ]);

        // ASSIGN INPUT TO PRODUCT TYPE TABLE
        $category = new ProductType;
        $category->product_type_name = $request->input('title');
        $category->product_type_description = $request->input('description');
        $category->save();
        
        if ($category){
            request()->session()->flash('success','Successfully added category');
        }
        else{
            request()->session()->flash('error','Error occurred while adding category');
        }
        return redirect()->route('admin.categories.index');
    }

    public function show($id){
        //
    }

    public function edit($id){
        $category = ProductType::find($id);
        if ($category){
            return view('admin.categories.edit',compact('category'));
        }
        else{
            request()->session()->flash('error','An error occurred');
            return redirect()->route('admin.categories.index');
        }
    }
    
    public function update(Request $request, $id){
        // PRODUCT TYPE TABLE VALIDATOR
        $validated = $request->validate([
            'title' => ['required','string','min:2'],
            'description' => ['required','string','min:2'],
        ]);

        $category = ProductType::find($id);
        $category->product_type_name = $request->input('title');
        $category->product_type_description = $request->input('description');
        $category->save();

        if ($category){
            request()->session()->flash('success','Successfully updated category');
        }
        else{
            request()->session()->flash('error','Error occurred while updating category');
        }
        return redirect()->route('admin.categories.index');
    }
    
    public function destroy($id){
        $category = ProductType::find($id);
        $category->delete();

        if ($category){
            request()->session()->flash('success','Successfully deleted category');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting category');
        }
        return redirect()->route('admin.categories.index');
    }
}
