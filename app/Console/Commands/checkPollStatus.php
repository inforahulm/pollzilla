<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Poll;
class checkPollStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:pollStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this  Cron  Job Check poll Status based  on there Time change  status like  running, completed or  in progress ';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $currentDateTime = \Carbon\Carbon::now()->format('Y-m-d H:i');

        // $res = Poll::whereRaw("TIME_FORMAT(TIMEDIFF(DATE_FORMAT(DATE_ADD(launch_date_time, INTERVAL set_duration MINUTE),'%Y-%m-%d %H:%i:%s'), '".$currentDateTime."'), '%H:%i')")->selectRaw("TIME_FORMAT(TIMEDIFF(DATE_FORMAT(DATE_ADD(launch_date_time, INTERVAL set_duration MINUTE),'%Y-%m-%d %H:%i:%s'), '".$currentDateTime."'), '%H:%i') < '00:00'")
        // ->Orwhere('forever_status',1)
        // ->where('id',33)
        // ->get();
        // dd($res);
        // Upcoming  Poll set as  Running  Status  
        $res = Poll::whereRaw("TIME_FORMAT(TIMEDIFF(launch_date_time, '".$currentDateTime."'), '%H:%i') <= '00:00'")
        ->whereRaw("TIME_FORMAT(TIMEDIFF(DATE_FORMAT(DATE_ADD(launch_date_time, INTERVAL set_duration MINUTE),'%Y-%m-%d %H:%i:%s'), '".$currentDateTime."'), '%H:%i') >= '00:00'")
        ->where('status',1)
        ->whereIn('poll_current_status', [3,43])
        ->get();
        if(count($res)) {
            foreach ($res as $key => $value) {
                $value->poll_current_status = $value->poll_current_status == 3 ? 1 :41;
                $value->save();
            }
        }
        // Running  Status change  as  end  if thaey end   
        $res = Poll::whereRaw("TIME_FORMAT(TIMEDIFF(launch_date_time, '".$currentDateTime."'), '%H:%i') <= '00:00'")
        ->whereRaw("TIME_FORMAT(TIMEDIFF(DATE_FORMAT(DATE_ADD(launch_date_time, INTERVAL set_duration MINUTE),'%Y-%m-%d %H:%i:%s'), '".$currentDateTime."'), '%H:%i') <= '00:00'")
        ->where('status',1)
        ->where('forever_status',0)
        ->get();
        if(count($res)){
            foreach ($res as $key => $value) {
                $value->poll_current_status = $value->poll_current_status == 1 ? 2 :42;
                $value->save();
            }
        }
    }
}
