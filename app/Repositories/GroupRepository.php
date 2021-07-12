<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\Group;
use App\Models\User;
use App\Contracts\GroupContract;

class GroupRepository implements GroupContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function create(array $data)
    {   
       
        DB::beginTransaction();
        try {
            $address = Group::create([
                'group_owner_id' => $data['user_id'],
                'group_join_user_ids' => $data['group_join_user_ids'],
                'group_name' => $data['group_name'],
                'group_icon' => $data['group_icon'],
                'status' => 1
            ]);

            DB::commit();
            $myGroup = $this->groupDetails(['group_id'=>$address->id]);
            return ['result_status'=>1,'data'=>$myGroup];
            
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Create Group : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
        
    }

    public function myGroup($id)
    {
        $myGroup = Group::
        where('status',1)
        ->where('group_owner_id',$id)
        ->select('id','group_name','group_icon','group_join_user_ids', DB::raw("(CHAR_LENGTH(group_join_user_ids) - CHAR_LENGTH(REPLACE(group_join_user_ids, ',', '')) + 1) as total_members"))
        ->orderBy('id','DESC')
        ->get();
        $myGroup['result_status'] = 1;
        return $myGroup;
    }

    public function groupDetails(array $data)
    {
        $groupDetails = Group::where('id',$data['group_id'])
        ->select('id','group_name','group_icon','group_join_user_ids', DB::raw("(CHAR_LENGTH(group_join_user_ids) - CHAR_LENGTH(REPLACE(group_join_user_ids, ',', '')) + 1) as total_members"))
        ->first();

        $memberList = array();
        if($groupDetails->group_join_user_ids){
            $memberList = User::select('id','user_name','first_name','profile_picture')->whereIn('id',explode(',',$groupDetails->group_join_user_ids))->get();
        }

        $groupDetails->member_list = $memberList;
        $groupDetails['result_status'] = 1;
        return $groupDetails;
    }

    public function editGroup(array $data)
    {
        DB::beginTransaction();
        try {
            $group = Group::find($data['group_id']);
            // $group->group_join_user_ids = $data['group_join_user_ids'];
            $group->group_name = $data['group_name'];
            if(isset($data['group_icon']) && !empty($data['group_icon']))
                $group->group_icon = $data['group_icon'];
            $group->save();

            DB::commit();
            $myGroup = $this->groupDetails(['group_id'=>$group->id]);
            return ['result_status'=>1,'data'=>$myGroup];
            
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Edit Group : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
    }

    public function DeleteGroup(array $data)
    {
        DB::beginTransaction();
        try {
            Group::where('id',$data['group_id'])->delete();
            DB::commit();
            return ['result_status'=>1];
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Delete Group : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
    }

    public function addGroupMembers(array $data)
    {   
       
        DB::beginTransaction();
        try {
            $group = Group::find($data['group_id']);
            $group->group_join_user_ids = $data['group_join_user_ids'];
            $group->save();

            DB::commit();
            return ['result_status'=>1];
            
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Add Group Members : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
        
    }

    public function DeleteGroupMember(array $data)
    {
        DB::beginTransaction();
        try {
            $group = Group::find($data['group_id']);
            $array = explode(',', $group['group_join_user_ids']);
            $array_without_ids = array_diff($array, array($data['group_join_user_ids']));
            $group->group_join_user_ids = implode(',', $array_without_ids);
            $group->save();

            DB::commit();
            return ['result_status'=>1];
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Delete Group : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
    }
}

?>
