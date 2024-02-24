<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Repository\TransactionRepository;

class TransactionController extends BaseController
{
    private $repo;
    public function __construct()
    {
        $this->repo = new TransactionRepository();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse($this->repo->view_all_transactions(), 'payment successful');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'invoice' => 'required',
            'payment' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors(), 442);
        }
        $input = Arr::only($request->all(), ['invoice','payment']);
        return $this->sendResponse($this->repo->create_transaction($input), 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
       
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
