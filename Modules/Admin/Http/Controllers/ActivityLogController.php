<?php

namespace Modules\Admin\Http\Controllers;


use App\Http\Controllers\Controller;
use Modules\Admin\Services\ActivityLoggerService;


class ActivityLogController extends Controller
{
   public $activityLoggerService;

   public function __construct(ActivityLoggerService $activityLoggerService)
   {
       $this->activityLoggerService = $activityLoggerService;
   }
   public function index()
   {
       $logs = $this->activityLoggerService->all();
       return $this->sendResponse($logs,"Activity Logs Loaded");
   }
}
