<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\Poll;
use App\Models\PollAnswer;
use App\Models\PollVote;
use App\Models\FollowerFollowing;
use App\Contracts\PollContract;

class PollRepository implements PollContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function create($data)
    {
        $date_time = $launch_date_time= date('Y-m-d H:i:s');
        DB::beginTransaction();
        $poll_current_status = 1;
        $res=[];
        try {
            // Check poll is lunch immdeley or  upccoming poll
            if(isset($data['launch_date_time']) && !empty($data['launch_date_time'])) {
                $startTime = \Carbon\Carbon::parse($data['launch_date_time']);
                $isStarted = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $startTime)->isFuture();
                $poll_current_status = $isStarted == 1 ? 3 : 1;
            }


            $poll = Poll::create([
                'interest_category_id' => $data['interest_category_id'],
                'interest_sub_category_id' => $data['interest_sub_category_id'],
                'generic_title' => $data['generic_title'],
                'poll_type_id' => $data['poll_type_id'],
                'no_of_option' => $data['no_of_option'],
                'color_palette_id' => $data['color_palette_id'],
                'is_light' => $data['is_light'],
                'poll_style_id' => $data['poll_style_id'],
                'background' => $data['background'] ?? NULL,
                'poll_preview' => $data['poll_preview'] ?? NULL,
                'poll_time' => (isset($data['poll_time']) && !empty($data['poll_time'])) ? $data['poll_time'] : NULL,
                'is_theme' => $data['is_theme'] ?? NULL,
                'is_background_image' => $data['is_background_image'],
                'template_id' => $data['template_id'],
                'launch_date_time' => $data['launch_date_time'],
                'forever_status' => $data['forever_status'],
                'set_duration' => $data['set_duration'],
                'poll_privacy' => $data['poll_privacy'],
                'chart_id' => $data['chart_id'],
                'share_status' => $data['share_status'],
                'is_secret' => $data['is_secret'],
                'poll_current_status'=>$poll_current_status,
                'user_id' => $data['id'],
            ]);

            $id = $poll->id;


            $multipledata = array();
            $poll_data = $data['poll_answer'];
            // $poll_data = json_decode($poll_data,true);

            if($poll_data > 0)
            {

                if($data['poll_type_id'] == 1)
                {
                    //Pic One
                    foreach ($poll_data as $key => $value) {
                        $value['poll_id'] = $id;
                        $value['created_at'] = $date_time;
                        $value['updated_at'] = $date_time;
                        $multipledata[$key] = $value;
                    }

                }
                else if($data['poll_type_id'] == 2)
                {
                    //Thumbs Up / Thumbs Down
                    for ($i=0; $i <= 1; $i++) { 
                        $thumbs_data[$i]['poll_display_answer'] = $i ? 'Thumbs Down' : 'Thumbs Up';
                        $thumbs_data[$i]['poll_id'] = $id;
                        $thumbs_data[$i]['poll_text_answer'] = $poll_data[0]['poll_text_answer'];
                        $thumbs_data[$i]['poll_source_answer'] = $poll_data[0]['poll_source_answer'];
                        $thumbs_data[$i]['media_type']  = $poll_data[0]['media_type'];
                        $thumbs_data[$i]['video_thumb'] = (isset($poll_data[0]['video_thumb']) && !empty($poll_data[0]['video_thumb'])) ? $poll_data[0]['video_thumb'] :NULL;
                        $thumbs_data[$i]['is_link']     = (isset($poll_data[0]['is_link']) && !empty($poll_data[0]['is_link'])) ? $poll_data[0]['is_link'] :0;
                        $thumbs_data[$i]['media_type'] = $poll_data[0]['media_type'];
                        $thumbs_data[$i]['answer_index'] = $poll_data[0]['answer_index'];
                        $thumbs_data[$i]['created_at'] = $date_time;
                        $thumbs_data[$i]['updated_at'] = $date_time;
                    }
                    $multipledata = $thumbs_data;
                }
                else if($data['poll_type_id'] == 3)
                {
                    //Yes / No
                    for ($i=0; $i <= 1; $i++) { 
                        $thumbs_data[$i]['poll_display_answer'] = $i ? 'No' : 'Yes';
                        $thumbs_data[$i]['poll_id'] = $id;
                        $thumbs_data[$i]['poll_text_answer'] = $poll_data[0]['poll_text_answer'];
                        $thumbs_data[$i]['poll_source_answer'] = $poll_data[0]['poll_source_answer'];
                        $thumbs_data[$i]['media_type'] = $poll_data[0]['media_type'];
                        $thumbs_data[$i]['video_thumb'] = (isset($poll_data[0]['video_thumb']) && !empty($poll_data[0]['video_thumb'])) ? $poll_data[0]['video_thumb'] :NULL;
                        $thumbs_data[$i]['is_link']     = (isset($poll_data[0]['is_link']) && !empty($poll_data[0]['is_link'])) ? $poll_data[0]['is_link'] :0;
                        $thumbs_data[$i]['answer_index'] = $poll_data[0]['answer_index'];
                        $thumbs_data[$i]['created_at'] = $date_time;
                        $thumbs_data[$i]['updated_at'] = $date_time;
                    }
                    $multipledata = $thumbs_data;

                }
                else if($data['poll_type_id'] == 4)
                {
                    //Heat-O-Meter
                    $multipledata = [
                        'poll_id' => $id,
                        'created_at' => $date_time,
                        'updated_at' => $date_time,
                        'poll_text_answer' => 100,
                        'poll_source_answer' => $poll_data[0]['poll_source_answer']??NULL,
                        'video_thumb' => $poll_data[0]['video_thumb'] ?? NULL,
                        'media_type' => $poll_data[0]['media_type']

                    ];

                }
                else if($data['poll_type_id'] == 5)
                {
                    //Rank In Order
                    foreach ($poll_data as $key => $value) {
                        $value['poll_id'] = $id;
                        $value['created_at'] = $date_time;
                        $value['updated_at'] = $date_time;
                        $multipledata[$key] = $value;
                    }

                }
                else if($data['poll_type_id'] == 6)
                {
                    //Sorting(Rename Rating)
                    for ($i=0; $i <= 9; $i++) {

                        $count = 1;
                        $count = ($count+$i)/2; 
                        if($count <= 0.5)
                        {
                            continue;
                        }

                        $thumbs_data[$i]['poll_display_answer'] = $count;
                        $thumbs_data[$i]['poll_id'] = $id;
                        $thumbs_data[$i]['poll_text_answer'] = $poll_data[0]['poll_text_answer'];
                        $thumbs_data[$i]['poll_source_answer'] = $poll_data[0]['poll_source_answer'];
                        $thumbs_data[$i]['video_thumb'] = (isset($poll_data[0]['video_thumb']) && !empty($poll_data[0]['video_thumb'])) ? $poll_data[0]['video_thumb'] :NULL;
                        $thumbs_data[$i]['is_link']     = (isset($poll_data[0]['is_link']) && !empty($poll_data[0]['is_link'])) ? $poll_data[0]['is_link'] :0;
                        $thumbs_data[$i]['answer_index'] = $poll_data[0]['answer_index'];
                        $thumbs_data[$i]['created_at'] = $date_time;
                        $thumbs_data[$i]['updated_at'] = $date_time;

                    }

                    $multipledata = $thumbs_data;

                }

                try {
                    $poll = PollAnswer::insert($multipledata);
                    DB::commit();
                    $res = Poll::With(['user_data','color_palette_data','categories','subcategories','poll_answer'])->where('id',$id)->first();
                    Log::debug('Create Poll Success: ',[ 'data' =>json_encode($data)]);
                } catch(\Throwable $e) {
                    DB::rollBack();
                    Log::debug('Create Poll Answer : ',[ 'error' =>$e ]);
                    return ['result_status'=>0,'message'=>'Something went wrong'];
                }    
            }


            return ['result_status'=>1,$res];

        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Create Poll : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
    }

    public function list($data)
    { 
        if(isset($data['is_all']) && $data['is_all'] == 1){
            $res =   Poll::where('user_id',$data['user_id'])->orderBy('id','DESC')->get();
        } else {
            $page_id = (isset($data['page_id']) && $data['page_id'] !=null) ? $data['page_id']*10:0;
            $res =   Poll::With(['categories','subcategories'])->where('user_id',$data['user_id'])->orderBy('id','DESC')->skip($page_id)->take(10)->get();
        }
        return ['result_status'=>1,'data'=>$res];
    }

    public function get(int $id)
    {
        return Poll::find($id);
    }



    public function update($data)
    {
        // dd($data);
        $id =$data['id'];
        $date_time = $launch_date_time= date('Y-m-d H:i:s');
        DB::beginTransaction();
        $poll_current_status = 1;
        try {
            // Check poll is lunch immdeley or  upccoming poll
            if(isset($data['launch_date_time']) && !empty($data['launch_date_time'])) {
                $startTime = \Carbon\Carbon::parse($data['launch_date_time']);
                $isStarted = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $startTime)->isFuture();
                $poll_current_status = $isStarted == 1 ? 3 : 1;
            }

            $poll =[
                'interest_category_id' => $data['interest_category_id'],
                'interest_sub_category_id' => $data['interest_sub_category_id'],
                'generic_title' => $data['generic_title'],
                'poll_type_id' => $data['poll_type_id'],
                'no_of_option' => $data['no_of_option'],
                'color_palette_id' => $data['color_palette_id'],
                'is_light' => $data['is_light'],
                'poll_style_id' => $data['poll_style_id'],
                'background' => $data['background'] ?? NULL,
                'poll_time' => $data['poll_time'] ?? NULL,
                'is_background_image' => $data['is_background_image'],
                'template_id' => $data['template_id'],
                'launch_date_time' => $data['launch_date_time'],
                'forever_status' => $data['forever_status'],
                'set_duration' => $data['set_duration'],
                'poll_privacy' => $data['poll_privacy'],
                'chart_id' => $data['chart_id'],
                'share_status' => $data['share_status'],
                'is_secret' => $data['is_secret'],
                'poll_current_status'=>$poll_current_status
            ];
            Poll::where('id',$data['id'])->update($poll);

            $multipledata = array();
            $poll_data = $data['poll_answer'];
        // $poll_data = json_decode($poll_data,true);

            if($poll_data > 0)
            {

                if($data['poll_type_id'] == 1)
                {
                    //Pic One
                    foreach ($poll_data as $key => $value) {
                        $value['poll_id'] = $id;
                        $value['created_at'] = $date_time;
                        $value['updated_at'] = $date_time;
                        $multipledata[$key] = $value;
                    }

                }
                else if($data['poll_type_id'] == 2)
                {
                    //Thumbs Up / Thumbs Down
                    for ($i=0; $i <= 1; $i++) { 
                        $thumbs_data[$i]['poll_display_answer'] = $i ? 'Down' : 'Up';
                        $thumbs_data[$i]['poll_id'] = $id;
                        $thumbs_data[$i]['poll_text_answer'] = $poll_data[0]['poll_text_answer'];
                        $thumbs_data[$i]['poll_source_answer'] = $poll_data[0]['poll_source_answer'];
                        $thumbs_data[$i]['video_thumb'] = (isset($poll_data[0]['video_thumb']) && !empty($poll_data[0]['video_thumb'])) ? $poll_data[0]['video_thumb'] :NULL;
                        $thumbs_data[$i]['is_link']     = (isset($poll_data[0]['is_link']) && !empty($poll_data[0]['is_link'])) ? $poll_data[0]['is_link'] :0;
                        $thumbs_data[$i]['answer_index'] = $poll_data[0]['answer_index'];
                        $thumbs_data[$i]['created_at'] = $date_time;
                        $thumbs_data[$i]['updated_at'] = $date_time;
                    }
                    $multipledata = $thumbs_data;
                }
                else if($data['poll_type_id'] == 3)
                {
                    //Yes / No
                    for ($i=0; $i <= 1; $i++) { 
                        $thumbs_data[$i]['poll_display_answer'] = $i ? 'No' : 'Yes';
                        $thumbs_data[$i]['poll_id'] = $id;
                        $thumbs_data[$i]['poll_text_answer'] = $poll_data[0]['poll_text_answer'];
                        $thumbs_data[$i]['poll_source_answer'] = $poll_data[0]['poll_source_answer'];
                        $thumbs_data[$i]['video_thumb'] = (isset($poll_data[0]['video_thumb']) && !empty($poll_data[0]['video_thumb'])) ? $poll_data[0]['video_thumb'] :NULL;
                        $thumbs_data[$i]['is_link']     = (isset($poll_data[0]['is_link']) && !empty($poll_data[0]['is_link'])) ? $poll_data[0]['is_link'] :0;
                        $thumbs_data[$i]['answer_index'] = $poll_data[0]['answer_index'];
                        $thumbs_data[$i]['created_at'] = $date_time;
                        $thumbs_data[$i]['updated_at'] = $date_time;
                    }
                    $multipledata = $thumbs_data;

                }
                else if($data['poll_type_id'] == 4)
                {
                    //Heat-O-Meter
                    $multipledata = [
                        'poll_id' => $id,
                        'created_at' => $date_time,
                        'updated_at' => $date_time,
                        'poll_text_answer' => 100,
                        'poll_source_answer' => $poll_data[0]['poll_source_answer']??NULL,
                        'video_thumb' => $poll_data[0]['video_thumb'] ?? NULL
                    ];

                }
                else if($data['poll_type_id'] == 5)
                {
                    //Rank In Order
                    foreach ($poll_data as $key => $value) {
                        $value['poll_id'] = $id;
                        $value['created_at'] = $date_time;
                        $value['updated_at'] = $date_time;
                        $multipledata[$key] = $value;
                    }

                }
                else if($data['poll_type_id'] == 6)
                {
                    //Sorting(Rename Rating)
                    for ($i=0; $i <= 9; $i++) {

                        $count = 1;
                        $count = ($count+$i)/2; 
                        if($count <= 0.5)
                        {
                            continue;
                        }

                        $thumbs_data[$i]['poll_display_answer'] = $count;
                        $thumbs_data[$i]['poll_id'] = $id;
                        $thumbs_data[$i]['poll_text_answer'] = $poll_data[0]['poll_text_answer'];
                        $thumbs_data[$i]['poll_source_answer'] = $poll_data[0]['poll_source_answer'];
                        $thumbs_data[$i]['video_thumb'] = (isset($poll_data[0]['video_thumb']) && !empty($poll_data[0]['video_thumb'])) ? $poll_data[0]['video_thumb'] :NULL;
                        $thumbs_data[$i]['is_link']     = (isset($poll_data[0]['is_link']) && !empty($poll_data[0]['is_link'])) ? $poll_data[0]['is_link'] :0;
                        $thumbs_data[$i]['answer_index'] = $poll_data[0]['answer_index'];
                        $thumbs_data[$i]['created_at'] = $date_time;
                        $thumbs_data[$i]['updated_at'] = $date_time;

                    }

                    $multipledata = $thumbs_data;

                }

                try {
                    PollAnswer::where('poll_id',$data['id'])->delete();
                    $poll = PollAnswer::insert($multipledata);
                    DB::commit();
                } catch(\Throwable $e) {
                    DB::rollBack();
                    Log::debug('Create Poll Answer : ',[ 'error' =>$e ]);
                    return ['result_status'=>0,'message'=>'Something went wrong'];
                }    
            }


            return ['result_status'=>1];

        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Create Poll : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
    }

    public function getRandomPoll($data) 
    {
        $currentDateTime = \Carbon\Carbon::now()->format('Y-m-d H:i:s');
        // dd($currentDateTime);

        // Get User Votted Poll Ids
        $res = PollVote::where('user_id',$data['user']['id'])->select(DB::raw('group_concat(poll_id) as poll_ids'))->first();
        $already_view_poll = [];
        if(!empty($res['poll_ids'])){
            $already_view_poll =  explode(',',$res['poll_ids']);
        }

        $res = Poll::With(['user_data','color_palette_data','categories','subcategories','poll_answer'])
        ->whereIn('interest_sub_category_id', explode(',',$data['user']['interest_sub_category_ids']))
        ->where('status',1)
        ->whereIn('poll_current_status',[1,41])
        // ->whereNotIn('user_id',[$data['user']['id']])
        ->whereRaw("TIME_FORMAT(TIMEDIFF(launch_date_time, '".$currentDateTime."'), '%H:%i') <= '00:00'")
        ->whereRaw("TIME_FORMAT(TIMEDIFF(DATE_FORMAT(DATE_ADD(launch_date_time, INTERVAL set_duration MINUTE),'%Y-%m-%d %H:%i:%s'), '".$currentDateTime."'), '%H:%i') >= '00:00'")
        ->orWhere('forever_status',1);

        if(!empty($already_view_poll)) {
            $res = $res->WhereNotIn('id',$already_view_poll);
        }
        $res = $res->inRandomOrder()->first();


        // check Wether user Following  or not 
        if(!empty($res)){
            if($res['poll_privacy'] == 1) {
                $is_following =  FollowerFollowing::where('follower_id',$data['user']['id'])->where('following_id',$res['user_id'])->exists();
                if(!$is_following) {
                    $res = (object)[];
                } 
            }
        }
        // check is poll  scerect  remove  user data  
        
        
        return ['result_status'=>1,'data'=>$res];

    }

    public function getSinglePollDetails($data) 
    {
        $res =   Poll::With(['categories','subcategories','poll_answer','user_data','color_palette_data'])->withCount(['pollVotting','pollComment','pollInvite'])->where('id',$data['poll_id'])->first();
        return ['result_status'=>1,'data'=>$res];
    }

    public function recentPolls($data) 
    {
        $page_id = (isset($data['page_id']) && $data['page_id'] !=null) ? $data['page_id']*10:0;
        if($data['id'] == $data['auth_id']) {   
            $followingId =  FollowerFollowing::where('follower_id',$data['auth_id'])->select(DB::raw('group_concat(following_id) as user_ids'))->first()['user_ids'];
            if(!empty($followingId)) {
                $res = Poll::with('user_data')->whereIn('user_id',explode(',',($followingId.','.$data['id'])));
            } else {
                $res = Poll::with('user_data')->where('user_id',$data['id']);
            }
            $res = $res->select('id','user_id','generic_title','poll_type_id','created_at','poll_style_id')->skip($page_id)->take(10)->orderBy('id','DESC')->get();
        } else {

        // check other  following  to auth user or not 
            $is_following =  FollowerFollowing::where('follower_id',$data['auth_id'])->where('following_id',$data['id'])->exists();

            // if($is_following) {
            //     // Get Public and Private but not secret poll
            //     $res = Poll::where('user_id',$data['id'])->select('id','user_id','generic_title','poll_type_id','created_at')->where('is_secret',0)->skip($page_id)->take(10)->orderBy('id','DESC')->get();
            // } else {
            //      // Get Only Public Poll and not secret poll
            //     $res = Poll::where('user_id',$data['id'])->where('is_secret',0)->where('poll_privacy',1)->select('id','user_id','generic_title','poll_type_id','created_at')->skip($page_id)->take(10)->orderBy('id','DESC')->get();
            // }


            if($is_following) {
                // Get Public and Private but not secret poll
                $res = Poll::with('user_data')->where('user_id',$data['id'])->select('id','user_id','generic_title','poll_type_id','created_at')->where('is_secret',0)->skip($page_id)->take(10)->orderBy('id','DESC')->get();
            } else {
                 // Get Only Public Poll and not secret poll
                $res = Poll::with('user_data')->where('user_id',$data['id'])->where('is_secret',0)->where('poll_privacy',1)->select('id','user_id','generic_title','poll_type_id','created_at')->skip($page_id)->take(10)->orderBy('id','DESC')->get();
            }
        }

        return ['result_status'=>1,'data'=>$res];
    }


    public function getPollResult($data) 
    {

        $FinalResponse = Poll::With(['user_data','poll_answer','color_palette_data'])->where('id',$data['poll_id'])->first();

        // 1 = Pic One, 2 = Thumbs Up / Thumbs Down, 3 = Yes / No, 4 = Heat-O-Meter, 5 = Rank In Order, 6 = Sorting (ratting)
        if($FinalResponse->poll_type_id == 1 ||  $FinalResponse->poll_type_id == 2 || $FinalResponse->poll_type_id == 3 || $FinalResponse->poll_type_id == 6) {
            $total_vote         = 0;
            $total_answer       = count($FinalResponse->poll_answer);
            $arr                = json_decode(json_encode($FinalResponse->poll_answer),true);
            $total_vote         = array_sum(array_map(function($item) { return $item['answer_count']; }, $arr));
            $FinalResponse['total_vote']  = $total_vote;
            foreach ($FinalResponse->poll_answer as $key => $value) {     
                $per = ($value->answer_count*100);
                $FinalResponse->poll_answer[$key]['votting_per']= $per!=0 ? (float)number_format(($per/$total_vote),2):0;
            }
        }
        if($FinalResponse->poll_type_id == 4) {
            $poll_answer = [];
            $poll_answer[0]=$pollVotting =PollVote::where('poll_id',$data['poll_id'])->whereBetween('other_answer',[0,20])->get()->count();
            $poll_answer[1]=$pollVotting =PollVote::where('poll_id',$data['poll_id'])->whereBetween('other_answer',[21,40])->get()->count();
            $poll_answer[2]=$pollVotting =PollVote::where('poll_id',$data['poll_id'])->whereBetween('other_answer',[41,60])->get()->count();
            $poll_answer[3]=$pollVotting =PollVote::where('poll_id',$data['poll_id'])->whereBetween('other_answer',[61,80])->get()->count();
            $poll_answer[4]=$pollVotting =PollVote::where('poll_id',$data['poll_id'])->whereBetween('other_answer',[81,100])->get()->count();
            $total_vote = array_sum($poll_answer);
            $poll_result = [
                [
                    'answer_count'=>$poll_answer[0],
                    'answer_value'=>'0-20',
                    'votting_per'=>0
                ],
                [
                    'answer_count'=>$poll_answer[1],
                    'answer_value'=>'21-40',
                    'votting_per'=>0
                ],
                [
                    'answer_count'=>$poll_answer[2],
                    'answer_value'=>'41-60',
                    'votting_per'=>0
                ],
                [
                    'answer_count'=>$poll_answer[3],
                    'answer_value'=>'61-80',
                    'votting_per'=>0
                ],
                [
                    'answer_count'=>$poll_answer[4],
                    'answer_value'=>'81-100',
                    'votting_per'=>0
                ]
            ];
            foreach ($poll_result as $key => $value) {
                $per = ($value['answer_count']*100);
                $poll_result[$key]['votting_per']=$per!=0 ? (float)number_format(($per/$total_vote),2):0;
            }
            $FinalResponse['PollVoteResult'] = $poll_result;
        }


        if($FinalResponse->poll_type_id == 5) { 

            $poll_result = [];
            $total_vote = PollVote::where('poll_id',$data['poll_id'])->count();
            $pollVotting =PollVote::where('poll_id',$data['poll_id'])->get()->groupBy('other_answer');

            foreach ($pollVotting as $key => $value) {
                $per = (count($value)*100);
                $poll_result[] = [
                    'answer_count'=>count($value),
                    'answer_value'=>$key,
                    'votting_per'=> $per!=0 ? (float)number_format(($per/$total_vote),2):0
                ];
            }
            $FinalResponse['PollVoteResult'] = $poll_result;
        }
        return ['result_status'=>1,'data'=>$FinalResponse];
    }

    public function endPoll($data) 
    {
        $poll = $this->get($data['poll_id']);
        DB::beginTransaction();
        try {
            $poll->forever_status = 0;
            $poll->set_duration = 0;
            $poll->poll_time = NULL;
            $poll->poll_current_status = $poll->poll_current_status == 1 ? 2:42;             
            $poll->save();

            DB::commit();
            return ['result_status'=>1,'data'=>[]];

        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('End Poll : ',[ 'error' =>$e ]);
            return ['result_status'=>2,'message'=>"please try again".$e];
        }

        return ['result_status'=>1,'data'=>$res];
    }

    public function updateDataWhere($data)
    {
        DB::beginTransaction();
        try {
            $poll =$this->get($data['id']);

            if($poll) {
                $poll->status     =   $data['status'];
                $poll->save();
                DB::commit();
                return [
                    'result_status'=>1
                ];
            }
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Poll status change : ',[ 'error' =>$e ]);
            return ['result_status'=>2,'message'=>"please try again"];
        }
    }

    public function Repoll($data)
    {
        DB::beginTransaction();
        try {
            $poll =$this->get($data['poll_id']);

            // Check poll is lunch immdeley or  upccoming poll
            $launch_date_time= date('Y-m-d H:i:s');
            $poll_current_status = 41;
            $startTime = \Carbon\Carbon::parse($data['launch_date_time']);
            $isStarted = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $startTime)->isFuture();
            $poll_current_status = $isStarted == 1 ? 43 : 1;

            if($poll) {
                $poll->status = 1;
                $poll->poll_current_status = $poll_current_status;
                $poll->repoll_count = $poll->repoll_count + 1;
                $poll->save();
                DB::commit();

                return ['result_status'=>1,'data'=>[]];
            }
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Poll status change : ',[ 'error' =>$e ]);
            return ['result_status'=>2,'message'=>"please try again"];
        }
    }

    public function deletePollAnswer(array $data)
    {
        DB::beginTransaction();
        try {
            PollAnswer::where('poll_id',$data['id'])->delete();
            DB::commit();
            return ['result_status'=>1];
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Delete Poll Answer : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
    }

    public function delete($id) 
    {
        DB::beginTransaction();
        try {
            $count  = PollVote::where('poll_id',$id)->count();
            if($count==0){

                $PollAnswer = PollAnswer::where('poll_id',$id)->get();
                $Poll = Poll::where('id',$id)->first();
                foreach ($PollAnswer as $key => $value) {
                    if(!empty($value->poll_source_answer)){   
                        $image = $value->getRawOriginal('poll_source_answer');
                        if(file_exists(public_path('storage/uploads/poll/'.$image))){
                            @unlink(public_path('storage/uploads/poll/'.$image));                       
                        }    
                    }
                }
                if(!empty($Poll->background)) {
                    $image = $value->getRawOriginal('background');
                    if(file_exists(public_path('storage/uploads/poll/'.$image))){
                        @unlink(public_path('storage/uploads/poll/'.$image));                       
                    } 
                }

                PollAnswer::where('poll_id',$id)->delete();
                Poll::where('id',$id)->delete();

                DB::commit();
                return ['result_status'=>1,'data'=>[]];
            } else {
                return ['result_status'=>0,'message'=>"you can't delete this poll already votted "];
            }
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Delete Poll Answer : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
    }

    public function updatePollGeneral($data) 
    {
        // dd($data);
        DB::beginTransaction();
        try {
            $poll_current_status = 1;
             // Check poll is lunch immdeley or  upccoming poll
            if(isset($data['launch_date_time']) && !empty($data['launch_date_time'])) {
                $startTime = \Carbon\Carbon::parse($data['launch_date_time']);
                $isStarted = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $startTime)->isFuture();
                $poll_current_status = $isStarted == 1 ? 3 : 1;
            }
            $poll=[];
            if(isset($data['onlySetDuration']) && $data['onlySetDuration'] == 1) {
                $poll =[
                    'set_duration' => $data['set_duration'],
                    'poll_time' => $data['poll_time'] ?? NULL,
                    'forever_status' => $data['forever_status'],
                    'poll_current_status'=>$poll_current_status
                ];
            } else {   
                $poll =[
                    'interest_category_id' => $data['interest_category_id'],
                    'interest_sub_category_id' => $data['interest_sub_category_id'],
                    'generic_title' => $data['generic_title'],
                    'poll_time' => $data['poll_time'] ?? NULL,
                    'launch_date_time' => $data['launch_date_time'],
                    'forever_status' => $data['forever_status'],
                    'set_duration' => $data['set_duration'],
                    'poll_privacy' => $data['poll_privacy'],
                    'chart_id' => $data['chart_id'],
                    'share_status' => $data['share_status'],
                    'is_secret' => $data['is_secret'],
                    'poll_current_status'=>$poll_current_status
                ];
            }
            $res = Poll::where('id',$data['poll_id'])->update($poll);

            DB::commit();
            return ['result_status'=>1];

        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Delete Poll Answer : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
    }
}