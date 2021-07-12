<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Models\PollComment;
use App\Models\ActivityFeed;
use App\Models\User;
use App\Models\Poll;
use App\Models\Notifications;
use App\Contracts\PollCommentContract;

class PollCommentRepository implements PollCommentContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function create($data)
    {
        try {

            DB::beginTransaction();
            $res = $this->get($data);
            if(empty($res)){
                $pollDetails = Poll::where('id',$data['poll_id'])->select('id','generic_title','user_id')->first();
                $poll = PollComment::create([
                    'poll_id' => $data['poll_id'],
                    'comment' => $data['comment'],
                    'user_id' => $data['user_id'],
                    'status'  => 1  
                ]);

                ActivityFeed::create([
                    'poll_id' => $data['poll_id'],
                    'user_id' => $data['user_id'],
                    'type' => 2, // Type 1 for Vote, Type 2 for Comment  

                ]);

                // Send  Push to Poll Owner User  user  Commented on that poll
                $pollOwner = User::where('id',$pollDetails->user_id)->select('id','device_token','device_type','user_name')->first();

                $payload =[
                    'title'=>$data['user_name'],
                    'description'=>$data['user_name'].' comment on your poll '.$pollDetails->generic_title,
                ];
                
                if(!empty($pollOwner->device_token))
                {
                    sendPushNotification($pollOwner->device_token,$pollOwner->device_type,$payload);
                }
                Notifications::create([
                    'notification_title'=>$payload['title'],
                    'notification_description'=>$payload['description'],
                    'user_id'=>$pollOwner->id,
                    'notification_type'=>4,
                    'sender_user_id'=>$data['user_id'],
                    'poll_id'=>$data['poll_id'],
                    'status'=>1
                ]);
                DB::commit();
            } else {
                return ['result_status'=>2,'message'=>'Already Comment on this poll'];    
            }
            return ['result_status'=>1,'data'=>$poll];
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Create Poll Vote : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }    
    }

    public function list($data)
    { 
        $page_id = (isset($data['page_id']) && $data['page_id'] !=null) ? $data['page_id']*10:0;
        if(isset($data['is_all']) && $data['is_all'] !=null) {
            $res =   PollComment::With('user_data')->where('poll_id',$data['poll_id'])->orderBy('id','DESC')->get();
        } else {
            $res =   PollComment::With('user_data')->where('poll_id',$data['poll_id'])->orderBy('id','DESC')->skip($page_id)->take(10)->get();
        }
        return ['result_status'=>1,'data'=>$res];
    }

    public function get($data)
    {
        return PollComment::where('poll_id',$data['poll_id'])->where('user_id',$data['user_id'])->first();
    }

}