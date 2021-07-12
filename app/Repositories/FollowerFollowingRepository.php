<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Models\Notifications;
use App\Models\FollowerFollowing;
use App\Contracts\FollowerFollowingContract;
use Route;
use Auth;

class FollowerFollowingRepository implements FollowerFollowingContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function followUnfollow(array $data)
    {  
        DB::beginTransaction();

        try {

            $follower_id = $data['id'];
            $following_id = $data['user_id'];

            //type 1 == follow
            if($data['type'] == 1)
            {
                $user = FollowerFollowing::Where('follower_id',$follower_id)->Where('following_id',$following_id)->count();
                
                if($user > 0)
                {
                    return ['result_status'=>2,'message'=>'User already followed'];
                }
                else
                {
                    FollowerFollowing::create([
                        'follower_id' => $follower_id,
                        'following_id'          => $following_id,
                    ]);

                    // Send  Push to Following  User 
                    $following = User::where('id',$following_id)->select('id','device_token','device_type','user_name')->first();

                    $payload =[
                        'title'=>$data['user_name'],
                        'description'=>$data['user_name'].' starting following you',
                    ];

                    if(!empty($following->device_token)){
                        sendPushNotification($following->device_token,$following->device_type,$payload);
                    }
                    
                    Notifications::create([
                        'notification_title'=>$payload['title'],
                        'notification_description'=>$payload['description'],
                        'user_id'=>$following->id,
                        'notification_type'=>1,
                        'status'=>1,
                        'sender_user_id'=>$follower_id,
                        'poll_id'=>0
                    ]);
                    DB::commit();

                    return ['result_status'=>1];
                }
            }
            //type 2 == unfollow
            else if($data['type'] == 2)
            {
                FollowerFollowing::where('follower_id',$follower_id)->where('following_id',$following_id)->delete();
                DB::commit();
                return ['result_status'=>1];
            }
        }
        catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Follower Following : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
        
    }

    public function followerList($data)
    {
        //if set is_all==1 get all follwer result
     if(isset($data['is_all']) && $data['is_all'] == 1){
        $FollowerFollowing = FollowerFollowing::With('user_details')->where('following_id',$data['id'])->orderBy('id', 'desc')->get();
    }
    else
    {
        $page_id = $data['page_id']*10;
        $FollowerFollowing = FollowerFollowing::With('user_details')->where('following_id',$data['id'])->skip($page_id)->take(10)->orderBy('id', 'desc')->get();
    }

    $FollowerFollowing['result_status'] = 1;
    return  $FollowerFollowing;
}

public function followingList($data)
{
        //if set is_all==1 get all following result
    if(isset($data['is_all']) && $data['is_all'] == 1){

        $FollowerFollowing = FollowerFollowing::With('userDetails')->where('follower_id',$data['id'])->orderBy('id', 'desc')->get();
    }
    else
    {
        $page_id = $data['page_id']*10;
        $FollowerFollowing = FollowerFollowing::With('userDetails')->where('follower_id',$data['id'])->skip($page_id)->take(10)->orderBy('id', 'desc')->get();

            // $FollowerFollowing->transform(function ($object) {
            //     $object->is_following = $object->setAppends(['is_following']);
            //     return $object;
            //     });
    }

    $FollowerFollowing['result_status'] = 1;
    return  $FollowerFollowing;
}
}

?>
