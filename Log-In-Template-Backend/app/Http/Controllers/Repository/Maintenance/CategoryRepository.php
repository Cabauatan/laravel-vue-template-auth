<?php

namespace App\Http\Controllers\Repository\Maintenance;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;



class CategoryRepository
{
    public function create($input)
    {
        return Category::create([
            'name' => $input['name'],
            'created_by' => Auth::user()->id

        ]);
    }
    public function update($input,$id)
    {
        return Category::findorfail($id)->update([
            'name' => $input['name'],
            'status' => $input['status'],
            'updated_by' => Auth::user()->id
        ]);
    }
    public function delete($id)
    {
        return Category::findorfail($id)->delete();
    }
    public function searchByID($id)
    {
        return Category::findorfail($id)->get();
    }
    public function viewall()
    {
        return Category::where('status','=','Active')->orderby('created_at','asc')->get();
    }
    public function getCategoryAndID()
    {
        return Category::select('name','id')->where('status','=','Active')->get();
    }
}
