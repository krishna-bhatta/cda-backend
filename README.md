
# Laravel API - Customer Management

This is a Laravel-based `backend` for a customer management system. It provides an API to manage customer data. The API includes features such as pagination, searching, and sorting.

## Project Structure
project  
│── frontend   # React frontend  
│── `backend`  # API backend  
│── docker     # Docker-related files  
│── docker-compose.yml  


## Features
- **Customer Management API**: Fetch, search, and sort customer records with pagination support.

## Installation

Follow these steps to set up the backend for the project:

### 1. Clone the repository inside backend
```sh
cd project/backend
```

```sh
git clone https://github.com/krishna-bhatta/cda-backend.git .
```
### 2. Set up your environment variables
Copy `.env.example` to `.env`:

```sh
cp .env.example .env
```
# To complete installation, we need to install composer, generate application key and database setup, Please follow main project readme.md.

## API Endpoints

### `GET /api/customers`
Fetch the list of customers. You can filter and sort the data using the query parameters.

#### Parameters:
- `keyword`: (Optional) Search term to filter customer records.
- `perPage`: (Optional) The number of customers per page (default: 10).
- `sortBy`: (Optional) The field to sort by (default: `first_name`).
- `sortOrder`: (Optional) The sort order (`asc` or `desc`, default: `asc`).

Example request:

```sh
GET http://localhost:8000/api/customers?keyword=john&perPage=20&sortBy=last_name&sortOrder=desc
```

#### Response:
A JSON response containing customer data with pagination.

## Tech Stack

- **Laravel 11.x**: The PHP framework used to build the API.
- **PHP 8.2**: The PHP version required.
- **MySQL**: Used for database management.