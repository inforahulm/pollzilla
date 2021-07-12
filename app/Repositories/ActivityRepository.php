<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\ActivityFeed;
use App\Models\Poll;
use App\Contracts\ActivityContract;

class ActivityRepository implements ActivityContract
{

    public function list($data)
    { 
        if(isset($data['is_poll_wise']) && $data['is_poll_wise'] !=null) {
            $res =   ActivityFeed::With(['user_data','get_feed'])->Where('poll_id',$data['poll_id'])->orderBy('id','DESC')->get();
        } else {   
            $user_id = $data['user_id'];
            $res = Poll::where('user_id',$user_id)->select(DB::raw('group_concat(id) as poll_ids'))->first();
            if(!empty($res)){
                $page_id = (isset($data['page_id']) && $data['page_id'] !=null) ? $data['page_id']*10:0;
                $res =   ActivityFeed::With(['user_data','get_feed'])->WhereIn('poll_id',(array)$res['poll_ids'])->skip($page_id)->take(10)->orderBy('id','DESC')->get();
            } else {
                $res = [];
            }   
        }
        return ['result_status'=>1,'data'=>$res];
    }
}