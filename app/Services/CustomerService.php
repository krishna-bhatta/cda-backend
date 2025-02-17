<?php

namespace App\Services;

use App\Repositories\CustomerRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use App\Models\Customer;

class CustomerService
{
    protected $customerRepository;

    public function __construct(CustomerRepository $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    /**
     * Get all customers with optional pagination and sorting
     */
    public function getAll(int $perPage = 0, string $sortBy = 'first_name', string $sortOrder = 'asc'): Collection|LengthAwarePaginator
    {
        return $this->customerRepository->getAll($perPage, $sortBy, $sortOrder);
    }

    /**
     * Find a customer by ID
     */
    public function find(int $id): ?Customer
    {
        return $this->customerRepository->find($id);
    }

    /**
     * Find a customer by ID or throw exception
     */
    public function findOrFail(int $id): Customer
    {
        return $this->customerRepository->findOrFail($id);
    }

    /**
     * Create a new customer
     */
    public function create(array $data): Customer
    {
        return $this->customerRepository->create($data);
    }

    /**
     * Update a customer by ID
     */
    public function update(int $id, array $data): Customer
    {
        return $this->customerRepository->update($id, $data);
    }

    /**
     * Delete a customer by ID
     */
    public function delete(int $id): bool
    {
        return $this->customerRepository->delete($id);
    }

    /**
     * Search customers by keyword in name, email, or phone with optional sorting
     */
    public function search(string $keyword, int $perPage = 0, string $sortBy = 'first_name', string $sortOrder = 'asc'): Collection|LengthAwarePaginator
    {
        return $this->customerRepository->search($keyword, $perPage, $sortBy, $sortOrder);
    }

    /**
     * Find a customer by a specific field and value
     */
    public function findBy(string $field, string $value): ?Customer
    {
        return $this->customerRepository->findBy($field, $value);
    }

    /**
     * Find customers matching multiple conditions
     */
    public function findWhere(array $conditions): Collection
    {
        return $this->customerRepository->findWhere($conditions);
    }

    /**
     * Paginate results
     */
    public function paginate(int $perPage): LengthAwarePaginator
    {
        return $this->customerRepository->paginate($perPage);
    }
}
