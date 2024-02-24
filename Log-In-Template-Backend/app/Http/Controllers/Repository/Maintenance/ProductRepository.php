<?php

namespace App\Http\Controllers\Repository\Maintenance;

use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ProductRepository
{
    public function create($input)
    {
        return Product::create([
            'name' => $input['name'],
            'category_id' => $input['category_id'],
            'price'=> $input['price'],
            'stock_qty' => $input['stock_qty'],
            'reorder_level' => $input['reorder_level'],
            'description' => $input['description'],
            // 'with_vat' => $input['with_vat']? true: false,
            'created_by' => Auth::user()->id
        ]);
    }
    public function update($input,$id)
    {
        return Product::findorfail($id)->update([
            'name' => $input['name'],
            'category_id' => $input['category_id'],
            'price'=> $input['price'],
            'stock_qty' => $input['stock_qty'],
            'reorder_level' => $input['reorder_level'],
            'description' => $input['description'],
            // 'with_vat' => $input['with_vat']? true: false,
            'updated_by' => Auth::user()->id
        ]);
    }
    public function delete($id)
    {
        return Product::findorfail($id)->delete();
    }
    public function searchByID($id)
    {
        return Product::findorfail($id)->get();
    }
    public function viewall()
    {
        return Product::where('status','=','Active')->latest()->get();
    }
    public function getProductAndID()
    {
        return Product::select('name','id','price')->where('status','=','Active')->get();
    }


    public function getProductStock()
    {
        $query = Product::where('status','=','Active')->get();

        $res['GoodStock'] = $query->where('stock_qty','>', DB::raw('reorderlevel'));
        $res['OutofStock'] = $query->where('stock_qty','<=', 0);
        $res['NeedToRestock'] = $query->where('stock_qty','<=', DB::raw('reorderlevel'));

        return $res;

    }
}
