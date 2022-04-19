<?php

namespace Modules\Customer\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\InviteRequest;
use App\Services\InviteService;
use Illuminate\Http\Request;


class InviteController extends Controller
{
   public $inviteService;

   public function __construct(InviteService $inviteService)
   {
       $this->inviteService = $inviteService;
   }

   public function invite(InviteRequest $request)
   {
       $data = $request->validated();
       $invite = $this->inviteService->invite($data);
       return $this->sendResponse($invite,'User Invite Successfully');
   }
   public function accept(Request $request){
       $token = $request->token;
       try {
           $this->inviteService->accept($token);
           return $this->sendResponse([],'Invite Accepted ');
       }catch (\Exception $e){
           return $this->sendError([],$e->getMessage());
       }
   }
}
