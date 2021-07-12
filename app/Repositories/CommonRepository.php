<?php
namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail;
use App\Models\User;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\ReportAbuse;
use App\Models\ReportCategories;
use App\Contracts\CommonContract;
use File;
use Webp;
use VideoThumbnail;


class CommonRepository implements CommonContract
{
    # Note : extends BaseRepository for basic functionality 
    #       : if you want to change in existing function then only override existing function here else no need to define any function here.

    // public function get(int $id)
    // {
    //     return User::findOrFail($id);
    // }

    public function countryList()
    {
    	return Country::where('status',1)->get();
    }
    
    public function stateList(array $data)
    {
    	return State::where('status',1)->where('country_id',$data['country_id'])->get();
    }

    public function cityList(array $data)
    {
    	return City::where('status',1)->where('state_id',$data['state_id'])->get();
    }

    public function uploadFile($data)
    {
        // dd($data);
        Log::debug('Uploads Data : ',[ 'data' =>$data ]);

        if($data->has('type') && !is_null($data->type)){
            $type=$data->type;
            if($data->file('file')->isValid()){
            
                $avatarMedia = $data->file('file');
                $strippedName = str_replace(' ', '', $avatarMedia->getClientOriginalName());
                $fileName = $data->file('file')->hashName();
                $thumbName=null;
                $full_thumbnail_url=null;

                if($type == 1)
                {
                    // Audio Upload
                    $StorageLocation = storage_path('app/public'). DIRECTORY_SEPARATOR .'uploads/poll' . DIRECTORY_SEPARATOR;
                    File::isDirectory($StorageLocation) or File::makeDirectory($StorageLocation, 0777, true, true);

                    \Storage::disk('local')->put('/public/uploads/poll/'.$fileName, file_get_contents($avatarMedia));
                    $full_url=asset('storage/uploads/poll').'/'.$fileName;
                    if($data->has('thumbnail') && $data->file('thumbnail')->isValid()) {
                        $thumbName    = explode('.',$fileName)[0].'.webp';
                        $avatarMedia  = $data->file('thumbnail');
                        $webp = Webp::make($avatarMedia);

                        if ($webp->save($StorageLocation.$thumbName)) {
                            $full_thumbnail_url = asset('storage/uploads/poll').'/'.$thumbName;
                        } else {
                            return ['result_status'=>0,'message'=>'Please uploads valid file'];
                        }
                    }
                }
                else if($type == 2)
                {
                    // Video Upload
                    $StorageLocation = storage_path('app/public'). DIRECTORY_SEPARATOR .'uploads/poll' . DIRECTORY_SEPARATOR;
                    File::isDirectory($StorageLocation) or File::makeDirectory($StorageLocation, 0777, true, true);
                    \Storage::disk('local')->put('/public/uploads/poll/'.$fileName, file_get_contents($avatarMedia));

                    $full_url=asset('storage/uploads/poll').'/'.$fileName;
                    $thumbName = time().'.jpg';
                    VideoThumbnail::createThumbnail($StorageLocation.$fileName, $StorageLocation,$thumbName, 2, 1920, 1080);
                    $full_thumbnail_url = asset('storage/uploads/poll').'/'.$thumbName;
                    
                    // if(file_exists($StorageLocation.$fileName)) {
                    //     $thumbName    = explode('.',$fileName)[0].'.webp';
                    //     $webp = Webp::make($StorageLocation.$fileName);

                    //     if ($webp->save($StorageLocation.$thumbName)) {
                    //         $full_thumbnail_url = asset('storage/uploads/poll').'/'.$thumbName;
                    //     } else {
                    //         return ['result_status'=>0,'message'=>'Please uploads valid file'];
                    //     }
                    // }
                }
                else if($type == 3)
                {

                    //user profile image
                    $fileName = uniqid().time().'.webp';
                    $StorageLocation = storage_path('app/public'). DIRECTORY_SEPARATOR .'uploads/user' . DIRECTORY_SEPARATOR;

                    File::isDirectory($StorageLocation) or File::makeDirectory($StorageLocation, 0777, true, true);
                    $webp = Webp::make($avatarMedia);
                    // dd($StorageLocation);

                    if ($webp->save($StorageLocation.$fileName)) {
                        $full_url=asset('storage/uploads/user').'/'.$fileName;
                    } else {
                        return ['result_status'=>0,'message'=>'Please uploads valid file'];
                    }

                }
                else if($type == 4)
                {

                    //group profile image
                    $fileName = uniqid().time().'.webp';
                    
                    $StorageLocation = storage_path('app/public'). DIRECTORY_SEPARATOR .'uploads/group' . DIRECTORY_SEPARATOR;
                    File::isDirectory($StorageLocation) or File::makeDirectory($StorageLocation, 0777, true, true);
                    $webp = Webp::make($avatarMedia);

                    if ($webp->save($StorageLocation.$fileName)) {
                        $full_url=asset('storage/uploads/group').'/'.$fileName;
                    } else {
                        return ['result_status'=>0,'message'=>'Please uploads valid file'];
                    }
                }
                else if($type == 5) 
                {
                    // Poll Backgourd Image
                    $fileName = uniqid().time().'.webp';
                    $StorageLocation = storage_path('app/public'). DIRECTORY_SEPARATOR .'uploads/poll' . DIRECTORY_SEPARATOR;
                    File::isDirectory($StorageLocation) or File::makeDirectory($StorageLocation, 0777, true, true);
                    $webp = Webp::make($avatarMedia);

                    if ($webp->save($StorageLocation.$fileName)) {
                        $full_url=asset('storage/uploads/poll').'/'.$fileName;
                    } else {
                        return ['result_status'=>0,'message'=>'Please uploads valid file'];
                    }
                }
                else if($type == 6) 
                {
                    // Poll Answer Image
                    $fileName = uniqid().time().'.webp';
                    $StorageLocation = storage_path('app/public'). DIRECTORY_SEPARATOR .'uploads/poll' . DIRECTORY_SEPARATOR;
                    File::isDirectory($StorageLocation) or File::makeDirectory($StorageLocation, 0777, true, true);
                    $webp = Webp::make($avatarMedia);

                    if ($webp->save($StorageLocation.$fileName)) {
                        $full_url=asset('storage/uploads/poll').'/'.$fileName;
                    } else {
                        return ['result_status'=>0,'message'=>'Please uploads valid file'];
                    }
                }
                // elseif($type == 5){
                //     // post images and videos
                //     \Storage::disk('local')->put('/public/uploads/post/' . $photoName, file_get_contents($avatarMedia));
                //     $full_url=asset('storage/uploads/post').'/'.$photoName;
                //     if($request->has('thumbnail') && $request->file('thumbnail')->isValid()) {
                //         $avatarMedia  = $request->file('thumbnail');
                //         $strippedName = str_replace(' ', '', $avatarMedia->getClientOriginalName());
                //         $thumbName    = time().'_'.$strippedName;
                //         \Storage::disk('local')->put('/public/uploads/post/thumbnail/'.$thumbName, file_get_contents($avatarMedia));
                //         $full_thumbnail_url = asset('storage/uploads/post/thumbnail').'/'.$thumbName;
                //     }

                // }

                return ['file' => $fileName,'full_url'=>$full_url,'full_thumbnail_url'=>$full_thumbnail_url,'thumbName'=>$thumbName];
            }
            return ['result_status'=>0,'message'=>'Please uploads valid file']; 
        }else{
            return ['result_status'=>0,'message'=>'Validation Error']; 
        }
    }

    public function reportAbuse($data)
    {
        try {

            DB::beginTransaction();
            $res = ReportAbuse::where('poll_id',$data['poll_id'])->where('user_id',$data['user_id'])->first();
            if(empty($res)){
                ReportAbuse::create([
                    'poll_id' => $data['poll_id'],
                    'user_id' => $data['user_id'],
                    'report_categories_id' => $data['report_categories_id'],
                    'created_at'  => date('Y-m-d H:i:s')  
                ]);
                DB::commit();
                return ['result_status'=>1,'data'=>[]];
            } else {
                return ['result_status'=>2,'message'=>'Already Reported on this poll'];    
            }
        } catch(\Throwable $e) {
            DB::rollBack();
            Log::debug('Poll Reported : ',[ 'error' =>$e ]);
            return ['result_status'=>0,'message'=>'Something went wrong'];
        }    
    }

    public function getReportAbuseCat()
    {
        return ReportCategories::get();
    }
}

?>
