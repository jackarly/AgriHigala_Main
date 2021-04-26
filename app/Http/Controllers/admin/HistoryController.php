<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Order;
use App\ReturnOrder;

class HistoryController extends Controller
{

    public function index()
    {
        // SET TITLE
        $title = 'complete, reject, cancel order';

        // GET ORDER, PAYMENT, & RETURN ORDER
        $orders = DB::table('orders as a')
            ->join('payments as b', 'a.order_id', 'b.order_id')
            ->leftJoin('return_orders as c', 'c.order_id', 'a.order_id')
            ->join('fees as d', 'b.fee_id', 'd.fee_id')
            ->select('a.*', 'b.*', 'a.accepted_at as order_accepted_at', 'a.created_at as order_created_at', 'b.created_at as payment_created_at', 'c.return_id', 'c.reason_id', 'c.description', 'c.accepted_at as return_accepted_at', 'c.denied_at as return_denied_at', 'c.created_at as return_created_at', 'c.description as reason_description', 'd.seller_id')
            ->where('a.completed_at', '<>' ,null)
            // ->get();
            ->paginate(10);

        // dd($orders);

        return view('admin.orders.index',compact('orders', 'title'));
    }
    
    public function create()
    {
        return redirect()->route('admin.returns.index');
    }
    
    public function store(Request $request)
    {
        return redirect()->route('admin.returns.index');
    }
    
    public function show($id)
    {
        // SET TITLE
        $title = 'complete, reject, cancel order';

        // FIND RETURN ORDER
        $order = DB::table('orders as a')
            ->join('payments as b', 'a.order_id', 'b.order_id')
            ->join('return_orders as c', 'c.order_id', 'a.order_id')
            ->join('fees as d', 'b.fee_id', 'd.fee_id')
            ->select('a.*', 'b.*', 'a.accepted_at as order_accepted_at', 'a.created_at as order_created_at', 'b.created_at as payment_created_at', 'c.return_id', 'c.reason_id', 'c.description', 'c.accepted_at as return_accepted_at', 'c.denied_at as return_denied_at', 'c.created_at as return_created_at', 'c.description as reason_description', 'd.seller_id')
            ->where('a.order_id', $id)
            ->where('a.completed_at', '<>' ,null)
            ->first();

        if ($order){
            return view('admin.orders.show',compact('order','title'));
        }
        else{
            request()->session()->flash('error','Return order not found');
            return redirect()->route('admin.returns.index');
        }
    }
    

    public function edit($id)
    {
        return redirect()->route('admin.returns.index');
    }
    
    public function update(Request $request, $id)
    {
        return redirect()->route('admin.returns.index');
    }
    
    public function destroy($id)
    {
        return redirect()->route('admin.returns.index');
    }
}
