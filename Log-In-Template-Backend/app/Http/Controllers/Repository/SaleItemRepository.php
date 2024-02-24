<?php

namespace App\Http\Controllers\Repository;

use App\Models\Sales;
use App\Models\Product;
use App\Models\SalesItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class SaleItemRepository
{
    public function create_sale_items($input)
    {
        $total = DB::transaction(function () use($input) {
            $sub_total = 0;
            $sale_id = Sales::where('invoice','=',$input['invoice'])->first()->id;

            foreach ($input['product_id'] as $product)
            {
                $product_price = Product::where('id','=',$product['product_id'])->first()->price;
                $sub_total = $sub_total +($product['qty'] * $product_price);
                SalesItem::create([
                    'sales_id' => $sale_id,
                    'product_id' => $product['product_id'],
                    'qty' => $product['qty'],
                    'sub_total' => $sub_total,
                    'created_by' => Auth::user()->id
                ]);
            }
            Sales::findorfail($sale_id)->update([
                'total_amount'  => $sub_total
            ]);
            return $sub_total;
        });
        return $total;
    }
}
