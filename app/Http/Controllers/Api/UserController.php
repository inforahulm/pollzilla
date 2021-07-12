<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\User\RegistrationRequest;
use App\Http\Requests\Api\User\SocialRequest;
use App\Http\Requests\Api\User\LoginRequest;
use App\Http\Requests\Api\User\VerifyOtpRequest;
use App\Http\Requests\Api\User\ForgotPasswordRequest;
use App\Http\Requests\Api\User\ResetPasswordRequest;
use App\Http\Requests\Api\User\UpdateProfileRequest;
use App\Http\Requests\Api\User\ChangePasswordRequest;
use App\Http\Requests\Api\User\GuestUserRequest;
use App\Http\Requests\Api\User\UpdateInterestRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

use App\Contracts\UserContract;

class UserController extends BaseController
{
    // private $userService;
    // public function __construct(User $userService)
    // {
    //     $this->userService = $userService;
    // }

    protected $model;
    public function __construct(UserContract $model)
    {
        $this->model = $model;
    }

    public function registration(RegistrationRequest $request)
    {
        $res  = $this->model->create($request->all());
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function socialLogin(SocialRequest $request)
    {
        $user = $this->model->getUserByEmail($request->email);

        if(!$user)
        {
            $user_data = $this->model->getUserBySocialId($request->social_id, $request->social_types);
            if(!$user_data)
            {
                $res  = $this->model->createSocial($request->all());
            }
            else
            {
               $res  = $this->model->updateSocial($request->all(), $user_data['id']); 
           }
       }
       else
       {
        $res  = $this->model->updateSocial($request->all(), $user['id']);
    }

            if($res['result_status']==1) { // Success
                unset($res['result_status']);   
                return $this->sendResponse($res);
            }
            else { // Other Errors  
                return $this->sendError($res['message'], 422);
            }
        }

        public function login(LoginRequest $request)
        {
            $res  = $this->model->login($request->all());

        if($res['result_status']==1) // Login Success
        { 
            unset($res['result_status']);   
            return $this->sendResponse($res);
        } 
        else if($res['result_status']==2) // Block by Admin 
        {  
            return $this->sendError($res['message'], 423);
        } 
        else // Other Errors
        { 
            return $this->sendError($res['message'], 422);
        }
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $res  = $this->model->verifiyOTP($request->all());

        if($res['result_status']==1)  // Success
        {
            unset($res['result_status']);   
            return $this->sendResponse($res);
        } else if($res['result_status']==2){  // Invalid OTP
            return $this->sendValidationError('otp',$res['message']);
        } else { // Other Errors
            return $this->sendError($res['message'], 422);
        }

    }

    public function resendOtp(Request $request)
    {

        $res  = $this->model->resendOTP();

        if($res['result_status']==1) { // Success
            unset($res['result_status']);   
            return $this->sendResponse($res);
        } else if($res['result_status']==2) { // Invalid Token  
            return $this->sendError($res['message'],422);
        } else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }


    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        $res  = $this->model->forgotPassword($request->all());
        if($res['result_status']==1)  // Success
        {
            unset($res['result_status']);   
            return $this->sendResponse($res);
        } else {  // Invalid Token/ or email not found
            return $this->sendError($res['message'],422);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $res  = $this->model->resetPassword($request->all());
        if($res['result_status']==1)  // Success
        {
            unset($res['result_status']);   
            return $this->sendResponse($res);
        } else {  // Invalid Token/ or email not found
            return $this->sendError($res['message'],422);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        $res  = $this->model->changePassword($request->all());
        if($res['result_status']==1)  // Success
        {
            unset($res['result_status']);   
            return $this->sendResponse($res);
        } else {  // Invalid Token/ or email not found
            return $this->sendError($res['message'],422);
        }
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $res  = $this->model->update($request->all(),$request->user()->id);
        if($res['result_status']==1)  // Success
        {
            unset($res['result_status']);   
            return $this->sendResponse($res);
        } else {  // Invalid Token/ or email not found
            return $this->sendError($res['message'],422);
        } 
    }

    public function getProfile(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $data['user_id'] ? $data['user_id'] : request()->user()->id;
        $res  = $this->model->getProfile($data);
        if($res['result_status']==1) {
            unset($res['result_status']);
            return $this->sendResponse($res);
        }
        else {
            return $this->sendError($res['message'], 422);
        }
    }

    public function Guest(GuestUserRequest $request) 
    {
        $data = $request->all();
        $data['isguest'] = 1;
        $res  = $this->model->create($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function myInterest() 
    {
        $user_id = $user = request()->user()->id;
        $res  = $this->model->getInterestList($user_id);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function updateMyInterest(UpdateInterestRequest $request) 
    {
        $user_id = $user = request()->user()->id;
        $res  = $this->model->update($request->all(),$request->user()->id);
       if($res['result_status']==1)  // Success
       {
        unset($res['result_status']);   
        return $this->sendResponse($res);
        } else {  // Invalid Token/ or email not found
            return $this->sendError($res['message'],422);
        }
    }

    public function logout() {
        $user = request()->user();
        if($user) {
            $token = request()->user()->token();
            $token->revoke();
            $user->save();
            return $this->sendResponse([]);
        } else {

            return $this->sendError([],$res['message'],422);
        }
    }
}
