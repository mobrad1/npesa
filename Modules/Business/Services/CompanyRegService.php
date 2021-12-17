<?php
namespace Modules\Business\Services;

use App\Services\Helpers\AWSFileUploader;
use Modules\Business\Entities\CompanyRegDetail;
use Modules\Business\Events\CompanyRegistered;

class CompanyRegService
{
    
    /**
     * Upload Company Registration
     *
     * @param  array $data
     * @return array
     */
    public function upload($data)
    {
        $business = request()->user('business');

        $data['reg_file'] = AWSFileUploader::uploadDocument($data['reg_file']);
     
        $company = CompanyRegDetail::updateOrCreate(
            ['business_id'=> $business->id],
            $data
        );

        event(new CompanyRegistered());

        return [
            'status'=> $company ? true : false,
            'message'=> $company ? "Company Profile Successfully uploaded": "An error occured",
            'httpcode'=> $company ? 200 : 500
        ];

    }

}