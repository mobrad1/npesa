<?php

namespace Modules\Business\Http\Controllers;

use Illuminate\Routing\Controller;
use Modules\Business\Traits\ApiResponseHandler;

class BaseController extends Controller
{

    use ApiResponseHandler;
}
