<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Product;
use App\SRP;

class ProductsController extends Controller
{
    
    public function index(){
        $products = DB::table('products as a')
                    ->join('product_types as b', 'a.product_type_id', '=', 'b.product_type_id')
                    ->where('a.deleted_at', NULL)
                    ->paginate(10);
        return view('admin.products.index',compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        // PRODUCT TABLE VALIDATOR
        $validated = $request->validate([
            'product_name' => ['required','string','min:2', 'unique:products'],
            'category' => ['required']
        ]);
        
        // CREATE PRODUCT
        $product = new Product;
        $product->product_id = $request->input('category');
        $product->product_name = $request->input('product_name');
        $product->product_description = $request->input('product_description');
        $product->save();
        
        // IF PRODUCT SRP IS FILLED
        if ($request->input('srp')){
            //VALIDATOR
            $validated = $request->validate([
                'srp' => ['numeric'],
                'unit' => ['required']
            ]);
            // CREATE SRP
            $srp =  new SRP;
            $srp->unit_id = $request->input('unit');
            $srp->product_price = $request->input('srp');
            $product->srp()->save($srp);
        }

        if ($product){
            request()->session()->flash('success','Successfully added product');
        }
        else{
            request()->session()->flash('error','Error occurred while adding product');
        }
        return redirect()->route('admin.products.index');
    }

    public function show($id)
    {
        //
    }

    public function edit($id){

        // GET PRODUCT & SRP
        $product = Product::find($id);
        $srp = Product::find($id)->srp()->latest()->first();

        // CHECK IF FOUND
        if ($product){
            return view('admin.products.edit',compact('product','srp'));
        }
        else{
            request()->session()->flash('error','An error occurred');
            return redirect()->route('admin.products.index');
        }
    }

    public function update(Request $request, $id)
    {
        // PRODUCT TABLE VALIDATOR
        $validated = $request->validate([
            'product_name' => ['required','string','min:2',Rule::unique('products')->ignore($id, 'product_id')],
            'category' => ['required']
        ]);
        
        // CREATE PRODUCT
        $product = Product::find($id);
        $product->product_name = $request->input('product_name');
        $product->product_type_id = $request->input('category');
        $product->product_description = $request->input('product_description');
        $product->save();
        
        // IF PRODUCT SRP IS FILLED
        if ($request->input('srp')){
            // CHECK IF SAME SRP
            $checkSRP = Product::find($id)->srp()->latest()->first();
            if ($checkSRP->product_price != $request->input('srp') || $checkSRP->unit_id != $request->input('unit')){
                //VALIDATOR
                $validated = $request->validate([
                    'srp' => ['numeric'],
                    'unit' => ['required']
                ]);
                // CREATE SRP
                $srp =  new SRP;
                $srp->unit_id = $request->input('unit');
                $srp->product_price = $request->input('srp');
                $product->srp()->save($srp);
            }
        }

        if ($product){
            request()->session()->flash('success','Successfully updated product');
        }
        else{
            request()->session()->flash('error','Error occurred while updating product');
        }
        return redirect()->route('admin.products.index');
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        if ($product){
            request()->session()->flash('success','Successfully deleted product');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting product');
        }
        return redirect()->route('admin.products.index');
    }
}
