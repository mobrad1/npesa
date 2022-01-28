<?php

namespace App\Http\Controllers;

use App\Enums\TransactionCategories;
use Illuminate\Http\Request;

class TransactionCategoriesController extends Controller
{
    //
    public function index()
    {
        return $this->sendResponse(TransactionCategories::all(),"Transaction categories Loaded");
    }
}
