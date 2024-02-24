<?php

namespace App\Http\Controllers\Api\Maintenance;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\Repository\Maintenance\CategoryRepository;

class CategoryController extends BaseController
{
    private $repo;

    function __construct()
    {
        $this->repo = new CategoryRepository();
    }

    public function index()
    {
        return $this->sendResponse($this->repo->viewall(), 'category created successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validate = $request->validated();
        $input = Arr::only($validate,['name']);
        return $this->sendResponse($this->repo->create($input), 'category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return $this->sendResponse($this->repo->searchByID($id), 'category data');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        $allrequest = $request->validated();
        $input = Arr::only($allrequest,['name','status']);
        return $this->sendResponse($this->repo->update($input,$id), 'category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return $this->sendResponse($this->repo->delete($id), 'category deleted successfully');
        
    }

    public function dropdown()
    {
        return $this->sendResponse($this->repo->getCategoryAndID(), 'dropdown purposes');
    }
}
