<?php

namespace App\Http\Controllers\Repository;

use Carbon\Carbon;
use App\Models\Sales;
use App\Models\Product;
use App\Models\SalesItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TransactionRepository
{
    public function create_transaction($input)
    {
        
        // $success = DB::transaction(function ($input) {

            $today = Carbon::now()->timezone('Asia/Manila');
            $sale = Sales::select('id','total_amount')->where('invoice','=',$input['invoice'])->first();
            $vat = $sale['total_amount'] * (.12 / 100);
            $total_payment = $vat + $sale['total_amount'];
            $change = $input['payment'] - $total_payment;
            Transaction::create([
                'sales_id'=> $sale['id'],
                'transaction_date'=> $today,
                'transaction_type'=> 'Cash Payment',
                'vat'=> $sale['total_amount'] * (.12 / 100),
                'total_payment'=> $total_payment,
                'payment'=> $input['payment'],
                'change'=> $change,
                'created_by' => Auth::user()->id
            ]);

            $prod = SalesItem::where('sales_id','=',$sale['id'])->select('product_id','qty')->get();
            foreach($prod as $product)
            {
                $stock = Product::findorfail($product['product_id'])->stock_qty;
                Product::findorfail($product['product_id'])->update([
                    'stock_qty' => $stock - $product['qty'],
                    'updated_by' => Auth::user()->id
                ]);

            }

            Sales::findorfail($sale['id'])->update([
                'payment_status' => 'Success',
                'updated_by' => Auth::user()->id
            ]);

            return 'Payment Success';
        // });
    }

    public function view_all_transactions()
    {
        return Transaction::latest()->with('sale','sale.user','sale.product.product')->get();
    }
}
