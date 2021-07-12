<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\AddressBook;
use App\Models\User;
use App\Contracts\AddressBookContract;

class AddressBookRepository implements AddressBookContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    public function create(array $data)
    {   
       
        DB::beginTransaction();
        try {
            $address = AddressBook::create([
                'user_id' => $data['user_id'],
                'contact_user_id' => $data['contact_user_id'],
            ]);

            DB::commit();
            return ['result_status'=>1];
            
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Create Address Book : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }
        
    }

    public function myAddressBook($id)
    {
        $myAddressBook = AddressBook::With('user_details')->Where('user_id', $id)->orderBy('id','DESC')->get();
        $myAddressBook['result_status'] = 1;
        return $myAddressBook;
    }

    public function deleteAddressBook(array $data)
    {
        DB::beginTransaction();
        try {
                AddressBook::where('id',$data['id'])->delete();
                DB::commit();
                return ['result_status'=>1];
            } catch(\Throwable $e) {
                DB::rollBack();
                Log::debug('Delete Address Book : ',[ 'error' =>$e ]);
                return ['result_status'=>0,'message'=>'Something went wrong'];
            }
    }

    public function searchUser(array $data)
    {
        $keyword = $data['keyword'] ? $data['keyword'] : '';
        $page_id = $data['page_id']*10;
        $user_id = $data['user_id'];
        $FollowerFollowing = User::where('status',1)->where('isguest',0)->where(function ($query)  use ($keyword,$user_id) {
                $query->where('user_name', 'LIKE', "%{$keyword}%")
                    ->orWhere('first_name', 'LIKE', "%{$keyword}%");
           })->select('id','user_name','email','first_name','mobile_number','profile_picture')->skip($page_id)->take(10)->orderBy('id', 'desc')->whereNotIn('id', [$user_id])->get();
        $FollowerFollowing['result_status'] = 1;
        return $FollowerFollowing;
    }
}

?>
