<?php

namespace Modules\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\CreateTransactionCategoryRequest;
use Modules\Admin\Http\Requests\UpdateTransactionCategoryRequest;
use Modules\Admin\Services\TransactionCategoryService;

class TransactionCategoryController extends Controller
{
    public $transactionCategoryService;
    public function __construct(TransactionCategoryService $transactionCategoryService)
    {
        $this->transactionCategoryService = $transactionCategoryService;
    }
    public function store(CreateTransactionCategoryRequest $request)
    {
        $data = $request->validated();
        $category = $this->transactionCategoryService->storeOrUpdate($data);
        return $this->sendResponse($category,"Category Created Successfully");
    }
    public function update(UpdateTransactionCategoryRequest $request,$id)
    {
        $data = $request->validated();
        $category = $this->transactionCategoryService->storeOrUpdate($data,$id);
        return $this->sendResponse($category,"Category Updated Successfully");
    }
    public function delete($id)
    {
        $this->transactionCategoryService->delete($id);
        return $this->sendResponse([],"Category Deleted Successfully");
    }
}
