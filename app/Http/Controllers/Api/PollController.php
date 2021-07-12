<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\BaseController;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Poll\PollRequest;
use App\Http\Requests\Api\Poll\RepollRequest;
use App\Http\Requests\Api\Poll\updatePollRequest;
use App\Http\Requests\Api\Poll\setDurationPollRequest;
use App\Http\Requests\Api\PollVote\PollVaoteRequest;
use App\Http\Requests\Api\PollVote\PollInviteRequest;
use App\Http\Requests\Api\PollComment\AddPollCommmentRequest;
use App\Http\Requests\Api\PollComment\getCommentsRequest;

use App\Contracts\PollContract;
use App\Contracts\PollVoteContract;
use App\Contracts\PollCommentContract;

class PollController extends BaseController
{
    protected $pollServices;
    protected $pollVoteServices;
    protected $pollCommentervices;
    public function __construct(PollContract $pollServices,PollVoteContract $pollVoteServices,PollCommentContract $pollCommentervices)
    {
        $this->pollServices = $pollServices;
        $this->pollVoteServices = $pollVoteServices;
        $this->pollCommentervices = $pollCommentervices;
    }

    public function create(PollRequest $request)
    {
    	$data = $request->all();
      $data['id'] = request()->user()->id;

      $res  = $this->pollServices->create($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res[0]);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function get()
    {
        $data['user'] = request()->user();

        $res  = $this->pollServices->getRandomPoll($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function list(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = request()->user()->id;
        $res  = $this->pollServices->list($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function pollDetails(getCommentsRequest $request) 
    {
     $data = $request->all();
     $data['user_id'] = request()->user()->id;
     $res  = $this->pollServices->getSinglePollDetails($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }



    public function pollVote(PollVaoteRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = request()->user()->id;
        $data['user_name'] = request()->user()->user_name;
        $res  = $this->pollVoteServices->create($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }



    public function CommnetOnPoll(AddPollCommmentRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = request()->user()->id;
        $data['user_name'] = request()->user()->user_name;
        $res  = $this->pollCommentervices->create($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function getPollCommnet(getCommentsRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = request()->user()->id;
        $res  = $this->pollCommentervices->list($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }


    public function getRecentPoll(Request $request) 
    {
        $data = $request->all();
        $data['id'] = (isset($request['user_id']) && !empty($request['user_id'])) ? $request['user_id'] : request()->user()->id;
        $data['auth_id'] = request()->user()->id;
        $res  = $this->pollServices->recentPolls($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function getPollResult(getCommentsRequest $request) 
    {
        $data = $request->all();
        $data['user_id'] = request()->user()->id;
        $res  = $this->pollServices->getPollResult($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function endPoll(getCommentsRequest $request) 
    {
        $data = $request->all();
        $data['user_id'] = request()->user()->id;
        $res  = $this->pollServices->endPoll($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }

    }


    public function pollInvite(PollInviteRequest  $request) 
    {
        $data = $request->all();
        $data['auth_id'] = request()->user()->id;
        $data['user_name'] = request()->user()->user_name;
        $res  = $this->pollVoteServices->pollInvite($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function Repoll(RepollRequest  $request) 
    {
        $data = $request->all();
        $data['user_id'] = request()->user()->id;
        $res  = $this->pollServices->Repoll($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }

    }

    public function getPollInvitedUsers(getCommentsRequest  $request) 
    {
        $data = $request->all();
        $data['auth_id'] = request()->user()->id;
        $data['user_name'] = request()->user()->user_name;
        $res  = $this->pollVoteServices->getPollInvitedUsers($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function deletePoll(getCommentsRequest  $request) 
    {
        $data = $request->all();
        $data['auth_id'] = request()->user()->id;
        $res  = $this->pollServices->delete($data['poll_id']);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse($res['data']);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function updatePoll(updatePollRequest  $request) 
    {
        $data = $request->all();
        $data['user_id'] = request()->user()->id;
        $res  = $this->pollServices->updatePollGeneral($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse([]);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }

    public function setDuration(setDurationPollRequest  $request) 
    {
        $data = $request->all();
        $data['user_id'] = request()->user()->id;
        $data['onlySetDuration'] = 1;
        $res  = $this->pollServices->updatePollGeneral($data);
        if($res['result_status']==1) { // Success
            unset($res['result_status']);
            return $this->sendResponse(['current_time'=> \Carbon\Carbon::now()->format('Y-m-d H:i:s')]);
        }
        else { // Other Errors  
            return $this->sendError($res['message'], 422);
        }
    }
}