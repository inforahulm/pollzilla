<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;
use App\Models\Poll;
use App\Models\PollVote;
use DB;

class DashboardController extends Controller
{
	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		$totalUsers 	= User::where('isguest',0)->count();		
		$totalTodayPoll = User::where('isguest',0)->whereDate('created_at', \Carbon\Carbon::today())->count();
		$totalPoll 		= Poll::count();
		$totalVotedPoll = PollVote::groupBy('poll_id')->count();
		$totalVotedPoll = PollVote::select(DB::raw('count(DISTINCT poll_id) as totalVotedPoll'))->first()['totalVotedPoll'];

		// DB::enableQueryLog();
		// dd(DB::getQueryLog());
		$countsData = [
			'totalUsers'=>$totalUsers,
			'totalPoll'=>$totalPoll,
			'totalTodayPoll'=>$totalTodayPoll,
			'totalVotedPoll'=>$totalVotedPoll
		];

		$leatestUser 	= User::With('getUserVoted','getUserCreatedPoll')->where('isguest',0)->orderBy('id', 'desc')->take(10)->get();
		$leatestPoll 	= Poll::With('categories','subcategories')->orderBy('id', 'desc')->take(10)->get();
		$leatestVotedPoll 	= PollVote::With('getPollDetails','getPollVoter','getPollCreator.pollCreatorUser')->orderBy('id', 'desc')->take(10)->get();
		// dd($leatestVotedPoll);

		return view('admin.dashboard',compact('countsData','leatestUser','leatestPoll','leatestVotedPoll'));
	}

	public function changePassword()
	{
		return view('admin.auth.change-pass');
	}

	public function updatePassword(Request $request)
	{
		$request->validate([
			'old_pass' => 'required',
			'new_pass' => 'required|confirmed|min:6'
		]);
		$id         = Auth::id();
		$selectData = Admin::where('id', $id)->first();
		$password   = $selectData->password;

		if(Hash::check($request->old_pass, $password))
		{
			$newPass        = bcrypt($request->new_pass);
			$updatePassword = Admin::where('id', $id)->update(['password' => $newPass]);
			if($updatePassword)
			{
				Auth::guard('admin')->logout();
				return redirect()->route('admin.login');
			}
			return redirect()->back()->withSuccess('Password Update Successfully...');
		} else {
			return redirect()->back()->withDanger('Old Password does not match with our database');
		}
	}
}
