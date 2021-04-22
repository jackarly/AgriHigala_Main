<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\User;
use App\Admin;
use App\Seller;
use App\Rider;
use App\Buyer;

class UsersController extends Controller{

    public function index(){
        $users=User::orderBy('user_id','ASC')->paginate(10);
        return view('admin.users.index')->with('users',$users);
    }

    public function create($id=null){
        // CHECK TO $id IS VALID
        if (is_null($id)){
            $user_type = 0;
        }
        else{
            $user_type = $id;
        }
        return view('admin.users.create',compact('user_type'));
    }

    public function store(Request $request){
        // USER TABLE VALIDATOR
        $validated = $request->validate([
            'username' => ['required','string','min:2','regex:/^\S*$/u'],
            'first_name' => ['required','string','min:2','regex:/^[\pL\s\-]+$/u'],
            'middle_name' => ['required','string','min:2','regex:/^[\pL\s\-]+$/u'],
            'last_name' => ['required','string','min:2','regex:/^[\pL\s\-]+$/u'],
            'mobile_number' => ['required','string','digits:11','unique:users'],
            'email' => ['required','email','unique:users']
            // 'mobile_number' => 'required','string','digits:11'|Rule::unique('users')->ignore($id,'user_id'),
            // 'email' => 'required'|Rule::unique('users')->ignore($id, 'user_id')
        ]);

        // CHECK USER TYPE AND WHICH TABLES TO SAVE
        $user_type =  $request->input('user_type');

        // CHECK PASSWORD INPUT IF EMPTY
        if($request->input('password')){
            $password = $request->input('password');
        }
        else{
            $password = $request->input('mobile_number');
        }

        // ASSSIGN INPUT TO USER TABLE
        $user = new User;
        $user->username = $request->input('username');
        $user->password = Hash::make($password);
        $user->f_name = $request->input('first_name');
        $user->m_name = $request->input('middle_name');
        $user->l_name = $request->input('last_name');
        $user->mobile_number = $request->input('mobile_number');
        $user->email = $request->input('email');
        $user->user_type = $user_type;
        // $user->user_image = $request->input('user_image');

        // INITIALIZE IF USER ADDED SUCCESSFULLY
        $status = true;

        switch ($user_type) {
            case 1:
                $admin = new Admin;
                $admin->admin_type_id = 2;
                $user->save();
                $user->admin()->save($admin);
                break;

            case 2:
                // SELLER TABLE VALIDATOR
                $validated = $request->validate([
                    'organization' => ['required'],
                    'schedule_online_time' => ['required']
                ]);

                $seller = new Seller;
                $seller->org_id = $request->input('organization');
                $seller->schedule_online_time = $request->input('schedule_online_time');
                $seller->seller_description = $request->input('seller_description');
                $user->save();
                $user->seller()->save($seller);
                break;
                
            case 3:
                // RIDER TABLE VALIDATOR
                $validated = $request->validate([
                    'seller' => ['required']
                ]);
                $rider = new Rider;
                $rider->seller_id = $request->input('seller');
                $rider->rider_description = $request->input('rider_description');
                $user->save();
                $user->rider()->save($rider);
                break;
                
            case 4:
                // BUYER TABLE VALIDATOR
                $validated = $request->validate([
                    'brgy' => ['required'],
                    'address' =>['required'],
                    'birthdate' => ['required'],
                    'gender' => ['required']
                ]);
                $buyer = new Buyer;
                $buyer->brgy_id = $request->input('brgy');
                $buyer->address = $request->input('address');
                $buyer->birthdate = $request->input('birthdate');
                $buyer->gender = $request->input('gender');
                $user->save();
                $user->buyer()->save($buyer);
                break;
            
            default:
                // USER NOT ADDED SUCCESSFULLY
                $status = false;
                request()->session()->flash('error','Error occurred while adding user');
        }

        // USER ADDED SUCCESSFULLY
        if($status){
            request()->session()->flash('success','Successfully added user');
        }
        return redirect()->route('admin.users.index');
        
    }

    public function show($id){
        //
    }
    
