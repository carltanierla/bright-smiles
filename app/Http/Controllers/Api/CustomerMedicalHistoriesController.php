<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCustomerMedicalHistoriesRequest;
use App\Http\Requests\UpdateCustomerMedicalHistoriesRequest;
use App\Models\CustomerMedicalHistories;

class CustomerMedicalHistoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerMedicalHistoriesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerMedicalHistories $customerMedicalHistories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerMedicalHistoriesRequest $request, CustomerMedicalHistories $customerMedicalHistories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerMedicalHistories $customerMedicalHistories)
    {
        //
    }
}
