<?php

namespace App\Repositories;

use App\Models\Customer;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CustomerRepository
{
    protected $model;

    public function __construct(Customer $customer)
    {
        $this->model = $customer;
    }

    /**
     * Get all customers with optional pagination and sorting
     */
    public function getAll(int $perPage = 0, string $sortBy = 'email', string $sortOrder = 'asc'): Collection|LengthAwarePaginator
    {
        $query = $this->model->orderBy($sortBy, $sortOrder);

        return $perPage 
            ? $query->paginate($perPage)
            : $query->get();
    }

    /**
     * Find a customer by ID
     */
    public function find(int $id): ?Customer
    {
        return $this->model->find($id);
    }

    /**
     * Find a customer by ID or throw exception
     */
    public function findOrFail(int $id): Customer
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Create a new customer
     */
    public function create(array $data): Customer
    {
        return $this->model->create($data);
    }

    /**
     * Update a customer by ID
     */
    public function update(int $id, array $data): Customer
    {
        $customer = $this->findOrFail($id);
        $customer->update($data);
        return $customer->fresh(); // Return refreshed model
    }

    /**
     * Delete a customer by ID
     */
    public function delete(int $id): bool
    {
        $customer = $this->findOrFail($id);
        return $customer->delete();
    }

    /**
     * Search customers by keyword in name, email, or phone with optional sorting
     */
    public function search(string $keyword, int $perPage = 0, string $sortBy = 'email', string $sortOrder = 'asc'): Collection|LengthAwarePaginator
    {
        $query = $this->model->where(function ($q) use ($keyword) {
                if (strpos($keyword, ' ') !== false) {
                    list($firstName, $lastName) = explode(' ', $keyword, 2);
                    $q->where(function ($subQuery) use ($firstName, $lastName) {
                        $subQuery->where('first_name', 'LIKE', "%$firstName%")
                                ->where('last_name', 'LIKE', "%$lastName%");
                    });
                } else {
                    // Search by individual first_name or last_name
                    $q->where('first_name', 'LIKE', "%$keyword%")
                    ->orWhere('last_name', 'LIKE', "%$keyword%");
                }

                $q->orWhere('email', 'LIKE', "%$keyword%")
                  ->orWhere('company', 'LIKE', "%$keyword%")
                  ->orWhere('city', 'LIKE', "%$keyword%")
                  ->orWhere('title', 'LIKE', "%$keyword%")
                  ->orWhere('website', 'LIKE', "%$keyword%");
            })
            ->orderBy($sortBy, $sortOrder); // Apply sorting

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Find customers by specific field/value pair
     */
    public function findBy(string $field, string $value): ?Customer
    {
        return $this->model->where($field, $value)
            ->first();
    }

    /**
     * Find customers matching multiple conditions
     */
    public function findWhere(array $conditions): Collection
    {
        return $this->model->where($conditions)
            ->get();
    }

    /**
     * Paginate results
     */
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return $this->model->paginate($perPage);
    }
}