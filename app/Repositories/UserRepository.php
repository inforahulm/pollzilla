<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Models\FollowerFollowing;
use App\Models\SubInterestCategory;
use App\Contracts\UserContract;
use Auth;

class UserRepository implements UserContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function get(int $id)
    {
        return User::With('getCountry')->find($id);
    }

    public function getByEmail($email)
    {
        return User::where('email',$email)->first();
    }

    public function getUserByEmail($email)
    {
        return User::where(function($query) use ($email) {
            $query->whereNotNull('email')->where('email', $email)->where('verify_status', 1);
        })->first();
    }

    public function getUserBySocialId($social_id, $social_types)
    {
        return User::where(function($query) use ($social_id, $social_types) {
            $query->where('social_id', $social_id);
            $query->where('social_types', $social_types);
        })->first();
    }

    public function create($data)
    {

        DB::beginTransaction();

        try {
            $otp = rand(1111,9999);
            $token = md5(uniqid(rand(), true));
            if(isset($data['isguest']) && $data['isguest'] == 1) {
                $data['email'] = $data['device_id'].'@guest.com';
                $data['first_name'] = 'Guest';
                $user = User::updateOrCreate(['email'=> $data['email']],[
                    'user_name'          => uniqid(),
                    'password'           => Hash::make('Pollzilla'),
                    'social_types'       => 1, // 1 = normal login and registration
                    'device_token'       => $data['device_token'],
                    'device_type'        => $data['device_type'],
                    'current_version'    => $data['current_version'],
                    'interest_sub_category_ids' => $data['interest_sub_category_ids'],
                    'isguest'            => true,
                ]);
                DB::commit();
                $token = $user->createToken('Pollzilla')->accessToken;
                $user->save();

                $user_data = getUserData($user->id);
                $user_data->result_status = 1;
                $user_data->token =  $token;
                $user_data->token_type =  'auth';

                return $user_data;
            } else {   

                $user = User::updateOrCreate(['email'=> $data['email']],[
                    'user_name'          => $data['user_name'],
                    'password'           => $data['password'] ? Hash::make($data['password']) : null,
                    'otp'                => $otp,
                    'social_types'                => 1, // 1 = normal login and registration
                    'remember_token'     => $token,
                    'device_token'       => $data['device_token'],
                    'device_type'        => $data['device_type'],
                    'current_version'        => $data['current_version']
                ]);
                DB::commit();

            #Send OTP/Verification mail
            try
            {
                Mail::to($user->email)->send(new SendOtpMail($user));
            }
            catch(\Exception $e){
                Log::debug('Send OTP mail : ',[ 'error' =>$e ]);
            }

            // $user_data = getUserData($user['id']);

                $user_data = array('token'=>$token,'token_type'=>'verify','result_status'=>1,'otp'=>$otp);
                return $user_data;
            }

        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Registration : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong']; 

        }

        
    }

    public function createSocial($data)
    {
        DB::beginTransaction();

        // $token = md5(uniqid(rand(), true));

        try {

            $user = User::create([
                'email' => $data['email'],
                'user_name'          => uniqid().time(),
                'social_types'       => $data['social_types'],
                'social_id'                => $data['social_id'],
                'mobile_number'                => isset($data['mobile_number']) ? $data['mobile_number'] : '',
                'first_name'                => isset($data['first_name']) ? $data['first_name'] : '',
                'verify_status' => 1,
                // 'remember_token'     => $token,
                'device_token'       => $data['device_token'],
                'device_type'        => $data['device_type'],
                'current_version'        => $data['current_version']
            ]);

            $token = $user->createToken('Pollzilla')->accessToken;

            DB::commit();

            $user_data = getUserData($user['id']);
            $user_data->result_status = 1;
            $user_data->token = $token;
            $user_data->token_type = 'auth';
            return $user_data;

        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Create Social : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong']; 

        }
    }

    public function updateSocial($data, $id)
    {
        DB::beginTransaction();

        // $token = md5(uniqid(rand(), true));

        try {
            $user_update = [
                'email' => isset($data['email']) ? $data['email'] : '',
                'social_types'                => $data['social_types'],
                'social_id'                => $data['social_id'],
                'mobile_number'                => isset($data['mobile_number']) ? $data['mobile_number'] : '',
                'first_name'                => isset($data['first_name']) ? $data['first_name'] : '',
                'verify_status' => 1,
                // 'remember_token'     => $token,
                'device_token'       => $data['device_token'],
                'device_type'        => $data['device_type'],
                'current_version'        => $data['current_version']
            ];

            $user_update = User::where('id', $id)->update($user_update);          
            $user_data = getUserData($id);

            $token = $user_data->createToken('Pollzilla')->accessToken;
            $user_data->save();

            DB::commit();
            $user_data->result_status = 1;
            $user_data->token = $token;
            $user_data->token_type = 'auth';
            return $user_data;

        } 
    
        catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Update Social : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong']; 

        }

    }


    public function login($data)
    {
        $user = $this->getByEmail($data['email']);

        if ($user->status != 0) {
            if($user && Hash::check($data['password'], $user->password)) {
                $otp = rand(1111,9999);
                $token = md5(uniqid(rand(), true));
                $user->device_type      =   $data['device_type'];
                $user->device_token     =   $data['device_token'];

                if($user->verify_status != 1) {
                    # Send OTP/Verification mail
                    try {
                        Mail::to($user->email)->send(new SendOtpMail($user));
                    } catch(\Exception $e) {
                        Log::debug('Send OTP mail : ',[ 'error' =>$e ]);
                    }
                    $user->otp              =   $otp;
                    $user->remember_token   =   $token;
                    $user->verify_status        =   0;
                    $user->save();
                    
                    return ['result_status'=>2,'message'=>'Please verify first. after login'];
                } else {

                    $token = $user->createToken('Pollzilla')->accessToken;
                    $user->save();
                    // $userdata = (new UserResource($user))->toArray(request()) + [
                    //     'token' => $token, 
                    //     'token_type' => 'auth',
                    //     'result_status'=>1
                    // ];

                    $user_data = getUserData($user->id);
                    $user_data->result_status = 1;
                    $user_data->token =  $token;
                    $user_data->token_type =  'auth';

                    return $user_data;
                }
            } else {
                return ['result_status'=>0,'message'=>'username or password invalid'];
            }

        } else {
            return ['result_status'=>2,'message'=>'Your account has been blocked'];
        }
    }


    public function verifiyOTP($data)
    {
        if ( request()->hasHeader('VerifyToken') ) {
            $verifyToken = request()->header('VerifyToken');
            $user = User::where('remember_token', $verifyToken)->first();

            
            $data['token_type'] = isset($data['token_type']) ? $data['token_type'] :null;
            
            // dd($user && $user->otp == $data['otp']&& $data['token_type'] != 'forgot');
            // dd($data['token_type']);
            if($user && $user->otp == $data['otp'] && $data['token_type'] != 'forgot') {
                $user->verify_status = 1;
                $user->email_verified_at = date('Y-m-d H:i:s');
                $user->otp = NULL;
                $user->remember_token = '';
                $token = $user->createToken('Pollzilla')->accessToken;
                $user->save();  
                


                $user_data = getUserData($user->id);
                $user_data->result_status = 1;
                $user_data->token =  $token;
                $user_data->token_type =  'auth';
                return  $user_data;
               
            }
            else if($data['token_type'] == 'forgot') {
                $user->verify_status = 1;
                $user->otp = NULL;
                $user_data = [];
                $user_data['result_status'] = 1;
                $user_data['token'] =  $verifyToken;
                $user_data['token_type'] =  'reset-password';

                return  $user_data;
            } else {
                return ['result_status'=>2,'message'=>'Invalid OTP'];
            }
        } else {
            return ['result_status'=>0,'message'=>'The provided verify token is incorrect'];     
        }
    }

    public function resendOTP() 
    {
        if ( request()->hasHeader('VerifyToken') && !empty(request()->header('VerifyToken'))) {
            $verifyToken = request()->header('VerifyToken');

            DB::beginTransaction();

            try {
                $user = User::where('remember_token', $verifyToken)->first();
                if($user){
                    $user->otp = rand(1111,9999);
                    $user->save();

                    // Send OTP/Verification mail
                    try {
                        Mail::to($user->email)->send(new SendOtpMail($user));
                    } catch(\Exception $e){
                        Log::debug('Send OTP mail : ',[ 'error' =>$e ]);
                    }

                    DB::commit();
                    return ['result_status'=>1,'otp' => $user->otp];
                }
                return ['result_status'=>2,'message'=>"We can't find a user with that email address."];
            } catch(\Throwable $e) {
                DB::rollBack();
                Log::debug('Users ResendOtp : ',[ 'error' =>$e ]);
                return ['result_status'=>2,'message'=>'The provided verify token is incorrect'];
            }
        } else {
            return ['result_status'=>0,'message'=>'The provided verify token is incorrect']; 
        }
    }

    public function forgotPassword($data)
    {
        DB::beginTransaction();

        try {

            $user = User::where('email', $data['email'])->first();

            if($user) {
                if($user->verify_status == 0 ) {
                    return ['result_status'=>2,'message'=>'Your account is not verified.'];

                } else {
                    $token = md5(uniqid(rand(), true));
                    $user->otp = rand(1111,9999);
                    $user->remember_token = $token;
                    $user->save();

                    // Send OTP/Verification mail
                    try  {
                        Mail::to($user->email)->send(new SendOtpMail($user,2));
                    } catch(\Exception $e) {
                        Log::debug('Forgot password mail : ',[ 'error' =>$e ]);
                    }

                    DB::commit();

                    return [
                        'otp'           =>  $user->otp,
                        'token'         =>  $token,
                        'token_type'    => 'forgot',
                        'result_status' => 1
                    ];
                }
            } else {
                return ['result_status'=>2,'message'=>"We can't find a user with that email address."];
            }
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Users ForgotPassword : ',[ 'error' =>$e ]);
            return ['result_status'=>2,'message'=>"please try again"];
        }
    }

    public function resetPassword($data)
    { 
        DB::beginTransaction();
        try {
            if ( request()->hasHeader('VerifyToken') ) {
                $verifyToken = request()->header('VerifyToken');
                $user = User::where('remember_token', $verifyToken)->first();
                if($user) {
                    try{
                        $user->remember_token = '';
                        $user->password = Hash::make($data['new_password']);
                        $user->save();
                        DB::commit();
                    }
                    catch(\Exception $e){
                               // do task when error
                                echo $e->getMessage();   // insert query
                                Log::debug('Reset Password : ',[ 'error' =>$e ]);
                                return ['result_status'=>2,'message'=>$e];
                            }

                            $userdata =[
                                'result_status'=>1
                            ];
                            return $userdata;
                        } else {
                            return ['result_status'=>0,'message'=>'The provided verify token is incorrect'];
                        }
                    } else {
                        return ['result_status'=>0,'message'=>'The provided verify token is incorrect']; 
                    }
                } catch(\Throwable $e) {
                    DB::rollBack();
                    Log::debug('Users ChamgePassword : ',[ 'error' =>$e ]);
                    return ['result_status'=>2,'message'=>"please try again"];
                }
            }


            public function changePassword($data)
            {
                DB::beginTransaction();
                try {
                    $user = request()->user();

                    if($user) {
                        if(!empty($data['old_password']) && Hash::check($data['old_password'], $user['password']))
                        {
                            $user->password     =   Hash::make($data['new_password']);
                            $user->save();
                            DB::commit();
                            $userdata =[
                                'result_status'=>1
                            ];
                            return $userdata;
                        }
                        else
                        {
                            return ['result_status'=>0,'message'=>"old password does not match"];
                        }

                    }
                } catch(\Throwable $e) {
                    DB::rollBack();
                    Log::debug('User ChangePassword : ',[ 'error' =>$e ]);
                    return ['result_status'=>2,'message'=>"please try again"];
                }
            }


            public function getProfile($data)
            {
                $getProfile = User::select('id','user_name','first_name','profile_picture')
                ->withCount(['poll','follower','following'])->Where('status',1)
                ->find($data['user_id']);
                
                $is_exists = FollowerFollowing::where('follower_id',Auth::user()->id)->where('following_id',$data['user_id'])->exists();
                $is_exists = $is_exists ? 1 : 0;

                $getProfile['is_following'] = $is_exists;

                $getProfile['result_status'] = 1;
                return  $getProfile;
            }


    // public function logout()
    // {
    //     $user = request()->user();
    //     if($user) {
    //         $token = request()->user()->token();
    //         $token->revoke();
    //         $user->save();
    //         return ['result_status'=>1];
    //     } else {
    //         return ['result_status'=>2,'message'=>"please try again"];
    //     }

    // }

            public function update($data,$id)
            {
                DB::beginTransaction();
                try {

                    $user = request()->user();
                    $user->first_name = isset($data['first_name']) ? $data['first_name'] : $user->first_name;
                    $user->email = isset($data['email']) ? $data['email'] : $user->email;
                    $user->mobile_number = isset($data['mobile_number']) ? $data['mobile_number'] : $user->mobile_number;
                    $user->birthdate = isset($data['birthdate']) ? $data['birthdate'] : $user->birthdate;
                    $user->gender = isset($data['gender']) ? $data['gender'] : $user->gender;
                    $user->user_name = isset($data['user_name']) ? $data['user_name'] : $user->user_name;
                    $user->country_id = isset($data['country_id']) ? $data['country_id'] : $user->country_id;
                    $user->state_id = isset($data['state_id']) ? $data['state_id'] : $user->state_id;
                    $user->city_id = isset($data['city_id']) ? $data['city_id'] : $user->city_id;
                    $user->company_name = isset($data['company_name']) ? $data['company_name'] : $user->company_name;
                    $user->school_name = isset($data['school_name']) ? $data['school_name'] : $user->school_name;
                    $user->facebook_url = isset($data['facebook_url']) ? $data['facebook_url'] : $user->facebook_url;
                    $user->twitter_url = isset($data['twitter_url']) ? $data['twitter_url'] : $user->twitter_url;
                    $user->interest_sub_category_ids = isset($data['interest_sub_category_ids']) ? $data['interest_sub_category_ids'] : $user->interest_sub_category_ids;
                    $user->profile_picture = isset($data['profile_picture']) ? $data['profile_picture'] :  $user->getRawOriginal('profile_picture');
                    
                    $user->save();
                    DB::commit();

                    $user_data = getUserData($user['id']);
                    $user_data->result_status = 1;
                    return $user_data;


                } catch(\Throwable $e) {
                    DB::rollBack();
                    Log::debug('User Profile Update : ',[ 'error' =>$e ]);
                    return ['result_status'=>0,'message'=>"please try again"];
                }
            }


            public function updateDataWhere($data)
            {
                DB::beginTransaction();
                try {
                    $user =$this->get($data['id']);

                    if($user) {
                        $user->status     =   $data['status'];
                        $user->save();
                        DB::commit();
                        return [
                            'result_status'=>1
                        ];
                    }
                } catch(\Throwable $e) {
                    DB::rollBack();
                    Log::debug('User status change : ',[ 'error' =>$e ]);
                    return ['result_status'=>2,'message'=>"please try again"];
                }
            }

            public function getFollowerList($userId) 
            {
                $user =$this->get($userId);
                if($user) {
                    if($user->follower_user_ids){
                        $Follower = User::select('id','user_name','first_name','email','mobile_number','profile_picture')->whereIn('id',explode(',',$user->follower_user_ids))->get();
                    }
                    return ['result_status'=>1,'data'=>$Follower]; 
                } else {
                    return ['result_status'=>2,'message'=>"invalid-user id"];   
                }
            }

            public function getFollowingList($userId) 
            {
                $user =$this->get($userId);
                if($user) {
                    $Following = [];
                    if($user->following_user_ids){
                        $Following = User::select('id','user_name','first_name','email','mobile_number','profile_picture')->whereIn('id',explode(',',$user->following_user_ids))->get();
                    }
                    return ['result_status'=>1,'data'=>$Following]; 
                } else {
                    return ['result_status'=>2,'message'=>"invalid-user id"];   
                }
            }
            
            public function getInterestList($userId) 
            {
                $user =$this->get($userId);
                if($user) {
                    $interest = [];
                    if($user->interest_sub_category_ids){
                        $interest = SubInterestCategory::select('id','interest_sub_category_name')->whereIn('id',explode(',',$user->interest_sub_category_ids))->get();
                    }
                    return ['result_status'=>1,'data'=>$interest]; 
                } else {
                    return ['result_status'=>2,'message'=>"invalid-user id"];   
                }
            }

        }