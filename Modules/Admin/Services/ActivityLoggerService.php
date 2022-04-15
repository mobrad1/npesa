<?php


namespace Modules\Admin\Services;


use App\Services\BaseService;
use Spatie\Activitylog\Models\Activity;

class ActivityLoggerService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Activity::class);
    }
}
