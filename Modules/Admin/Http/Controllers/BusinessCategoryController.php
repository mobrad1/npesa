<?php

namespace Modules\Admin\Http\Controllers;



use App\Http\Controllers\Controller;
use Modules\Admin\Http\Requests\CreateBusinessCategory;
use Modules\Admin\Http\Requests\UpdateBusinessCategory;
use Modules\Admin\Services\BusinessCategoryService;

class BusinessCategoryController extends Controller
{
   public $businessCategoryService;

   public function __construct(BusinessCategoryService $businessCategoryService)
   {
       $this->businessCategoryService = $businessCategoryService;
   }
   public function store(CreateBusinessCategory $request)
   {
       $data = $request->validated();
       $category = $this->businessCategoryService->storeOrUpdate($data);
       return $this->sendResponse($category,["Business Category Created Successfully"]);
   }
   public function update(UpdateBusinessCategory $request,$id)
   {
       $data = $request->validated();
       $category = $this->businessCategoryService->storeOrUpdate($data,$id);
       return $this->sendResponse($category,["Business Category Updated Successfully"]);
   }
   public function index()
   {
       $categories = $this->businessCategoryService->all();
       return $this->sendResponse($categories,["Business Category Loaded Successfully"]);
   }
   public function delete($id)
   {
       $this->businessCategoryService->delete($id);
       return $this->sendResponse([],'Business Category Deleted Successfully');
   }
}