    public function edit($id) {
        // CHECK USER TYPE
        $checkUserType = User::find($id)->user_type;

        // MAKE QUERY
        switch ($checkUserType) {

            case 1:
                // FIND ADMIN
                $user = DB::table('users as a')
                        ->join('admins as b', 'a.user_id', '=', 'b.user_id')
                        ->where('a.user_id', $id)
                        ->first();
                break;

            case 2:
                // FIND SELLER
                $user = DB::table('users as a')
                        ->join('sellers as b', 'a.user_id', '=', 'b.user_id')
                        ->join('orgs as c', 'b.org_id', '=', 'c.org_id')
                        ->where('a.user_id', $id)
                        ->first();
                break;
                
            case 3:
                // FIND RIDER
                $user = DB::table('users as a')
                        ->join('riders as b', 'a.user_id', '=', 'b.user_id')
                        ->where('a.user_id', $id)
                        ->first();
                break;
            
            case 4:
                // BUYER
                $user = DB::table('users as a')
                        ->join('buyers as b', 'a.user_id', '=', 'b.user_id')
                        ->where('a.user_id', $id)
                        ->first();
                break;
            
            default:
                request()->session()->flash('error','An error occurred');
                return redirect()->route('admin.users.index');
                break;
        }
                
        return view('admin.users.edit',compact('user'));
    }

    public function update(Request $request, $id){
        // USER TABLE VALIDATOR
        $validated = $request->validate([
            'username' => ['required','string','min:2','regex:/^\S*$/u',Rule::unique('users')->ignore($id, 'user_id')],
            'first_name' => ['required','string','min:2','regex:/^[\pL\s\-]+$/u'],
            'middle_name' => ['required','string','min:2','regex:/^[\pL\s\-]+$/u'],
            'last_name' => ['required','string','min:2','regex:/^[\pL\s\-]+$/u'],
            'mobile_number' => ['required','string','digits:11',Rule::unique('users')->ignore($id, 'user_id')],
            'email' => ['required','email',Rule::unique('users')->ignore($id, 'user_id')],
        ]);

        // CHECK USER TYPE AND WHICH TABLES TO SAVE
        $checkUserType = User::find($id)->user_type;

        // ASSSIGN INPUT TO USER TABLE
        $user = User::find($id);
        $user->username = $request->input('username');
        $user->f_name = $request->input('first_name');
        $user->m_name = $request->input('middle_name');
        $user->l_name = $request->input('last_name');
        $user->mobile_number = $request->input('mobile_number');
        $user->email = $request->input('email');

        // CHECK PASSWORD INPUT IF EMPTY
        if($request->input('password')){
            $password = $request->input('password');
            $user->password = Hash::make($password);
        }
        // CHECK USER IMAGE IF EMPTY
        // $user->user_image = $request->input('user_image');
        $user->save();

        // INITIALIZE IF USER ADDED SUCCESSFULLY
        $status = true;

        switch ($checkUserType) {

            case 1:
                // ADMIN
                // NO CHANGES IN ADMINS TABLE
                break;

            case 2:
                // SELLER TABLE VALIDATOR
                $validated = $request->validate([
                    'organization' => ['required'],
                    'schedule_online_time' => ['required']
                ]);
                $seller = User::find($id)->seller;
                $seller->org_id = $request->input('organization');
                $seller->schedule_online_time = $request->input('schedule_online_time');
                $seller->seller_description = $request->input('seller_description');
                $seller->save();
                break;
                
            case 3:
                // RIDER TABLE VALIDATOR
                $validated = $request->validate([
                    'seller' => ['required']
                ]);
                $rider = User::find($id)->rider;
                $rider->seller_id = $request->input('seller');
                $rider->rider_description = $request->input('rider_description');
                $rider->save();
                break;
                
            case 4:
                // BUYER TABLE VALIDATOR
                $validated = $request->validate([
                    'brgy' => ['required'],
                    'address' =>['required'],
                    'birthdate' => ['required'],
                    'gender' => ['required']
                ]);
                $buyer = User::find($id)->buyer;
                $buyer->brgy_id = $request->input('brgy');
                $buyer->address = $request->input('address');
                $buyer->birthdate = $request->input('birthdate');
                $buyer->gender = $request->input('gender');
                $buyer->save();
                break;
            
            default:
                // USER NOT UPDATED SUCCESSFULLY
                $status = false;
                request()->session()->flash('error','Error occurred while updating user');
        }

        // USER ADDED SUCCESSFULLY
        if($status){
            request()->session()->flash('success','Successfully updated user');
        }
        return redirect()->route('admin.users.index');
    }

    public function destroy($id){
        $user = User::find($id);
        $user->delete();

        request()->session()->flash('success','Successfully deleted user');
            
        return redirect()->route('admin.users.index');
    }
}
