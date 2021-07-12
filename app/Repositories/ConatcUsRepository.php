<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\ContactUs;
use App\Models\User;
use App\Contracts\ContactUsContract;

class ConatcUsRepository implements ContactUsContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function create(array $data)
    {   
       
        DB::beginTransaction();
        try {
            $address = ContactUs::create([
                'user_id' => $data['user_id'],
                'subject' => $data['subject'],
                'message' => $data['message'],
                'status' => 1
            ]);

            DB::commit();
            return ['result_status'=>1];
            
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Contact Us : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
        
    }

    public function myContactUs($id)
    {
        $myContactUs = ContactUs::Where('user_id', $id)->get(['id','subject','message','status']);
        $myContactUs['result_status'] = 1;
        return $myContactUs;
    }
}

?>
