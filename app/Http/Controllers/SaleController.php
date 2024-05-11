<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

use App\Product;
use App\Table;
use App\Customer;
use App\Sale;
use App\User;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{

    public function pendingSellList(){
        $title = 'Pending Sale List';

        $u_id = 0;
        $user_id = auth()->user()->id;
        $parent_id = auth()->user()->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }

        $pending_list_query = DB::table('sales_summary')
                        ->leftJoin('customers', 'sales_summary.customer_id', '=', 'customers.id')
                        ->leftJoin('tables', 'sales_summary.table_id', '=', 'tables.id')
                        ->select('sales_summary.*', 'customers.customer_code', 'tables.table')
                        ->where('sales_summary.status', '=', 0);

        switch (auth()->user()->access_level) {
            case 1:
                $pending_list_query->where('sales_summary.user_id', '=', $u_id);
                break;
            case 2:
                $pending_list_query->where('sales_summary.sold_by', '=', $user_id);
                break;
            }

        $pending_list = $pending_list_query->get();

        return view('pending_sale_list', ['title'=>$title, 'pending_list'=>$pending_list]);
    }

    public function saleProduct(){
        $title = 'Sale Product';

        $u_id = 0;
        $user_id = auth()->user()->id;
        $parent_id = auth()->user()->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }

        $products = Product::where('user_id', '=', $u_id)->where('status', 1)->get();
        $tables = Table::where('user_id', '=', $u_id)->get();

        return view('sale_product', ['products' => $products, 'tables' => $tables, 'title'=>$title]);
    }
    
    public function saveSaleProduct(Request $request){
        
        $u_id = 0;
        $user_id = auth()->user()->id;
        $parent_id = auth()->user()->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }

        $sale_type = $request->sale_type; 
        $table_no = $request->table_no; 
        $customer_code = $request->customer_code;
        $payment_type = $request->payment_type; 
        $total = $request->total;
        $discount = $request->discount;
        $vat = $request->vat;
        $grand_total = $request->grand_total;

        $product_id_array = $request->product_id_array; 
        $product_qty_array = $request->product_qty_array;
        $product_price_array = $request->product_price_array;

        $customer_id = 0;

        if($customer_code != ''){
            $customer_info = Customer::where('customer_code', '=', $customer_code)->get();
            $customers_count = $customer_info->count();

            if($customers_count == 0){
                $customer = new Customer();
                $customer->customer_code = $customer_code;
                $customer->user_id = $u_id;
                $customer->save();

                $customer_id = $customer->id;
            }else{
                $customer_id = $customer_info[0]->id;
            }
        }

        $invoice_no = $u_id.$user_id.date('YmdHis');

        $invoice_id = DB::table('sales_summary')->insertGetId([
                        'invoice_no' => $invoice_no,
                        'customer_id' => $customer_id,
                        'total_amount' => $total,
                        'discount_percentage' => $discount,
                        'vat_percentage' => $vat,
                        'grand_total' => $grand_total,
                        'table_id' => $table_no,
                        'sold_by' => $user_id,
                        'user_id' => $u_id,
                        'sell_type' => $sale_type,
                        'payment_type' => $payment_type,
                        'status' => 0,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

        foreach($product_id_array as $k => $v){
            
            $data = array(
                'invoice_id' => $invoice_id,
                'product_id' => $v,
                'quantity' => $product_qty_array[$k],
                'price' => $product_price_array[$k],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            DB::table('sales_detail')->insert($data);

        }

        return response()->json($invoice_id);
    }

    public function printOrder($invoice_id){
        $title = 'Print Order';

        $order_info = Sale::find($invoice_id);
        $invoice_no = $order_info->invoice_no;

        $order_list = DB::select(
            DB::raw("SELECT t2.name AS product_name, t1.invoice_id, t1.product_id, 
                    t1.quantity FROM `sales_detail` AS t1
                    LEFT JOIN
                    products AS t2
                    ON t1.product_id=t2.id
                    WHERE t1.invoice_id=$invoice_id"));

        return view('print_order_list', ['invoice_no' => $invoice_no, 'order_list' => $order_list, 'title' => $title]);
    }

    public function printInvoice($invoice_id){
        $title = "Invoice Print";

        $user_id = auth()->user()->id;
        $user_info = User::find($user_id);
        
        $order_summary = Sale::find($invoice_id);

        if($order_summary->status == 1){
            echo '<div style="text-align: center;">';
            echo '<h1 style="background-color: green; color: white;">Already Sold!<h1>';
            echo '<h2 style="background-color: yellow;">Please contact with admin to reprint Invoice.</h2>';
            echo '</div>';
        }elseif($order_summary->status == 2){
            echo '<div style="text-align: center;">';
            echo '<h1 style="background-color: red; color: white;">Already Cancelled!<h1>';
            echo '<h2 style="background-color: yellow;">Please contact with admin to reprint Invoice.</h2>';
            echo '</div>';
        }else{

            $order_summary->status = 1;
            $order_summary->save();

            $order_list = DB::select(
                DB::raw("SELECT t2.name AS product_name, t1.invoice_id, t1.product_id, 
                        t1.quantity, t1.price FROM `sales_detail` AS t1
                        LEFT JOIN
                        products AS t2
                        ON t1.product_id=t2.id
                        WHERE t1.invoice_id=$invoice_id"));
    
            return view('print_order_invoice', ['user_info' => $user_info, 'order_summary' => $order_summary, 'order_list' => $order_list, 'title' => $title]);
        }
    }

    public function editOrder($invoice_id){
        $title = 'Edit Order';

        $u_id = 0;
        $user_id = auth()->user()->id;
        $parent_id = auth()->user()->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }
        
        $tables = Table::where('user_id', '=', $u_id)->get();

        $sales_summary = Sale::find($invoice_id);

        if($sales_summary->status == 0){

            $customer_info = Customer::find($sales_summary->customer_id);

            $sales_detail = DB::select("SELECT t2.name AS product_name, t1.invoice_id, t1.product_id, 
                                    t1.quantity, t1.price FROM `sales_detail` AS t1
                                    LEFT JOIN
                                    products AS t2
                                    ON t1.product_id=t2.id
                                    WHERE t1.invoice_id=$invoice_id");

            $prod_array = [];

            foreach($sales_detail as $sd){
                array_push($prod_array, $sd->product_id);
            }

            $products = Product::where('user_id', '=', $u_id)
                        ->whereNotIn('id', $prod_array)
                        ->where('status', 1)
                        ->get();

            return view('edit_sale_product', ['products' => $products, 'tables' => $tables, 'sales_summary'=>$sales_summary, 'sales_detail'=>$sales_detail, 'customer_info'=>$customer_info, 'title' => $title]);

        }elseif($sales_summary->status == 1){
            echo '<div style="text-align: center;">';
            echo '<h1 style="background-color: green; color: white;">Already Sold!<h1>';
            echo '<h2 style="background-color: yellow;">Please contact with admin to reprint Invoice.</h2>';
            echo '</div>';
        }else{
            echo '<div style="text-align: center;">';
            echo '<h1 style="background-color: red; color: white;">Already Cancelled!<h1>';
            echo '<h2 style="background-color: yellow;">Please contact with admin to reprint Invoice.</h2>';
            echo '</div>';
        }
       
    }

    public function udpateSaleProduct(Request $request){
        
        $u_id = 0;
        $user_id = auth()->user()->id;
        $parent_id = auth()->user()->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }

        $invoice_id = $request->invoice_id; 
        $sale_type = $request->sale_type; 
        $table_no = $request->table_no; 
        $customer_code = $request->customer_code;
        $payment_type = $request->payment_type; 
        $total = $request->total;
        $discount = $request->discount;
        $vat = $request->vat;
        $grand_total = $request->grand_total;

        $product_id_array = $request->product_id_array; 
        $product_qty_array = $request->product_qty_array;
        $product_price_array = $request->product_price_array;

        $customer_id = 0;

        if($customer_code != ''){
            $customer_info = Customer::where('customer_code', '=', $customer_code)->get();
            $customers_count = $customer_info->count();

            if($customers_count == 0){
                $customer = new Customer();
                $customer->customer_code = $customer_code;
                $customer->user_id = $u_id;
                $customer->save();

                $customer_id = $customer->id;
            }else{
                $customer_id = $customer_info[0]->id;
            }
        }

        $affected = DB::table('sales_summary')
                    ->where('id', $invoice_id)
                    ->update([
                        'customer_id' => $customer_id,
                        'total_amount' => $total,
                        'discount_percentage' => $discount,
                        'vat_percentage' => $vat,
                        'grand_total' => $grand_total,
                        'table_id' => $table_no,
                        'sold_by' => $user_id,
                        'user_id' => $u_id,
                        'sell_type' => $sale_type,
                        'payment_type' => $payment_type,
                        'updated_at' => date('Y-m-d H:i:s'),
                    ]);

        DB::table('sales_detail')->where('invoice_id', '=', $invoice_id)->delete();

        foreach($product_id_array as $k => $v){
            
            $data = array(
                'invoice_id' => $invoice_id,
                'product_id' => $v,
                'quantity' => $product_qty_array[$k],
                'price' => $product_price_array[$k],
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            );

            DB::table('sales_detail')->insert($data);

        }

        return response()->json($invoice_id);
    }

    public function reconcileOrder(){
        $title = 'Reconcile Order';

        $u_id = 0;
        $user_id = auth()->user()->id;
        $parent_id = auth()->user()->parent_id;

        if($parent_id == 0){
            $u_id = $user_id;
        }else{
            $u_id = $parent_id;
        }
        
        $invoice_nos = Sale::where('user_id', $u_id)->select('id', 'invoice_no', 'grand_total')->orderBy('id', 'desc')->get();

        return view('reconcile_order', ['title'=>$title, 'invoice_nos'=>$invoice_nos]);
    }

    public function allowReconciliation(Request $request){
        $invoice_id = $request->invoice_id;

        $sales = Sale::find($invoice_id);
        $sales->status = 0;
        $sales->save();

        Session::put('success_message', 'Order is open now for reconciliation.');

        return redirect()->back();
    }
}
