<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\Image\ImageRequest;
use App\Contracts\PollContract;
use App\Contracts\InterestCategoryContract;
use App\Contracts\SubInterestCategoryContract;
use App\Contracts\ColorPaletteContract;
use App\Contracts\PollCommentContract;
use App\Contracts\ActivityContract;
use App\Contracts\CommonContract;
use App\DataTables\PollsDataTable;
use App\Models\PollAnswer;
use App\Models\PollVote;
use App\Models\Poll;

class PollController extends Controller
{
	protected $pollService;
	protected $interestCategoryService;
	protected $subInterestCategoryService;
	protected $colorPaletteService;
	protected $commonService;

	public function __construct(PollContract $pollService,InterestCategoryContract $interestCategoryService,SubInterestCategoryContract $subInterestCategoryService,ColorPaletteContract $colorPaletteService,PollCommentContract $pollCommentService,ActivityContract $pollActivityService,CommonContract $commonService)
	{
		$this->pollService 					= $pollService;
		$this->interestCategoryService 		= $interestCategoryService;
		$this->subInterestCategoryService 	= $subInterestCategoryService;
		$this->colorPaletteService 			= $colorPaletteService;
		$this->pollCommentService 			= $pollCommentService;
		$this->pollActivityService 			= $pollActivityService;
		$this->commonService 				= $commonService;
	}

	public function index(PollsDataTable $pollDataTable)
	{
		return $pollDataTable->render('admin.poll.index');
	}

	public function delete(Request $request)
	{
		return $this->pollService->delete($request->id);
	}

	public function changeStatus(Request $request)
	{
		$cat = $this->pollService->updateDataWhere($request->all());
		if($cat['result_status']==1) {
			if($request->status== 0)
			{
				$data['msg'] = 'User Inactivated successfully.';
				$data['action'] = 'Inactivated!';
			} else {
				$data['msg'] = 'User Activated successfully.';
				$data['action'] = 'Activated!';
			}
			$data['status'] = 'success';
		} else {

			$data['msg'] = 'Something went wrong';
			$data['action'] = 'Cancelled!';
			$data['status'] = 'error';
		}

		return $data;
	}

	public function endPoll(Request $request)
	{
		$poll = Poll::find($request->id);
		$poll->forever_status = 0;
		$poll->set_duration = 0;
		$poll->poll_time = NULL;
		$poll->poll_current_status = $poll->poll_current_status == 1 ? 2:42; 
		$poll->save();

		$data['msg'] = 'Poll End successfully.';
		$data['action'] = 'Poll End!';
		
		return $data;
	}

	public function edit($id)
	{	
		$currentDateTime = \Carbon\Carbon::now()->format('Y-m-d H:i');
		$id = decryptString($id);
		$InterestCategory 		= $this->interestCategoryService->list([]);
		$subInterestCategory 	= $this->subInterestCategoryService->list([]);
		$colorPalette 			= $this->colorPaletteService->list([]);
		$polls  				= $this->pollService->get($id);
		$PollAnswer 			= PollAnswer::where(['poll_id'=>$id])->get();
		$Pollcount 				= PollVote::where(['poll_id'=>$id])->count();

		$isStartedPoll = Poll::whereRaw("TIME_FORMAT(TIMEDIFF(DATE_FORMAT(DATE_ADD(launch_date_time, INTERVAL set_duration MINUTE),'%Y-%m-%d %H:%i:%s'), '".$currentDateTime."'), '%H:%i') > '00:00'")->selectRaw("TIME_FORMAT(TIMEDIFF(DATE_FORMAT(DATE_ADD(launch_date_time, INTERVAL set_duration MINUTE),'%Y-%m-%d %H:%i:%s'), '".$currentDateTime."'), '%H:%i')")->where('id',$id)->count();
		
		return view('admin.poll.editpoll',compact('InterestCategory','subInterestCategory','colorPalette','polls','PollAnswer','Pollcount','isStartedPoll'));
	}

	public function view($id)
	{	
		$id = decryptString($id);
		$PollDetails = $this->pollService->getSinglePollDetails(['poll_id'=>$id]);
		if(empty($PollDetails))
			return redirect('Admin2020/poll');

		$PollComment = $this->pollCommentService->list(['poll_id'=>$id,'is_all'=>1]);
		$PollActiviyFeed = $this->pollActivityService->list(['poll_id'=>$id,'is_poll_wise'=>1]);
		$PollResult = $this->pollService->getPollResult(['poll_id'=>$id,'is_poll_wise'=>1]);
		$PollDetails = $PollDetails['data'];
		$PollComment = $PollComment['data'];
		$PollResult = $PollResult['data'];

		$ChartsTitle = [];
		$ChartsValue = [];
		if($PollDetails->poll_type_id == 1 ||  $PollDetails->poll_type_id == 2 || $PollDetails->poll_type_id == 3 || $PollDetails->poll_type_id == 6) {
			foreach ($PollResult->poll_answer as $key => $value) {
				$ChartsTitle[]    = $value->poll_text_answer;
				$ChartsValue [] = $value->votting_per;
			}
		}
		if($PollDetails->poll_type_id == 4 || $PollDetails->poll_type_id == 5) {
			foreach ($PollResult->PollVoteResult as $key => $value) {
				$ChartsTitle[]    = $value['answer_value'];
				$ChartsValue [] = $value['votting_per'];
			}
		}
		$PollActiviyFeed = $PollActiviyFeed['data'];
		return view('admin.poll.viewpolldetails',compact('PollDetails','PollComment','PollActiviyFeed','PollResult','ChartsValue','ChartsTitle'));
	}

	public function update(Request $request) {
		$data = $request->all();	
		$data['forever_status']= $data['forever_status'] == 1 ? 1:0;
		$data['set_duration']= $data['forever_status'] == 0 ? $data['set_duration_value']:0;
		$data['is_background_image']= $data['background'] == '' ? 0:1;
		$data['is_web']= 1;
		$poll_answer = [] ;
		// dd($data);
		$no_of_option= $data['no_of_option'];
		for ($i=0; $i < $no_of_option; $i++) { 
			$poll_answer[] = [
				'poll_text_answer'=>$data['poll_text_answer'][$i],
				'answer_index'=>$data['answer_index'][$i],
				'poll_source_answer'=> isset($data['poll_source_answer'][$i]) ? $data['poll_source_answer'][$i] :NULL,
				'video_thumb' => (isset($data['video_thumb'][$i]) && !empty($data['video_thumb'][$i])) ? $data['video_thumb'][$i] :NULL,
				'is_link' => (isset($data['is_link'][$i]) && !empty($data['is_link'][$i])) ? $data['is_link'][$i] :0
			];
		}

		$data['poll_answer'] = $poll_answer;
		// $old_polls = $this->pollService->deletePollAnswer($data);
		$polls = $this->pollService->update($data);		
		if($polls['result_status']==1) {
			// route('admin.poll.edit', encryptString($data['id']));
			return redirect()->route('admin.poll.edit',encryptString($data['id']))->with('success', 'Poll Update Successfully');
		}
		dd($polls);
	}

	public function uploadFile(ImageRequest $request) {
		$res  = $this->commonService->uploadFile($request);
		return $res;
	}
}
