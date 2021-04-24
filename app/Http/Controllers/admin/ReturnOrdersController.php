<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\ReturnOrder;

class ReturnOrdersController extends Controller
{
    /* 
    INDEX
    */
    public function index()
    {
        // SET TITLE
        $title = 'return order';

        // GET ORDER, PAYMENT, & RETURN ORDER
        $orders = DB::table('orders as a')
            ->join('payments as b', 'a.order_id', 'b.order_id')
            ->leftJoin('return_orders as c', 'c.order_id', 'a.order_id')
            ->join('fees as d', 'b.fee_id', 'd.fee_id')
            ->select('a.*', 'b.*', 'a.accepted_at as order_accepted_at', 'a.created_at as order_created_at', 'b.created_at as payment_created_at', 'c.return_id', 'c.reason_id', 'c.description', 'c.accepted_at as return_accepted_at', 'c.denied_at as return_denied_at', 'c.created_at as return_created_at', 'd.seller_id')
            ->where('c.return_id', '<>', null)
            ->where('a.completed_at', null)
            ->paginate(10);

        return view('admin.orders.index',compact('orders', 'title'));
    }

    /* 
    SHOW
    */
    public function show($id)
    {
        // SET TITLE
        $title = 'return order';

        // FIND RETURN ORDER
        $order = DB::table('orders as a')
            ->join('payments as b', 'a.order_id', 'b.order_id')
            ->join('return_orders as c', 'c.order_id', 'a.order_id')
            ->join('fees as d', 'b.fee_id', 'd.fee_id')
            ->select('a.*', 'b.*', 'a.accepted_at as order_accepted_at', 'a.created_at as order_created_at', 'b.created_at as payment_created_at', 'c.return_id', 'c.reason_id', 'c.description', 'c.accepted_at as return_accepted_at', 'c.denied_at as return_denied_at', 'c.created_at as return_created_at', 'd.seller_id')
            ->where('a.order_id', $id)
            ->first();

        if ($order){
            return view('admin.orders.show',compact('order','title'));
        }
        else{
            request()->session()->flash('error','Return order not found');
            return redirect()->route('admin.returns.index');
        }
    }

    /* 
    CREATE
    */
    public function create(Request $request){
        
        // CHECK FOR RESPONSE & ORDER
        $response = $request->input('response');
        $id = $request->input('order');
        $order = Order::find($id);

        if ($response == 'return' && $order){

            // ADD VALIDATOR HERE

            // CREATE RETURN ORDER
            $return = new ReturnOrder;
            $return->order_id = $id;
            $return->reason_id = 1;
            $return->description = 'Default: Change this';
            $return->save();
            
            request()->session()->flash('success','Return Order added');
        }
        else{
            request()->session()->flash('error','Error occurred while updating order');
        }
        return redirect()->route('admin.returns.show',[$id]);
    }

    /* 
    RETURN REQUEST
    SELLER
    */
    public function sellerReturnRequest(Request $request, $id){
        
        // CHECK IF THERE'S A RESPONSE
        $response = $request->input('response');
        $return = Order::find($id)->returnOrder;

        if ($response == 'accept' && $return){
            $return->accepted_at = now();
            $return->save();
            request()->session()->flash('success','Return order accepted');
        }
        elseif ($response == 'reject') {
            $return->denied_at = now();
            $return->save();
            
            $order =Order::find($id);
            $order->completed_at = now();
            $order->save();
            request()->session()->flash('success','Return order rejected');
        }
        else{
            request()->session()->flash('error','Error occurred while updating order');
        }
        return redirect()->route('admin.returns.show',[$id]);
    }

    /* 
    RETURN DELIVERING
    RIDER
    */
    public function riderReturnDelivering(Request $request, $id){
        
        // CHECK IF THERE'S A RESPONSE
        $response = $request->input('response');
        if ($response == 'delivered'){
            $order = Order::find($id);
            $order->completed_at = now();
            $order->save();
            request()->session()->flash('success','Order complete');
        }
        else{
            request()->session()->flash('error','Error occurred while updating order');
        }
        return redirect()->route('admin.returns.show',[$id]);
    }
}
