<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RatingsController extends Controller
{
    public function index(){

        // GET RATINGS
        $ratings = DB::table('ratings as a')
            ->join('orders as b', 'a.order_id', 'b.order_id')
            ->join('payments as c', 'b.order_id', 'c.order_id')
            ->join('fees as d', 'c.fee_id', 'd.fee_id')
            ->join('buyers as e', 'b.buyer_id', 'e.buyer_id')
            ->join('users as f', 'e.user_id', 'f.user_id')
            ->join('sellers as g', 'd.seller_id', 'g.seller_id')
            ->join('users as h', 'g.user_id', 'h.user_id')
            ->select('a.*','a.created_at as rating_created_at', 'f.f_name as buyer_f_name', 'f.l_name as buyer_l_name', 'f.username as buyer_username', 'h.f_name as seller_f_name', 'h.l_name as seller_l_name', 'h.username as seller_username')
            ->paginate(10);
            // ->get();

        return view('admin.ratings.index',compact('ratings'));
    }
}
