<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

use App\Models\PollVote;
use App\Models\ActivityFeed;
use App\Models\Notifications;
use App\Models\User;
use App\Models\Poll;
use App\Models\Group;
use App\Models\PollInvite;
use App\Contracts\PollVoteContract;

class PollVoteRepository implements PollVoteContract
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

                $poll = PollVote::create([
                    'poll_id' => $data['poll_id'],
                    'poll_answer_id' => $data['poll_answer_id'],
                    'user_id' => $data['user_id'],
                    'other_answer' => isset($data['hito_meter_ans']) ? $data['hito_meter_ans'] : 0
                ]);
                ActivityFeed::create([
                    'poll_id' => $data['poll_id'],
                    'user_id' => $data['user_id'],
                    'type' => 1, // Type 1 for Vote, Type 2 for Comment  

                ]);

                // Send  Push to Poll Owner User  user  voted on that poll
                $pollOwner = User::where('id',$pollDetails->user_id)->select('id','device_token','device_type','user_name')->first();

                $payload =[
                    'title'=>$data['user_name'],
                    'description'=>'Voted on your poll '.$pollDetails->generic_title,
                ];
                
                if(!empty($pollOwner->device_token))
                {
                    sendPushNotification($pollOwner->device_token,$pollOwner->device_type,$payload);
                }
                
                Notifications::create([
                    'notification_title'=>$payload['title'],
                    'notification_description'=>$payload['description'],
                    'user_id'=>$pollOwner->id,
                    'notification_type'=>3,
                    'sender_user_id'=>$data['user_id'],
                    'poll_id'=>$data['poll_id'],
                    'status'=>1
                ]);
                DB::commit();
            } else {
                return ['result_status'=>2,'message'=>'Already Voted on this poll'];    
            }
            return ['result_status'=>1,'data'=>$poll];
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Create Poll Vote : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }    
    }


    public function get($data)
    {
        return PollVote::where('poll_id',$data['poll_id'])->where('user_id',$data['user_id'])->first();
    }



    public function pollInvite($data) 
    {
        // Send  Push invite on Poll for vote 
        $pollDetails = Poll::where('id',$data['poll_id'])->select('id','generic_title','user_id')->first();
        
        $payload =[
            'title'=>$data['user_name'],
            'description'=>'Invite on poll '.$pollDetails->generic_title,
        ];

        // Invite Single User or Multiple  User
        if($data['type'] == 1){

            $users = explode(',',$data['user_id']);
            $usersData = User::WhereIn('id',$users)->select('id','device_token','device_type','user_name')->get();        
            foreach ($usersData as $userInfo) {
                if(!empty($userInfo->device_token))
                {
                    sendPushNotification($userInfo->device_token,$userInfo->device_type,$payload);
                }
                PollInvite::updateOrCreate(['poll_id'=>$data['poll_id'],'group_or_user_id'=>$userInfo->id],['is_group'=>0,'poll_owner_id'=>$data['auth_id']]);
                Notifications::create([
                    'notification_title'=>$payload['title'],
                    'notification_description'=>$payload['description'],
                    'user_id'=>$userInfo->id,
                    'notification_type'=>2,
                    'poll_id'=>$data['poll_id'],
                    'sender_user_id'=>$data['auth_id'],
                    'status'=>1
                ]);
            }
        } else if($data['type'] == 2){
            // Invite Via Groups 
            $group_ids = explode(',',$data['group_id']);
            $res = Group::whereIn('id',$group_ids)->select(DB::raw('group_concat( distinct group_join_user_ids) as group_join_user_ids'))->first();

            if($res['group_join_user_ids']!=null){
                $users = explode(',',$res['group_join_user_ids']);
                $usersData = User::WhereIn('id',$users)->select('id','device_token','device_type','user_name')->get();        
                foreach ($usersData as $userInfo) {
                    if(!empty($userInfo->device_token))
                    {
                        sendPushNotification($userInfo->device_token,$userInfo->device_type,$payload);
                    }
                    PollInvite::updateOrCreate(['poll_id'=>$data['poll_id'],'group_or_user_id'=>$userInfo->id],['is_group'=>1,'poll_owner_id'=>$data['auth_id']]);
                    Notifications::create([
                        'notification_title'=>$payload['title'],
                        'notification_description'=>$payload['description'],
                        'user_id'=>$userInfo->id,
                        'notification_type'=>2,
                        'poll_id'=>$data['poll_id'],
                        'sender_user_id'=>$data['auth_id'],
                        'status'=>1
                    ]);
                }
            }
        } else {
            $pollDetails->other_contact_invite_count = $pollDetails->other_contact_invite_count + (int) $request->invite_count;
            $pollDetails->save();
        }
        return ['result_status'=>1,'data'=>[]];  
    }

    public function getPollInvitedUsers($data)
    {
        $res =  PollInvite::With('user_data')->where('poll_id',$data['poll_id'])->get();
        return ['result_status'=>1,'data'=>$res];
    }


}