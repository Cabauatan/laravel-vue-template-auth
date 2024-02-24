<?php

namespace App\Http\Controllers\Api\Maintenance;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Repository\Maintenance\ProductRepository;

class ProductController extends BaseController
{
    private $repo;

    function __construct()
    {
        $this->repo = new ProductRepository();
    }
    public function index()
    {
        return $this->sendResponse($this->repo->viewall(), 'product fetch successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validate = $request->validated();
        $input = Arr::only($validate,[
            'name','category_id','price','stock_qty','reorder_level','description','with_vat'
        ]);
        return $this->sendResponse($this->repo->create($input), 'product created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->sendResponse($this->repo->searchByID($id), 'product data');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, string $id)
    {
        $validate = $request->validated();
        $input = Arr::only($validate,[
            'name','category_id','price','stock_qty','reorder_level','description','with_vat'
        ]);
        return $this->sendResponse($this->repo->update($input,$id), 'product updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->sendResponse($this->repo->delete($id), 'product deleted successfully');
    }
    public function dropdown()
    {
        return $this->sendResponse($this->repo->getProductAndID(), 'dropdown purposes');
    }
    public function getProductStock()
    {
        return $this->sendResponse($this->repo->getProductStock(), 'all stock');
    }
}
