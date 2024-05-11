<?php

namespace App\Http\Controllers;

use App\Expense;
use App\Sale;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\User;
use App\UserVerify;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UserController extends Controller
{
    function login(Request $request){
        $data = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if (!auth()->attempt($data)) {
            $request->session()->put('flash_message', 'Invalid Email/Password!');
            return redirect()->back();
        } else {
            $user = auth()->user();
            
            // if($user->reg_approval_status == 1){
                $array = array(
                    'last_login_date' => Carbon::now(),
                );
    
                User::where('id', $user->id)->update($array);
    
                return redirect("/dashboard");
            // }elseif($user->reg_approval_status == 2){
            //     return redirect()->back()->with('success_message', 'Please wait for the approval of your registration!');
            // }elseif($user->reg_approval_status == 0){
            //     return redirect()->back()->with('flash_message', 'Sorry, your registration request is cancelled!');
            // }
        }
    }

    public function verify()
    {
        $user = auth()->user();

        if(!$user->email_verified_at){
            return view("verify_email");
        }

        return redirect('/dashboard');
    }

    public function sendVerificationEmail(Request $request)
    {
        $user = auth()->user();

        $token = Str::random(64);
  
        UserVerify::create([
              'user_id' => $user->id,
              'token' => $token
            ]);
  
        Mail::send('emails.email_verification_email', ['token' => $token, 'user_id' => encrypt($user->id)], function($message) use($user){
            $message->to($user->email);
            $message->subject('Email Verification Mail');
        });

        $request->session()->put('success_message', 'A verification email has been sent to your email address!');

        return redirect()->back();
    }

    public function verifyAccount($token, $user_id)
    {
        try{
            $verifyUser = UserVerify::where('user_id', decrypt($user_id))->where('token', $token)->first();
  
            $message = 'Sorry your email cannot be identified.';
      
            if(!is_null($verifyUser) ){
                $user = $verifyUser->user;
                  
                if(!$user->email_verified_at) {
                    $verifyUser->user->email_verified_at = Carbon::now();
                    $verifyUser->user->reg_approval_date = Carbon::now();
                    $verifyUser->user->reg_approval_status = 1;
                    $verifyUser->user->account_valid_till = Carbon::now()->addDays(45);
                    $verifyUser->user->allow_sub_accounts = 1;
                    $verifyUser->user->service_charge = 10;
                    $verifyUser->user->save();
                    $message = "Your e-mail is verified!";
                } else {
                    $message = "Your e-mail is already verified!";
                }
            }

            return view("verification_message", ["message"=>$message]);
        } catch (\Exception $e) {
            $message = 'Invalid URL! Please try again.';
            return view("verification_message", ["message"=>$message]);
        }
        
        
    }

    function dashboard(){
        $title = 'Dashboard';
        
        $u_id = 0;
        $user = auth()->user();
        $user_id = $user->id;
        $parent_id = $user->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }

        $today_date = Carbon::now()->format('Y-m-d');
        $year = Carbon::now()->format('Y');
        $month_year_title = Carbon::now()->format('M Y');
        $month_year = Carbon::now()->format('Y-m');

        $pending_sales = 0;
        $today_sales = 0;
        $year_sales = 0;
        $month_sales = 0;
        $year_expenses = 0;
        $month_expenses = 0;
        $profit_loss = 0;

        $popular_items = DB::select( DB::raw("SELECT B.name as product_name, C.name as category_name, A.total_sold_qty FROM 
                            (SELECT t2.product_id, SUM(t2.quantity) as total_sold_qty 
                            FROM `sales_summary` as t1
                            INNER JOIN
                            `sales_detail` as t2
                            ON t1.id=t2.invoice_id
                            WHERE t1.user_id=$u_id
                            GROUP BY t2.product_id) as A
                            INNER JOIN
                            `products` as B
                            ON A.product_id=B.id
                            INNER JOIN
                            `category` as C
                            ON B.category_id=C.id
                            ORDER BY A.total_sold_qty DESC
                            LIMIT 10"));

        switch ($user->access_level) {
            case 1:
                $pending_sales = $user->salesParent()->where('status', '=', 0)->count();
                $today_sales = $user->salesParent()->where('status', '=', 1)->where(DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"), $today_date)->sum('grand_total');
                $year_sales = $user->salesParent()->where('status', '=', 1)->where(DB::raw("(DATE_FORMAT(updated_at,'%Y'))"), $year)->sum('grand_total');
                $month_sales = $user->salesParent()->where('status', '=', 1)->where(DB::raw("(DATE_FORMAT(updated_at,'%Y-%m'))"), $month_year)->sum('grand_total');
                $year_expenses = $user->expenseParent()->where(DB::raw("(DATE_FORMAT(updated_at,'%Y'))"), $year)->sum('expense');
                $month_expenses = $user->expenseParent()->where(DB::raw("(DATE_FORMAT(updated_at,'%Y-%m'))"), $year)->sum('expense');
                $profit_loss = $year_sales - $year_expenses;
                break;
            case 2:
                $pending_sales = $user->salesSoldBy()->where('status', '=', 0)->count();
                $today_sales = $user->salesSoldBy()->where('status', '=', 1)->where(DB::raw("(DATE_FORMAT(updated_at,'%Y-%m-%d'))"), $today_date)->sum('grand_total');
                $year_sales = $user->salesSoldBy()->where('status', '=', 1)->where(DB::raw("(DATE_FORMAT(updated_at,'%Y'))"), $year)->sum('grand_total');
                $month_sales = $user->salesSoldBy()->where('status', '=', 1)->where(DB::raw("(DATE_FORMAT(updated_at,'%Y-%m'))"), $month_year)->sum('grand_total');
                $year_expenses = $user->expenseUser()->where(DB::raw("(DATE_FORMAT(updated_at,'%Y'))"), $year)->sum('expense');
                $month_expenses = $user->expenseUser()->where(DB::raw("(DATE_FORMAT(updated_at,'%Y-%m'))"), $year)->sum('expense');
                $profit_loss = $year_sales - $year_expenses;
                break;
            default:
                $pending_sales = 0;
                $today_sales = 0;
                $year_sales = 0;
                $month_sales = 0;
                $year_expenses = 0;
                $month_expenses = 0;
                $profit_loss = 0;
        }

        return view('dashboard', ['title'=>$title, 'pending_sales' => $pending_sales, 'year' => $year, 'month_year_title' => $month_year_title, 'today_sales' => $today_sales, 'year_sales' => $year_sales, 'month_sales' => $month_sales, 'year_expenses' => $year_expenses, 'month_expenses' => $month_expenses, 'profit_loss' => $profit_loss, 'popular_items' => $popular_items]);
    }

    function registrationRequests(){
        $title = 'Registration Requests';

        $registration_requests = User::where('reg_approval_status', 2)->get();

        return view('registration_requests', ['registration_requests'=>$registration_requests, 'title'=>$title]);
    }

    function updateRegistrationInfo($id, Request $request){
        $user_name = $request->input('name');
        $email = $request->input('email');
        $account_valid_till = $request->input('account_valid_till');
        $service_charge = $request->input('service_charge');

        $array = array(
            'allow_sub_accounts' => $request->input('allow_sub_accounts'),
            'account_valid_till' => $account_valid_till,
            'reg_approval_status' => $request->input('registration_status'),
            'status' => $request->input('status'),
            'reg_approval_date' => date('Y-m-d'),
            'service_charge' => $service_charge,
        );

        $res = User::where('id', $id)->update($array);

        if($res == 1){
            $data["user_name"] = $user_name;

            if($request->input('registration_status') == 0){
                $data["account_status"] = 'denied. Currently, we are not allowing any new accounts. Thank you for your interest.';
            }

            if($request->input('registration_status') == 1){
                $data["account_status"] = "approved. Your account validate till: $account_valid_till , Yearly Service Charge: £ $service_charge";
            }

            if($request->input('registration_status') == 2){
                $data["account_status"] = 'pending, we are verifying your request. Please wait 24-48 Hours for the approval';
            }

            Mail::send('emails.account_approval_notification', $data, function($message) use($email)
            {
                $message
                    ->to($email)
                    ->from('info@techexpertsbd.com', 'Tech Experts BD')
                    ->subject('Welcome Message - Restaurant POS');
            });
        }

        return redirect('/registration_requests');
    }

    function users(){
        $title = 'Users';

        $users = User::where('access_level', 1)->where('reg_approval_status', 1)->get();

        return view('users', ['users'=>$users, 'title'=>$title]);
    }

    function newUser(){
        $title = 'New User';

        return view('new_user', ['title'=>$title]);
    }

    function saveNewUser(Request $request){
        $name = $request->input('name');
        $email = $request->input('email');
        $allow_sub_accounts = $request->input('allow_sub_accounts');
        $service_charge = $request->input('service_charge');
        $account_valid_till = $request->input('account_valid_till');
        $status = $request->input('status');
        $mobile = $request->input('mobile');
        $password = $request->input('password');


        $data["user_name"] = $name;

        $user = new User();
        $user->name = $name;
        $user->email = $email;
        $user->mobile = $mobile;
        $user->password = Hash::make(12345678);
        $user->access_level = 1;
        $user->status = $status;
        $user->parent_id = 0;
        $user->reg_approval_status = 1;
        $user->registration_date = date('Y-m-d');
        $user->reg_approval_date = date('Y-m-d');
        $user->allow_sub_accounts = $allow_sub_accounts;
        $user->service_charge = $service_charge;
        $user->account_valid_till = $account_valid_till;
        $user->vat_percentage = 0;
        $save_res = $user->save();

        if($save_res == 1){
    
            $data["account_status"] = "created. Your account validate till: $account_valid_till , Yearly Service Charge: £ $service_charge";

            Mail::send('emails.account_approval_notification', $data, function($message) use($email)
            {
                $message
                    ->to($email)
                    ->from('info@techexpertsbd.com', 'Tech Experts BD')
                    ->subject('Welcome Message - Restaurant POS');
            });

            return redirect('/users')->with('success_message', 'User Creation Successful.');
        }else{
            return redirect('/users')->with('flash_message', 'User Creation Failed!');
        }
    }

    function salesAccounts(){
        $title = 'Sales Accounts';

        $user_id = auth()->user()->id;

        $sales_accounts = User::where('access_level', 2)->where('parent_id', $user_id)->get();

        return view('sales_accounts', ['sales_accounts'=>$sales_accounts, 'title'=>$title]);
    }

    function createSalesAccount(){
        $title = 'Create Sales Account';

        return view('create_sales_account', ['title'=>$title]);
    }

    function saveSalesAccount(Request $request){
        $user = auth()->user();
        $parent_id = $user->id;
        $reg_approval_status = $user->reg_approval_status;
        $registration_date = $user->registration_date;
        $reg_approval_date = $user->reg_approval_date;
        $service_charge = $user->service_charge;
        $account_valid_till = $user->account_valid_till;

        $name = $request->input('name');
        $email = $request->input('email');
        $status = $request->input('status');
        $phone = $request->input('phone');
        $mobile = $request->input('mobile');
        $receipt_note = $request->input('receipt_note');
        $address = $request->input('address');
        $password = $request->input('password');
        $vat_percentage = $request->input('vat_percentage');

        $user = new User();
        $user->name = $name;
        $user->shop_name = $name;
        $user->email = $email;
        $user->mobile = $mobile;
        $user->phone = $phone;
        $user->password = Hash::make($password);
        $user->access_level = 2;
        $user->status = $status;
        $user->parent_id = $parent_id;
        $user->reg_approval_status = $reg_approval_status;
        $user->reg_approval_date = $reg_approval_date;
        $user->registration_date = $registration_date;
        $user->allow_sub_accounts = 0;
        $user->service_charge = $service_charge;
        $user->account_valid_till = $account_valid_till;
        $user->vat_percentage = $vat_percentage;
        $user->address = $address;
        $user->receipt_note = $receipt_note;
        $save_res = $user->save();

        return redirect('/sales_accounts');
    }

    function editSalesAccount($id){
        $title = 'Edit Sales Accounts';

        $sales_account_info = User::find($id);

        return view('edit_sales_account', ['sales_account_info'=>$sales_account_info, 'title'=>$title]);
    }

    function updateSalesAccount($id, Request $request){
        $array = array(
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'shop_name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'mobile' => $request->input('mobile'),
            'receipt_note' => $request->input('receipt_note'),
            'address' => $request->input('address'),
            'vat_percentage' => $request->input('vat_percentage'),
            'status' => $request->input('status'),
        );

        User::where('id', $id)->update($array);
    
        return redirect('/sales_accounts');
    }

    function editRegistrationRequest($id){
        $title = 'Edit Registration Request';

        $data = User::find($id);

        return view('edit_registration_request', ['title'=>$title, 'user_info'=>$data]);
    }

    function editUser($id){
        $title = 'Edit User';

        $data = User::find($id);

        return view('edit_user', ['title'=>$title, 'user_info'=>$data]);
    }

    function updateUser($id, Request $request){
        $array = array(
            'name' => $request->input('name'),
            'allow_sub_accounts' => $request->input('allow_sub_accounts'),
            'account_valid_till' => $request->input('account_valid_till'),
            'service_charge' => $request->input('service_charge'),
            'status' => $request->input('status'),
        );

        User::where('id', $id)->update($array);

        $array_sub_acocunts = array(
            'account_valid_till' => $request->input('account_valid_till'),
            'service_charge' => $request->input('service_charge'),
            'status' => $request->input('status'),
        );

        User::where('parent_id', $id)->update($array_sub_acocunts);
    
        return redirect('/users');
    }

    public function getProfileInfo(){
        $title = 'Profile';

        $user_id = auth()->user()->id;

        $user_info = User::find($user_id);

        return view('user_profile', compact('user_info', 'title'));
    }

    public function updateUserProfile(Request $request, $id){

        $name = $request->name;
        $shop_name = $request->shop_name;
        $address = $request->address;
        $phone = $request->phone;
        $mobile = $request->mobile;
        $receipt_note = $request->receipt_note;
        $vat_percentage = $request->vat_percentage;

        $user = User::find($id);
        $user->name = $name;
        $user->shop_name = $shop_name;
        $user->address = $address;
        $user->phone = $phone;
        $user->mobile = $mobile;
        $user->receipt_note = $receipt_note;
        $user->vat_percentage = $vat_percentage;
        $user->save();

        $request->session()->put('success_message', 'User Profile Successfully Updated.');

        return redirect()->back();
    }

    function resetPassword(Request $request, $id){
        $array = array(
            'password' => Hash::make('12345678'),
        );

        User::where('id', $id)->update($array);

        $request->session()->put('success_message', 'User Password Reset Successful.');

        return redirect()->back();
    }

    function logout(Request $request){
        Auth::logout();
        $request->session()->put('success_message', 'Successfully Logout!');

        return redirect('/');
    }
}
