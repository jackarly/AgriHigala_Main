<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\ReturnOrder;

class OrdersController extends Controller
{

    public function index()
    {
        // SET TITLE
        $title = 'order';

        // GET ORDER, PAYMENT, & RETURN ORDER
        $orders = DB::table('orders as a')
            ->join('payments as b', 'a.order_id', 'b.order_id')
            ->leftJoin('return_orders as c', 'c.order_id', 'a.order_id')
            ->join('fees as d', 'b.fee_id', 'd.fee_id')
            ->select('a.*', 'b.*', 'a.accepted_at as order_accepted_at', 'a.created_at as order_created_at', 'b.created_at as payment_created_at', 'c.return_id', 'c.reason_id', 'c.description', 'c.accepted_at as return_accepted_at', 'c.denied_at as return_denied_at', 'c.created_at as return_created_at', 'c.description as reason_description', 'd.seller_id')
            ->where('a.completed_at', null)
            ->where('c.return_id', null)
            ->paginate(10);

        return view('admin.orders.index',compact('orders', 'title'));
    }

    public function create()
    {
        return redirect()->route('admin.orders.index');
    }

    public function store(Request $request)
    {
        return redirect()->route('admin.orders.index');
    }

    public function show($id)
    {
        // SET TITLE
        $title = 'order';

        // FIND ORDER
        $order = DB::table('orders as a')
            ->join('payments as b', 'a.order_id', 'b.order_id')
            ->leftJoin('return_orders as c', 'c.order_id', 'a.order_id')
            ->join('fees as d', 'b.fee_id', 'd.fee_id')
            ->select('a.*', 'b.*', 'a.accepted_at as order_accepted_at', 'a.created_at as order_created_at', 'b.created_at as payment_created_at', 'c.return_id', 'c.reason_id', 'c.description', 'c.accepted_at as return_accepted_at', 'c.denied_at as return_denied_at', 'c.created_at as return_created_at', 'c.description as reason_description', 'd.seller_id')
            ->where('a.order_id', $id)
            ->first();

        if ($order){
            return view('admin.orders.show',compact('order','title'));
        }
        else{
            request()->session()->flash('error','Order not found');
            return redirect()->route('admin.orders.index');
        }
        
    }

    public function edit($id)
    {
        return redirect()->route('admin.orders.index');
    }

    public function update(Request $request, $id)
    {
        return redirect()->route('admin.orders.index');
    }

    public function destroy($id)
    {
        return redirect()->route('admin.orders.index');
    }

    /* 
    ORDER REQUEST
    SELLER
     */
    public function sellerOrderRequest (Request $request, $id){
        
        // CHECK IF THERE'S A RESPONSE
        $response = $request->input('response');
        if ($response == 'accept'){
            $order = Order::find($id);
            $order->accepted_at = now();
            $order->save();
            request()->session()->flash('success','Order accepted');
        }
        elseif ($response == 'reject') {
            $order = Order::find($id);
            $order->completed_at = now();
            $order->save();
            request()->session()->flash('success','Order rejected');
        }
        else{
            request()->session()->flash('error','Error occurred while updating order');
        }
        return redirect()->route('admin.orders.show',[$id]);
    }

    /* 
    ORDER PENDING
    SELLER
    */
    public function sellerOrderPending (Request $request, $id){
        
        // VALIDATOR FOR RIDER
        $validated = $request->validate([
            'rider' => ['required']
        ]);

        // CHECK IF THERE'S A RESPONSE
        $response = $request->input('response');
        if ($response == 'packed'){
            $order = Order::find($id);
            $order->$request->input('rider');
            $order->packed_at = now();
            $order->save();
            request()->session()->flash('success','Order packed');
        }
        else{
            request()->session()->flash('error','Error occurred while updating order');
        }
        return redirect()->route('admin.orders.show',[$id]);
    }

    /* 
    ORDER PENDING
    BUYER
    */
    public function buyerOrderPending (Request $request, $id){
        
        // CHECK IF THERE'S A RESPONSE
        $response = $request->input('response');
        if ($response == 'cancel'){
            $order = Order::find($id);
            $order->completed_at = now();
            $order->save();
            request()->session()->flash('success','Order cancelled');
        }
        else{
            request()->session()->flash('error','Error occurred while updating order');
        }
        return redirect()->route('admin.orders.show',[$id]);
    }

    /* 
    ORDER DELIVERING
    RIDER
    */
    public function riderOrderDelivering (Request $request, $id){
        
        // CHECK IF THERE'S A RESPONSE
        $response = $request->input('response');
        if ($response == 'delivered'){
            $order = Order::find($id);
            $order->delivered_at = now();
            $order->save();
            request()->session()->flash('success','Order Delivered');
        }
        else{
            request()->session()->flash('error','Error occurred while updating order');
        }
        return redirect()->route('admin.orders.show',[$id]);
    }

    /* 
    ORDER DELIVERED
    BUYER
    */
    public function buyerOrderDelivered (Request $request, $id){
        
        $response = $request->input('response');
        $order = Order::find($id);

        if ($response == 'received' && $order){

            $order = Order::find($id);
            $order->completed_at = now();
            $order->save();
            
            request()->session()->flash('success','Order complete');
        }
        else{
            request()->session()->flash('error','Error occurred while updating order');
        }
        return redirect()->route('admin.orders.show',[$id]);
    }
}
