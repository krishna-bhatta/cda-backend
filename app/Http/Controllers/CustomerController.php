<?php

namespace App\Http\Controllers;

use App\Services\CustomerService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerService $customerService)
    {
        $this->customerService = $customerService;
    }

    /**
     * Get customers with pagination, search, and sorting
     */
    public function index(Request $request): JsonResponse
    {
        $keyword = $request->input('keyword', '');
        $perPage = $request->input('perPage', 10);
        $sortBy = $request->input('sortBy', 'first_name');
        $sortOrder = $request->input('sortOrder', 'asc');

        if ($keyword != '') {
            $customers = $this->customerService->search($keyword, $perPage, $sortBy, $sortOrder);
        } else {
            $customers = $this->customerService->getAll($perPage, $sortBy, $sortOrder);
        }

        return response()->json($customers);
    }

    /**
     * Show a single customer by ID
     */
    public function show(int $id): JsonResponse
    {
        $customer = $this->customerService->findOrFail($id);
        return response()->json($customer);
    }
}
