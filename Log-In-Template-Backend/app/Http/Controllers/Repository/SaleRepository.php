<?php

namespace App\Http\Controllers\Repository;

use Carbon\Carbon;
use App\Models\Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SalesItem;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class SaleRepository
{
    public function create_sale($input)
    {
        $today = Carbon::now()->timezone('Asia/Manila');
        $year = Carbon::createFromFormat('m/d/Y', date_format($today, "m/d/y"))->format('y');
        $month = Carbon::createFromFormat('m/d/Y', date_format($today, "m/d/Y"))->format('m');
        return Sales::create([
            'user_id' => Auth::user()->id,
            'invoice' => $year . '-' . $month . '-' . sprintf("%04d", Sales::whereMonth('created_at', $today)->withTrashed()->count() + 1),
            'sale_created' => $today,
            'payment_method' => $input['payment_method'],
            'payment_status' => "Pending",
            'total_amount' => 0.00,
            'created_by' => Auth::user()->id
        ]);
    }
    public function cancel_order($input,$id)
    {
        $today = Carbon::now()->timezone('Asia/Manila');
        return Sales::findorfail($id)->update([
            'reason' => $input['reason'],
            'cancel_date' => $today,
            'updated_by' => Auth::user()->id

        ]);
    }

    public function show_order($id)
    {
        return Sales::findorfail($id)->with('product')->get();
    }

    public function view_all_sale()
    {
        $query = Sales::get();
        $res['payment_status_pending'] = $query->where('payment_status' , '=', 'Pending');
        $res['payment_status_cancel'] = $query->where('payment_status' , '=', 'Cancel');
        $res['payment_status_sucess'] = $query->where('payment_status' , '=', 'Success');

        return $res;
    }
}
