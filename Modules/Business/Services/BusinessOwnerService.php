<?php
namespace Modules\Business\Services;


class BusinessOwnerService
{
    
    /**
     * updateProfile
     *
     * @param  array $data
     * @return array
     */
    public function updateProfile($data)
    {
        $business = request()->user('business');

        $data['is_completed_owner_profile'] = true;
        $updated = $business->update($data);

        return [
            'status'=> $updated ? true : false,
            'message'=> $updated ? "Profile Update was successful": "An error occured",
            'httpcode'=> $updated ? 200 : 500
        ];

    }

}