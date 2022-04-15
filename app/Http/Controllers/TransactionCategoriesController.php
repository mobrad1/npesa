<?php

namespace App\Http\Controllers;

use App\Enums\TransactionCategories;
use App\Models\TransactionCategory;
use Illuminate\Http\Request;

class TransactionCategoriesController extends Controller
{
    //
    public function index()
    {
        return $this->sendResponse(TransactionCategory::all(),"Transaction categories Loaded");
    }
}
