<?php


namespace App\Services;


use App\Models\Invite;
use Illuminate\Support\Str;
use Modules\Customer\Entities\Customer;
use Modules\Customer\Http\Requests\CustomerRegisterRequest;

class InviteService extends BaseService
{
    public function __construct()
    {
        parent::__construct(Invite::class);
    }
    public function accept($token)
    {
        // Look up the invite
        if (!$invite = Invite::where('token', $token)->first()) {
            //if the invite doesn't exist do something more graceful than this
            throw new \Exception('Invite Does not exists');
        }
        $invite->update(['accepted' => true]);
        // here you would probably log the user in and show them the dashboard, but we'll just prove it worked
        return true;
    }

    public function invite(array $attributes)
    {

        // validate the incoming request data
        do {
            //generate a random string using Laravel's str_random helper
            $token = Str::random(20);
        } //check if the token already exists and if it does, try again
        while (Invite::where('token', $token)->first());
        //create a new invite record
        // send the Message
        // redirect back where we came from
        return Invite::create([
            'phone' => $attributes['phone'],
            'token' => $token,
            'invitee_user_type' => Customer::class,
            'invitee_user_id' => auth('customer')->user()->id,
            'invite_user_type' => Customer::class
        ]);
    }

}
